<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


// ============================================================
// 분류 사용 여부
// ============================================================
$is_category = false;
$category_option = '';

if ($board['bo_use_category']) {
    $is_category = true;
    $category_href = get_pretty_url($bo_table);

    $category_option .= '<li><a href="'.$category_href.'"';

    if ($sca == '')
        $category_option .= ' id="bo_cate_on"';

    $category_option .= '>전체</a></li>';

    $categories = explode('|', $board['bo_category_list']);
    $categories_cnt = count($categories);

    for ($i = 0; $i < $categories_cnt; $i++) {
        $category = trim($categories[$i]);

        if ($category == '')
            continue;

        $category_option .= '<li><a href="'.get_pretty_url(
            $bo_table,
            '',
            'sca='.urlencode($category)
        ).'"';

        $category_msg = '';

        if ($category == $sca) {
            $category_option .= ' id="bo_cate_on"';
            $category_msg = '<span class="sound_only">열린 분류 </span>';
        }

        $category_option .= '>'.$category_msg.$category.'</a></li>';
    }
}


// ============================================================
// 검색 조건
// ============================================================
$sop = strtolower($sop);

if ($sop != 'and' && $sop != 'or')
    $sop = 'and';

$stx = trim($stx);

$is_search_bbs = false;
$sql_search = '';

if ($sca || $stx || $stx === '0') {

    $is_search_bbs = true;

    $sql_search = get_sql_search($sca, $sfl, $stx, $sop);

    // 가장 작은 wr_num
    $sql = " select MIN(wr_num) as min_wr_num
             from {$write_table} ";

    $row = sql_fetch($sql);

    $min_spt = (int)$row['min_wr_num'];

    if (!$spt)
        $spt = $min_spt;

    $sql_search .= " and (
        wr_num between {$spt}
        and ({$spt} + {$config['cf_search_part']})
    ) ";
}


// ============================================================
// 메시지 목록 구분
//
// type=all
//      wr_1 = 1 인 전체공개 메시지
//
// type=mine
//      현재 로그인한 회원이 수신인인 메시지
//      wr_2 = mb_id
// ============================================================
$message_type = isset($_GET['type']) ? $_GET['type'] : 'all';

$is_board_admin = (
    $is_member &&
    (
        $is_admin == 'super' ||
        $group['gr_admin'] == $member['mb_id'] ||
        $board['bo_admin'] == $member['mb_id']
    )
);

if ($message_type === 'adm') {

    // 관리자만 모든 게시글 조회
    if ($is_board_admin) {
        $message_condition = "1=1";
    } else {
        $message_condition = "1=0";
    }

} elseif ($message_type === 'mine') {

    // 내게 온 글
    $message_condition = "
        wr_2 = '".sql_escape_string($member['mb_id'])."'
    ";

} else {

    // 전체공개 글
    $message_condition = "
        wr_1 = '1'
    ";
}


// ============================================================
// 검색 결과 개수
// ============================================================
if ($is_search_bbs) {

    $sql = " SELECT COUNT(DISTINCT wr_parent) AS cnt
             FROM {$write_table}
             WHERE {$sql_search}
             AND {$message_condition} ";

    $row = sql_fetch($sql);

    $total_count = (int)$row['cnt'];

} else {

    $sql = " SELECT COUNT(*) AS cnt
             FROM {$write_table}
             WHERE wr_is_comment = 0
             AND {$message_condition} ";

    $row = sql_fetch($sql);

    $total_count = (int)$row['cnt'];
}


// ============================================================
// 페이지당 게시물 수
// ============================================================
if (G5_IS_MOBILE) {

    $page_rows = $board['bo_mobile_page_rows'];
    $list_page_rows = $board['bo_mobile_page_rows'];

} else {

    $page_rows = $board['bo_page_rows'];
    $list_page_rows = $board['bo_page_rows'];
}


if ($page < 1)
    $page = 1;


// ============================================================
// 년도 2자리
// ============================================================
$today2 = G5_TIME_YMD;


// ============================================================
// 목록 초기화
// ============================================================
$list = array();

$i = 0;

$notice_count = 0;
$notice_array = array();


