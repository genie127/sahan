<?php
if (!defined('_GNUBOARD_')) exit;
@include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 최신글 추출
// $cache_time 캐시 갱신시간
function latest($skin_dir='', $bo_table='', $rows=10, $subject_len=40, $cache_time=1, $options='')
{
    global $g5;

    if (!$skin_dir) $skin_dir = 'basic';
    
    $time_unit = 3600;  // 1시간으로 고정

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            if(!is_dir($latest_skin_path))
                $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        } else {
            $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        } else {
            $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
        }
    }

    $caches = false;

    // 테스트 날짜 파라미터 반영: ?test=YmdHis 형식이면 해당 날짜 기준으로 캐시 키 및 쿼리에 사용
    $test_param = isset($_GET['test']) ? preg_replace('/[^0-9]/', '', $_GET['test']) : '';
    if ($test_param && strlen($test_param) >= 8) {
        $test_timestamp = mktime(
            (int)substr($test_param, 8, 2),
            (int)substr($test_param, 10, 2),
            (int)substr($test_param, 12, 2),
            (int)substr($test_param, 4, 2),
            (int)substr($test_param, 6, 2),
            (int)substr($test_param, 0, 4)
        );
        $base_time = ($test_timestamp !== false && $test_timestamp > 0) ? $test_timestamp : G5_SERVER_TIME;
    } else {
        $base_time = G5_SERVER_TIME;
    }
    $today_mmdd = date('md', $base_time);
    $today_date_sql = date('Y-m-d', $base_time);

    // 메인페이지 명대사/오늘 작성 게시글 랜덤 노출:
    // messages 게시판은 캐시를 사용하지 않고 매 로드마다 랜덤 선택
    $is_messages_random = ($bo_table === 'messages');

    if (!$is_messages_random && G5_USE_CACHE) {
        $cache_file_name = "latest-{$bo_table}-{$skin_dir}-{$rows}-{$subject_len}-{$today_mmdd}-".g5_cache_secret_key();
        $caches = g5_get_cache($cache_file_name, (int) $time_unit * (int) $cache_time);
        $cache_list = isset($caches['list']) ? $caches['list'] : array();
        g5_latest_cache_data($bo_table, $cache_list);
    }

    if( $caches === false ){

        $list = array();

        $board = get_board_db($bo_table, true);

        if( ! $board ){
            return '';
        }

        $bo_subject = get_text($board['bo_subject']);

        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

        // ================================================================
        // 메인페이지 랜덤 노출 로직 (messages 게시판 전용)
        // ================================================================
        // A. 오늘 날짜 명대사 (wr_2=1, wr_subject=MMDD)
        // B. 오늘 작성된 전체 공개 게시글 (wr_1=1, wr_2=0, wr_3=0, 비밀글 제외)
        // 두 후보 중 하나를 랜덤으로 선택하여 노출
        // ================================================================
        if ($is_messages_random) {

            // ---- A. 오늘 날짜 명대사 조회 ----
            $sql_date = " select * from {$tmp_write_table}
             where wr_is_comment = 0
             and wr_2 = '1'
             and (wr_3 = '0' OR wr_3 IS NULL OR wr_3 = '')
             and wr_subject = '{$today_mmdd}'
             order by
                 COALESCE(
                     STR_TO_DATE(NULLIF(wr_6,''), '%Y.%m.%d'),
                     wr_datetime
                 ) asc,
                 wr_id asc
             limit 0, {$rows} ";

            $date_rows = array();
            $result_date = sql_query($sql_date);
            while ($row = sql_fetch_array($result_date)) {
                $date_rows[] = $row;
            }

            // ---- B. 오늘 작성된 전체 공개 게시글 조회 ----
            // 조건: 전체공개(wr_1=1), 명대사 아님(wr_2=0, wr_3=0),
            //        비밀글 제외, 오늘 00:00 이후 작성, 북마크 사본 제외(wr_7)
            $sql_today = " select * from {$tmp_write_table}
             where wr_is_comment = 0
             and wr_1 = '1'
             and wr_2 = '0'
             and wr_3 = '0'
             and (wr_7 IS NULL OR wr_7 = '' OR wr_7 = '0')
             and wr_datetime >= '{$today_date_sql} 00:00:00'
             and wr_datetime <= '{$today_date_sql} 23:59:59'
             order by wr_id desc
             limit 0, {$rows} ";

            $today_rows = array();
            $result_today = sql_query($sql_today);
            while ($row = sql_fetch_array($result_today)) {
                $today_rows[] = $row;
            }

            // ---- 랜덤 후보 구성 및 선택 ----
            $candidates = array();

            // 매년 10월 21일에는 무조건 명대사만 노출
            $is_oct21 = (date('md', $base_time) === '1021');

            // 후보 A: 오늘 날짜 명대사 (여러 개면 전체 그룹을 하나의 후보로)
            if (!empty($date_rows)) {
                $candidates['date'] = $date_rows;
            }

            // 후보 B: 오늘 작성된 전체 공개 게시글 (여러 개면 무작위 1개 선정)
            // 단, 10월 21일에는 일반 게시글 후보에서 제외
            if (!$is_oct21 && !empty($today_rows)) {
                $random_idx = array_rand($today_rows);
                $candidates['today'] = array($today_rows[$random_idx]);
            }

            // 랜덤 선택
            $final_rows = array();
            if (!empty($candidates)) {
                $selected_key = array_rand($candidates);
                $final_rows = $candidates[$selected_key];
            }

            // 선택된 게시글을 $list 에 가공
            for ($i=0; $i < count($final_rows); $i++) {
                $row = $final_rows[$i];
                try {
                    unset($row['wr_password']);
                } catch (Exception $e) {
                }
                $row['wr_email'] = '';
                if (strpos($row['wr_option'], 'secret') !== false){
                    $row['wr_content'] = $row['wr_link1'] = $row['wr_link2'] = '';
                    $row['file'] = array('count'=>0);
                }
                $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);

                $list[$i]['first_file_thumb'] = (isset($row['wr_file']) && $row['wr_file']) ? get_board_file_db($bo_table, $row['wr_id'], 'bf_file, bf_content', "and bf_type in (1, 2, 3, 18) ", true) : array('bf_file'=>'', 'bf_content'=>'');
                $list[$i]['bo_table'] = $bo_table;
                if(! isset($list[$i]['icon_file'])) $list[$i]['icon_file'] = '';
            }

            g5_latest_cache_data($bo_table, $list);

        } else {

        // ================================================================
        // 일반 최신글 추출 (기존 로직)
        // ================================================================
        $sql = " select * from {$tmp_write_table}
         where wr_is_comment = 0
         and wr_2 = '1'
         and wr_subject = '{$today_mmdd}'
         order by
             COALESCE(
                 STR_TO_DATE(NULLIF(wr_6,''), '%Y.%m.%d'),
                 wr_datetime
             ) asc,
             wr_id asc
         limit 0, {$rows} ";

        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            try {
                unset($row['wr_password']);     //패스워드 저장 안함( 아예 삭제 )
            } catch (Exception $e) {
            }
            $row['wr_email'] = '';              //이메일 저장 안함
            if (strpos($row['wr_option'], 'secret') !== false){           // 비밀글일 경우 내용, 링크, 파일 저장 안함
                $row['wr_content'] = $row['wr_link1'] = $row['wr_link2'] = '';
                $row['file'] = array('count'=>0);
            }
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);

            $list[$i]['first_file_thumb'] = (isset($row['wr_file']) && $row['wr_file']) ? get_board_file_db($bo_table, $row['wr_id'], 'bf_file, bf_content', "and bf_type in (1, 2, 3, 18) ", true) : array('bf_file'=>'', 'bf_content'=>'');
            $list[$i]['bo_table'] = $bo_table;
            // 썸네일 추가
            if($options && is_string($options)) {
                $options_arr = explode(',', $options);
                $thumb_width = $options_arr[0];
                $thumb_height = $options_arr[1];
                $thumb = get_list_thumbnail($bo_table, $row['wr_id'], $thumb_width, $thumb_height, false, true);
                // 이미지 썸네일
                if($thumb['src']) {
                    $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
                    $list[$i]['img_thumbnail'] = '<a href="'.$list[$i]['href'].'" class="lt_img">'.$img_content.'</a>';
                // } else {
                //     $img_content = '<img src="'. G5_IMG_URL.'/no_img.png'.'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'" class="no_img">';
                }
            }

            if(! isset($list[$i]['icon_file'])) $list[$i]['icon_file'] = '';
        }
        g5_latest_cache_data($bo_table, $list);

        } // end if ($is_messages_random) else

        if(!$is_messages_random && G5_USE_CACHE) {

            $caches = array(
                'list' => $list,
                'bo_subject' => sql_escape_string($bo_subject),
            );

            g5_set_cache($cache_file_name, $caches, (int) $time_unit * (int) $cache_time);
        }
    } else {
        $list = $cache_list;
        $bo_subject = (is_array($caches) && isset($caches['bo_subject'])) ? $caches['bo_subject'] : '';
    }

    ob_start();
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}