<?php
// 관리자 전용 - 특정 회원의 차단 해제
require_once './_common.php';

header('Content-Type: application/json; charset=utf-8');

// 최고관리자만 허용
if ($is_admin != 'super') {
    echo json_encode(array('result' => 'error', 'msg' => '권한이 없습니다.'));
    exit;
}

if (!isset($g5['message_block_table'])) {
    echo json_encode(array('result' => 'error', 'msg' => '차단 테이블이 없습니다.'));
    exit;
}

$mb_id       = isset($_POST['mb_id'])       ? trim($_POST['mb_id'])       : '';
$block_mb_id = isset($_POST['block_mb_id']) ? trim($_POST['block_mb_id']) : '';

if ($mb_id === '' || $block_mb_id === '') {
    echo json_encode(array('result' => 'error', 'msg' => '잘못된 요청입니다.'));
    exit;
}

$mb_id_esc       = sql_escape_string($mb_id);
$block_mb_id_esc = sql_escape_string($block_mb_id);

sql_query("
    DELETE FROM {$g5['message_block_table']}
     WHERE mb_id       = '{$mb_id_esc}'
       AND block_mb_id = '{$block_mb_id_esc}'
");

echo json_encode(array('result' => 'success', 'msg' => '차단이 해제되었습니다.'));
exit;
