<?php
include_once('./_common.php');

$g5['title'] = '검색 결과';

include_once('./_head.php');

$search_table = array();
$table_index = 0;
$write_pages = "";
$text_stx = "";
$srows = 0;

$stx = isset($_GET['stx']) ? $_GET['stx'] : '';
$stx = strip_tags($stx);
$stx = get_search_string($stx);
$stx = trim($stx);

if ($stx) {

    // 한 페이지에 출력할 검색 결과 수
    $srows = isset($_GET['srows'])
        ? (int)preg_replace('#[^0-9]#', '', $_GET['srows'])
        : 10;

    if (!$srows) {
        $srows = 10;
    }

    /*
     * --------------------------------------------------
     * 검색 대상 게시판
     * --------------------------------------------------
     *
     * messages 게시판 하나만 검색한다.
     *
     * 실제 메세지 게시판의 bo_table 값이
     * messages가 아니라면 이 값을 실제 값으로 변경.
     */
    $g5_search['tables'] = array('messages');
    $g5_search['read_level'] = array(1);

    $text_stx = get_text(stripslashes($stx));

    /*
     * 검색 URL
     *
     * 기존 GnuBoard의 sfl, sop은 사용하지 않는다.
     */
    $search_query = 'stx=' . urlencode($stx);


    /*
     * --------------------------------------------------
     * 검색 조건
     * --------------------------------------------------
     *
     * 숫자만 입력
     * → 작성자 ID(mb_id) 검색
     * → 전체공개(wr_1 = 1)인 글만 검색
     * → 날짜명대사(wr_2=1), 이벤트명대사(wr_3=1) 제외
     *
     * 영문 + 숫자
     * → 발신인 코드(wr_4) 검색
     * → 이벤트명대사(wr_3=1)인 글만 노출
     *   (날짜명대사 wr_2=1 는 발신자 검색에서 제외)
     */

    if (preg_match('/^[0-9]+$/', $stx)) {

        // 숫자 검색 → mb_id 기반, 전체공개 일반 메세지만
        $sql_search = "
            mb_id = '" . sql_escape_string($stx) . "'
            AND wr_1 = '1'
            AND (wr_2 = '0' OR wr_2 IS NULL OR wr_2 = '')
            AND (wr_3 = '0' OR wr_3 IS NULL OR wr_3 = '')
        ";

    } elseif (preg_match('/^[a-zA-Z0-9]+$/', $stx)) {

        // 영문+숫자 검색 → 발신인 코드(wr_4) 기반, 이벤트명대사(wr_3=1)만
        $sql_search = "
            wr_4 = '" . sql_escape_string($stx) . "'
            AND wr_3 = '1'
        ";

    } else {

        // 한글 / 특수문자 등은 검색하지 않음
        $sql_search = "1 = 0";

    }


    /*
     * --------------------------------------------------
     * 검색 게시판 결과 계산
     * --------------------------------------------------
     */

    $str_board_list = "";
    $board_count = 0;

    $time1 = get_microtime();

    $total_count = 0;
    $tables_cnt = count($g5_search['tables']);

    for ($i = 0; $i < $tables_cnt; $i++) {

        $tmp_write_table = $g5['write_prefix'] . $g5_search['tables'][$i];

        $sql = "
            SELECT wr_id
            FROM {$tmp_write_table}
            WHERE {$sql_search}
        ";

        $result = sql_query($sql, false);

        if (!$result) {
            continue;
        }

        $row['cnt'] = @sql_num_rows($result);

        $total_count += $row['cnt'];

        if ($row['cnt']) {

            $board_count++;

            $search_table[] = $g5_search['tables'][$i];
            $read_level[] = $g5_search['read_level'][$i];
            $search_table_count[] = $total_count;

            $sql2 = "
                SELECT bo_subject, bo_mobile_subject
                FROM {$g5['board_table']}
                WHERE bo_table = '{$g5_search['tables'][$i]}'
            ";

            $row2 = sql_fetch($sql2);

            $sch_class = "";

            if (
                isset($onetable) &&
                $onetable == $g5_search['tables'][$i]
            ) {
                $sch_class = "class=sch_on";
            }

            $board_subject = G5_IS_MOBILE && $row2['bo_mobile_subject']
                ? $row2['bo_mobile_subject']
                : $row2['bo_subject'];

            $str_board_list .= '
                <li>
                    <a href="' . $_SERVER['SCRIPT_NAME'] . '?' . $search_query . '&amp;onetable=' . $g5_search['tables'][$i] . '" ' . $sch_class . '>
                        <strong>' . get_text($board_subject) . '</strong>
                        <span class="cnt_cmt">' . $row['cnt'] . '</span>
                    </a>
                </li>
            ';
        }

        sql_free_result($result);
    }


    /*
     * --------------------------------------------------
     * 페이징
     * --------------------------------------------------
     */

    $rows = $srows;

    $total_page = $rows > 0
        ? ceil($total_count / $rows)
        : 0;

    $page = isset($_GET['page'])
        ? (int)$_GET['page']
        : 1;

    if ($page < 1) {
        $page = 1;
    }

    $from_record = ($page - 1) * $rows;


    /*
     * --------------------------------------------------
     * 검색 결과 목록
     * --------------------------------------------------
     */

    $search_table_cnt = count($search_table);

    for ($i = 0; $i < $search_table_cnt; $i++) {

        if ($from_record < $search_table_count[$i]) {

            $table_index = $i;

            $from_record =
                $from_record -
                ($i > 0 ? $search_table_count[$i - 1] : 0);

            break;
        }
    }


    $bo_subject = array();
    $list = array();

    $k = 0;


    /*
     * 현재는 messages 게시판 하나만 검색하지만
     * GnuBoard 검색 결과 구조를 유지한다.
     */

    for (
        $idx = $table_index;
        $idx < count($search_table);
        $idx++
    ) {

        $sql = "
            SELECT bo_subject, bo_mobile_subject
            FROM {$g5['board_table']}
            WHERE bo_table = '{$search_table[$idx]}'
        ";

        $row = sql_fetch($sql);

        $bo_subject[$idx] =
            G5_IS_MOBILE && $row['bo_mobile_subject']
                ? $row['bo_mobile_subject']
                : $row['bo_subject'];


        $tmp_write_table =
            $g5['write_prefix'] . $search_table[$idx];


        /*
         * 검색 결과
         */
        $sql = "
            SELECT *
            FROM {$tmp_write_table}
            WHERE {$sql_search}
            ORDER BY wr_id DESC
            LIMIT {$from_record}, {$rows}
        ";

        $result = sql_query($sql);


        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            /*
             * 검색 결과 기본 정보
             */
            $list[$idx][$i] = $row;

            $list[$idx][$i]['href'] =
                get_pretty_url(
                    $search_table[$idx],
                    $row['wr_parent']
                );


            /*
             * 댓글인 경우 부모글 정보 사용
             */
            if ($row['wr_is_comment']) {

                $sql2 = "
                    SELECT wr_subject, wr_option
                    FROM {$tmp_write_table}
                    WHERE wr_id = '{$row['wr_parent']}'
                ";

                $row2 = sql_fetch($sql2);

                $row['wr_subject'] =
                    get_text($row2['wr_subject']);
            }


            /*
             * 비밀글 처리
             */
            if (
                strpos(
                    $row['wr_option'] .
                    (
                        isset($row2['wr_option'])
                        ? $row2['wr_option']
                        : ''
                    ),
                    'secret'
                ) !== false
            ) {

                $row['wr_content'] =
                    '[비밀글 입니다.]';
            }


            /*
             * 제목
             */
            $subject =
                get_text($row['wr_subject']);

            $subject =
                search_font(
                    $stx,
                    $subject
                );


            /*
             * 내용
             */
            if (
                $read_level[$idx] <=
                $member['mb_level']
            ) {

                $content =
                    strip_tags($row['wr_content']);

                $content =
                    get_text($content, 1);

                $content =
                    strip_tags($content);

                $content =
                    str_replace(
                        '&nbsp;',
                        '',
                        $content
                    );

                $content =
                    cut_str(
                        $content,
                        300,
                        "…"
                    );

                $content =
                    search_font(
                        $stx,
                        $content
                    );

            } else {

                $content = '';
            }


            /*
             * 결과 데이터 저장
             */
            $list[$idx][$i]['subject'] =
                $subject;

            $list[$idx][$i]['content'] =
                $content;

            $list[$idx][$i]['name'] =
                get_sideview(
                    $row['mb_id'],
                    get_text(
                        cut_str(
                            $row['wr_name'],
                            $config['cf_cut_name']
                        )
                    ),
                    $row['wr_email'],
                    $row['wr_homepage']
                );


            $k++;

            if ($k >= $rows) {
                break;
            }
        }

        sql_free_result($result);


        if ($k >= $rows) {
            break;
        }

        $from_record = 0;
    }


    /*
     * --------------------------------------------------
     * 페이지 네비게이션
     * --------------------------------------------------
     */

    $write_pages = get_paging(
        G5_IS_MOBILE
            ? $config['cf_mobile_pages']
            : $config['cf_write_pages'],
        $page,
        $total_page,
        $_SERVER['SCRIPT_NAME'] .
        '?' .
        $search_query .
        '&amp;srows=' .
        $srows .
        '&amp;page='
    );
}


/*
 * --------------------------------------------------
 * 기존 GnuBoard 검색 스킨에서 사용하는 변수
 * --------------------------------------------------
 */

$group_select = '';

if (!$sfl) {
    $sfl = 'wr_subject';
}

if (!$sop) {
    $sop = 'or';
}


include_once(
    $search_skin_path . '/search.skin.php'
);


include_once('./_tail.php');