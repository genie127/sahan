<?php
include_once('../../../common.php');

header('Content-Type: application/json; charset=utf-8');

if (!$is_member) {
    echo json_encode(array('result' => 'login'));
    exit;
}

$wr_id = isset($_POST['wr_id']) ? (int)$_POST['wr_id'] : 0;

if (!$wr_id) {
    echo json_encode(array('result' => 'error'));
    exit;
}

$mb_id = sql_escape_string($member['mb_id']);

/*
 * 이미 저장했는지 확인
 */
$sql = " select wr_id
         from {$g5['write_prefix']}messages
         where wr_6 = '{$wr_id}'
         and wr_2 = '{$mb_id}'
         and wr_4 = '0'
         limit 1 ";

$row = sql_fetch($sql);

if ($row['wr_id']) {
    echo json_encode(array('result' => 'duplicate'));
    exit;
}


/*
 * 원본 게시글 확인
 */
$sql = " select *
         from {$g5['write_prefix']}messages
         where wr_id = '{$wr_id}'
         and wr_is_comment = 0
         and wr_4 = '1'
         limit 1 ";

$original = sql_fetch($sql);

if (!$original['wr_id']) {
    echo json_encode(array('result' => 'error'));
    exit;
}


/*
 * 북마크 메시지 저장
 *
 * wr_1 : 공개 여부
 * wr_2 : 받는 사람
 * wr_3 : 동의체크
 * wr_4 : 명대사/오늘의문장 구분
 * wr_5 : 임의날짜
 * wr_6 : 원본 게시글 wr_id
 * wr_7 : 기존 발신인
 */
$sql = " insert into {$g5['write_prefix']}messages
         set
            wr_num = '".sql_escape_string($original['wr_num'])."',
            wr_reply = '',
            wr_parent = '".sql_escape_string($original['wr_parent'])."',
            wr_is_comment = '0',
            wr_comment = '0',
            wr_comment_reply = '',
            ca_name = '".sql_escape_string($original['ca_name'])."',
            wr_option = '',
            wr_subject = '".sql_escape_string($original['wr_subject'])."',
            wr_content = '".sql_escape_string($original['wr_content'])."',
            mb_id = '".sql_escape_string($original['mb_id'])."',
            wr_name = '".sql_escape_string($original['wr_name'])."',
            wr_email = '".sql_escape_string($original['wr_email'])."',
            wr_homepage = '".sql_escape_string($original['wr_homepage'])."',
            wr_datetime = '".G5_TIME_YMDHIS."',
            wr_last = '".G5_TIME_YMDHIS."',
            wr_ip = '".sql_escape_string($_SERVER['REMOTE_ADDR'])."',
            wr_1 = '0',
            wr_2 = '{$mb_id}',
            wr_3 = '1',
            wr_4 = '0',
            wr_5 = '".sql_escape_string($original['wr_5'])."',
            wr_6 = '{$wr_id}',
            wr_7 = '".sql_escape_string($original['wr_2'])."'
         ";

sql_query($sql);

echo json_encode(array('result' => 'success'));
exit;