<?php
include_once('../../../common.php');

header('Content-Type: application/json; charset=utf-8');

// 로그인 확인
if (!$is_member) {
    echo json_encode(array('result' => 'login'));
    exit;
}

$block_mb_id = isset($_POST['block_mb_id']) ? trim($_POST['block_mb_id']) : '';

if ($block_mb_id === '') {
    echo json_encode(array('result' => 'error', 'msg' => '잘못된 요청입니다.'));
    exit;
}

$my_mb_id    = sql_escape_string($member['mb_id']);
$block_mb_id = sql_escape_string($block_mb_id);

// 자기 차단 데이터만 삭제 (다른 유저 데이터 접근 불가)
sql_query("
    DELETE FROM {$g5['message_block_table']}
     WHERE mb_id       = '{$my_mb_id}'
       AND block_mb_id = '{$block_mb_id}'
");

// affected_rows 가 0이어도 이미 해제된 것으로 성공 처리
echo json_encode(array('result' => 'success', 'msg' => '차단이 해제되었습니다.'));
exit;
