<?php
if (!defined('_GNUBOARD_')) exit;

if (!$is_admin)
    alert('접근 권한이 없습니다.', G5_URL);

@include_once($board_skin_path.'/delete_all.head.skin.php');

$count_write = 0;
$count_comment = 0;

$tmp_array = array();

if ($wr_id) {
    $tmp_array[0] = $wr_id;
} else {
    $tmp_array = (
        isset($_POST['chk_wr_id']) &&
        is_array($_POST['chk_wr_id'])
    )
        ? $_POST['chk_wr_id']
        : array();
}

$chk_count = count($tmp_array);

if (
    $chk_count >
    (G5_IS_MOBILE
        ? $board['bo_mobile_page_rows']
        : $board['bo_page_rows'])
) {
    alert('올바른 방법으로 이용해 주십시오.');
}

@include_once($board_skin_path.'/delete_all.skin.php');


// ============================================================
// 선택된 게시글 삭제
// ============================================================

for ($i = $chk_count - 1; $i >= 0; $i--)
{
    $delete_wr_id = (int)$tmp_array[$i];

    if (!$delete_wr_id)
        continue;


    // --------------------------------------------------------
    // 삭제할 글
    // --------------------------------------------------------

    $write = sql_fetch("
        select *
        from $write_table
        where wr_id = '{$delete_wr_id}'
    ");

    if (!$write['wr_id'])
        continue;


    // ========================================================
    // 관리자 권한
    // ========================================================

    if ($is_admin == 'super') {

        // 최고관리자 → 통과

    } else if ($is_admin == 'group') {

        $mb = get_member($write['mb_id']);

        if ($member['mb_id'] != $group['gr_admin'])
            continue;

        if ($member['mb_level'] < $mb['mb_level'])
            continue;

    } else if ($is_admin == 'board') {

        $mb = get_member($write['mb_id']);

        if ($member['mb_id'] != $board['bo_admin'])
            continue;

        if ($member['mb_level'] < $mb['mb_level'])
            continue;

    } else if (
        $member['mb_id'] &&
        $member['mb_id'] == $write['mb_id']
    ) {

        // 본인 글 → 통과

    } else if (
        $wr_password &&
        !$write['mb_id'] &&
        check_password(
            $wr_password,
            $write['wr_password']
        )
    ) {

        // 비회원 비밀번호 → 통과

    } else {

        continue;
    }


    // ========================================================
    // messages 게시판
    //
    // 일반 게시판과 달리 답변글 구조를 사용하지 않으므로
    // 답변글 검사하지 않음
    // ========================================================

    if ($bo_table != 'messages') {

        $len = strlen($write['wr_reply']);

        if ($len < 0)
            $len = 0;

        $reply = substr(
            $write['wr_reply'],
            0,
            $len
        );

        $sql = "
            select count(*) as cnt
            from $write_table
            where wr_reply like '$reply%'
            and wr_id <> '{$write['wr_id']}'
            and wr_num = '{$write['wr_num']}'
            and wr_is_comment = 0
        ";

        $row = sql_fetch($sql);

        if ($row['cnt'])
            continue;
    }


    // ========================================================
    // 원글 + 댓글 조회
    // ========================================================

    $sql = "
        select
            wr_id,
            mb_id,
            wr_is_comment,
            wr_content
        from $write_table
        where wr_parent = '{$write['wr_id']}'
        order by wr_id
    ";

    $result = sql_query($sql);

    while ($row = sql_fetch_array($result))
    {

        // ----------------------------------------------------
        // 원글
        // ----------------------------------------------------

        if (!$row['wr_is_comment'])
        {

            // 포인트 삭제
            if (!delete_point(
                $row['mb_id'],
                $bo_table,
                $row['wr_id'],
                '쓰기'
            )) {

                insert_point(
                    $row['mb_id'],
                    $board['bo_write_point'] * (-1),
                    "{$board['bo_subject']} {$row['wr_id']} 글 삭제"
                );
            }


            // ------------------------------------------------
            // 첨부파일 삭제
            // ------------------------------------------------

            $sql2 = "
                select *
                from {$g5['board_file_table']}
                where bo_table = '$bo_table'
                and wr_id = '{$row['wr_id']}'
            ";

            $result2 = sql_query($sql2);

            while ($row2 = sql_fetch_array($result2))
            {

                $delete_file = run_replace(
                    'delete_file_path',
                    G5_DATA_PATH.'/file/'.$bo_table.'/'
                    .str_replace('../', '', $row2['bf_file']),
                    $row2
                );

                if (file_exists($delete_file))
                    @unlink($delete_file);


                if (preg_match(
                    "/\.({$config['cf_image_extension']})$/i",
                    $row2['bf_file']
                )) {

                    delete_board_thumbnail(
                        $bo_table,
                        $row2['bf_file']
                    );
                }
            }


            // 에디터 썸네일
            delete_editor_thumbnail(
                $row['wr_content']
            );


            // 파일 테이블
            sql_query("
                delete from {$g5['board_file_table']}
                where bo_table = '$bo_table'
                and wr_id = '{$row['wr_id']}'
            ");


            $count_write++;

        } else {

            // ------------------------------------------------
            // 댓글
            // ------------------------------------------------

            if (!delete_point(
                $row['mb_id'],
                $bo_table,
                $row['wr_id'],
                '댓글'
            )) {

                insert_point(
                    $row['mb_id'],
                    $board['bo_comment_point'] * (-1),
                    "{$board['bo_subject']} {$write['wr_id']}-{$row['wr_id']} 댓글삭제"
                );
            }

            $count_comment++;
        }
    }


    // ========================================================
    // 게시글 + 댓글 삭제
    // ========================================================

    sql_query("
        delete from $write_table
        where wr_parent = '{$write['wr_id']}'
    ");


    // ========================================================
    // messages 게시판이면
    // 해당 원본을 북마크한 메시지도 삭제
    //
    // 원본 wr_id = 16
    // 북마크 글 wr_6 = 16
    // ========================================================

    if ($bo_table == 'messages') {

        sql_query("
            delete from $write_table
            where wr_6 = '{$write['wr_id']}'
            and wr_4 = '0'
        ");
    }


    // ========================================================
    // 최근게시물 삭제
    // ========================================================

    sql_query("
        delete from {$g5['board_new_table']}
        where bo_table = '$bo_table'
        and wr_parent = '{$write['wr_id']}'
    ");


    // ========================================================
    // 스크랩 삭제
    // ========================================================

    sql_query("
        delete from {$g5['scrap_table']}
        where bo_table = '$bo_table'
        and wr_id = '{$write['wr_id']}'
    ");


    // ========================================================
    // 공지사항
    // ========================================================

    $bo_notice = board_notice(
        $board['bo_notice'],
        $write['wr_id']
    );

    sql_query("
        update {$g5['board_table']}
        set bo_notice = '$bo_notice'
        where bo_table = '$bo_table'
    ");

    $board['bo_notice'] = $bo_notice;
}


// ============================================================
// 글 수 감소
// ============================================================

if ($count_write > 0 || $count_comment > 0) {

    sql_query("
        update {$g5['board_table']}
        set
            bo_count_write = bo_count_write - '$count_write',
            bo_count_comment = bo_count_comment - '$count_comment'
        where bo_table = '$bo_table'
    ");
}


@include_once($board_skin_path.'/delete_all.tail.skin.php');

delete_cache_latest($bo_table);

run_event(
    'bbs_delete_all',
    $tmp_array,
    $board
);


// ============================================================
// 목록으로 이동
// ============================================================

goto_url(
    short_url_clean(
        G5_HTTP_BBS_URL.'/board.php?bo_table='
        .$bo_table
        .'&amp;page='.$page
        .$qstr
    )
);