// ============================================================
// 공지 처리
// ============================================================
if (!$is_search_bbs) {

    $arr_notice = explode(',', trim($board['bo_notice']));

    $from_notice_idx = ($page - 1) * $page_rows;

    if ($from_notice_idx < 0)
        $from_notice_idx = 0;


    // 유효한 공지 wr_id 수집
    $notice_ids_int = array();

    foreach ($arr_notice as $k_idx => $nid_raw) {

        $nid_int = (int)trim($nid_raw);

        if ($nid_int > 0) {
            $notice_ids_int[$k_idx] = $nid_int;
        }
    }


    // 공지 일괄 조회
    $notice_rows_by_id = array();

    if (!empty($notice_ids_int)) {

        $sql = " select *
                 from {$write_table}
                 where wr_id in (".implode(',', $notice_ids_int).")
                 and {$message_condition} ";

        $result = sql_query($sql);

        while ($nrow = sql_fetch_array($result)) {
            $notice_rows_by_id[$nrow['wr_id']] = $nrow;
        }
    }


    // bo_notice 순서대로 처리
    foreach ($notice_ids_int as $k => $nid) {

        if (!isset($notice_rows_by_id[$nid]))
            continue;

        $row = $notice_rows_by_id[$nid];

        $notice_array[] = $row['wr_id'];


        if ($k < $from_notice_idx)
            continue;


        $list[$i] = get_list(
            $row,
            $board,
            $board_skin_url,
            G5_IS_MOBILE
                ? $board['bo_mobile_subject_len']
                : $board['bo_subject_len']
        );

        $list[$i]['is_notice'] = true;
        $list[$i]['list_content'] = $list[$i]['wr_content'];


        // 비밀글이면 내용 숨김
        if (strstr($list[$i]['wr_option'], "secret")) {
            $list[$i]['wr_content'] = '';
        }


        // 공지는 번호 없음
        $list[$i]['num'] = 0;

        $i++;
        $notice_count++;


        if ($notice_count >= $list_page_rows)
            break;
    }
}


// ============================================================
// 전체 페이지
// ============================================================
$total_page = ceil($total_count / $page_rows);


// ============================================================
// 시작 위치
// ============================================================
$from_record = ($page - 1) * $page_rows;


// ============================================================
// 공지글이 있으면 일반글 시작 위치 조정
// ============================================================
if (!empty($notice_array)) {

    $from_record -= count($notice_array);

    if ($from_record < 0)
        $from_record = 0;


    if ($notice_count > 0)
        $page_rows -= $notice_count;


    if ($page_rows < 0)
        $page_rows = $list_page_rows;
}


// ============================================================
// 관리자 체크박스
// ============================================================
$is_checkbox = false;

if (
    $is_member &&
    (
        $is_admin == 'super' ||
        $group['gr_admin'] == $member['mb_id'] ||
        $board['bo_admin'] == $member['mb_id']
    )
) {
    $is_checkbox = true;
}


// ============================================================
// 정렬 QUERY STRING
// ============================================================
$qstr2 = 'bo_table='.$bo_table.'&amp;sop='.$sop;


// ============================================================
// 갤러리
// ============================================================
$bo_gallery_cols = $board['bo_gallery_cols']
    ? $board['bo_gallery_cols']
    : 1;

$td_width = (int)(100 / $bo_gallery_cols);


// ============================================================
// 정렬
// ============================================================
if (!$sst) {

    if ($board['bo_sort_field']) {

        $sst = $board['bo_sort_field'];

    } else {

        $sst = "wr_num, wr_reply";
        $sod = "";
    }

} else {

    $board_sort_fields = get_board_sort_fields($board, 1);

    if (
        !$sod &&
        array_key_exists($sst, $board_sort_fields)
    ) {

        $sst = $board_sort_fields[$sst];

    } else {

        $sst = preg_match(
            "/^(wr_datetime|wr_hit|wr_good|wr_nogood)$/i",
            $sst
        )
            ? $sst
            : "";
    }
}


if (!$sst)
    $sst = "wr_num, wr_reply";


$sod = preg_match(
    "/^(asc|desc)$/i",
    $sod
)
    ? $sod
    : "";


if ($sst) {
    $sql_order = " order by {$sst} {$sod} ";
}


// ============================================================
// 실제 목록 조회
// ============================================================
$rows_to_process = array();

if ($page_rows > 0) {

    // --------------------------------------------------------
    // 검색 목록
    // --------------------------------------------------------
    if ($is_search_bbs) {

        /*
         * 여기 중요!
         *
         * 기존에는:
         *
         * where {$sql_search}
         *
         * 만 있어서 wr_1 / wr_2 조건이
         * 실제 목록 조회에는 적용되지 않았음.
         *
         * 반드시 message_condition을 같이 적용.
         */

        $sql = " select distinct wr_parent
                 from {$write_table}
                 where {$sql_search}
                 and {$message_condition}
                 {$sql_order}
                 limit {$from_record}, {$page_rows} ";

        $result = sql_query($sql);


        $parent_ids_in_order = array();

        while ($id_row = sql_fetch_array($result)) {

            $pid = (int)$id_row['wr_parent'];

            if ($pid > 0) {
                $parent_ids_in_order[] = $pid;
            }
        }


        // ----------------------------------------------------
        // 부모 글 일괄 조회
        // ----------------------------------------------------
        if (!empty($parent_ids_in_order)) {

            $batch_sql = " select *
                           from {$write_table}
                           where wr_id in (
                               ".implode(',', $parent_ids_in_order)."
                           ) ";

            $batch_result = sql_query($batch_sql);


            $rows_by_id = array();

            while ($br = sql_fetch_array($batch_result)) {
                $rows_by_id[$br['wr_id']] = $br;
            }


            // 원래 정렬 순서 유지
            foreach ($parent_ids_in_order as $pid) {

                if (isset($rows_by_id[$pid])) {
                    $rows_to_process[] = $rows_by_id[$pid];
                }
            }
        }


    // --------------------------------------------------------
    // 일반 목록
    // --------------------------------------------------------
    } else {

        /*
         * 여기에도 message_condition을 반드시 적용.
         */

        $sql = " select *
                 from {$write_table}
                 where wr_is_comment = 0
                 and {$message_condition} ";


        // 공지는 일반 목록에서 제외
        if (!empty($notice_array)) {

            $sql .= " and wr_id not in (
                ".implode(', ', $notice_array)."
            ) ";
        }


        $sql .= " {$sql_order}
                  limit {$from_record}, {$page_rows} ";


        $result = sql_query($sql);

        while ($row = sql_fetch_array($result)) {
            $rows_to_process[] = $row;
        }
    }
}


// ============================================================
// 일반 게시물 목록 구성
// ============================================================
$k = 0;

foreach ($rows_to_process as $row)
{
    $list[$i] = get_list(
        $row,
        $board,
        $board_skin_url,
        G5_IS_MOBILE
            ? $board['bo_mobile_subject_len']
            : $board['bo_subject_len']
    );


    if (strstr($sfl, 'subject')) {
        $list[$i]['subject'] = search_font(
            $stx,
            $list[$i]['subject']
        );
    }


    $list[$i]['is_notice'] = false;
    $list[$i]['list_content'] = $list[$i]['wr_content'];


    // 비밀글이면 내용 숨김
    if (strstr($list[$i]['wr_option'], "secret")) {
        $list[$i]['wr_content'] = '';
    }


    // ========================================================
    // 번호
    //
    // notice_count를 여기서 빼면 안 됨.
    // 이미 목록 조회 단계에서 공지를 제외했기 때문에
    // 여기서 또 빼면 0, -1, -2가 될 수 있음.
    // ========================================================
    $list_num = $total_count
        - ($page - 1) * $list_page_rows;

    $list[$i]['num'] = $list_num - $k;


    $i++;
    $k++;
}


// ============================================================
// 최신 목록 캐시
// ============================================================
g5_latest_cache_data(
    $board['bo_table'],
    $list
);


// ============================================================
// 페이지네이션
// ============================================================
$write_pages = get_paging(
    G5_IS_MOBILE
        ? $config['cf_mobile_pages']
        : $config['cf_write_pages'],
    $page,
    $total_page,
    get_pretty_url(
        $bo_table,
        '',
        $qstr.'&amp;page='
    )
);


// ============================================================
// 검색 이전 / 다음
// ============================================================
$list_href = '';
$prev_part_href = '';
$next_part_href = '';

if ($is_search_bbs) {

    $list_href = get_pretty_url($bo_table);


    $patterns = array(
        '#&amp;page=[0-9]*#',
        '#&amp;spt=[0-9\-]*#'
    );


    // 이전 검색
    $prev_spt = $spt - $config['cf_search_part'];

    if (
        isset($min_spt) &&
        $prev_spt >= $min_spt
    ) {

        $qstr1 = preg_replace(
            $patterns,
            '',
            $qstr
        );

        $prev_part_href = get_pretty_url(
            $bo_table,
            0,
            $qstr1.'&amp;spt='.$prev_spt.'&amp;page=1'
        );

        $write_pages = page_insertbefore(
            $write_pages,
            '<a href="'.$prev_part_href.'" class="pg_page pg_search pg_prev">이전검색</a>'
        );
    }


    // 다음 검색
    $next_spt = $spt + $config['cf_search_part'];

    if ($next_spt < 0) {

        $qstr1 = preg_replace(
            $patterns,
            '',
            $qstr
        );

        $next_part_href = get_pretty_url(
            $bo_table,
            0,
            $qstr1.'&amp;spt='.$next_spt.'&amp;page=1'
        );

        $write_pages = page_insertafter(
            $write_pages,
            '<a href="'.$next_part_href.'" class="pg_page pg_search pg_next">다음검색</a>'
        );
    }
}


// ============================================================
// 글쓰기 버튼
// ============================================================
$write_href = '';

if ($member['mb_level'] >= $board['bo_write_level']) {

    $write_href = short_url_clean(
        G5_BBS_URL.'/write.php?bo_table='.$bo_table
    );
}


// ============================================================
// Firefox / Gecko
// ============================================================
$nobr_begin = $nobr_end = '';

if (preg_match(
    "/gecko|firefox/i",
    $_SERVER['HTTP_USER_AGENT']
)) {
    $nobr_begin = '<nobr>';
    $nobr_end = '</nobr>';
}


// ============================================================
// RSS
// ============================================================
$rss_href = '';

if ($board['bo_use_rss_view']) {
    $rss_href = G5_BBS_URL.'/rss.php?bo_table='.$bo_table;
}


// ============================================================
// 검색어 출력용 처리
// ============================================================
$stx = get_text(stripslashes($stx));


// ============================================================
// 스킨
// ============================================================
include_once($board_skin_path.'/list.skin.php');