<?php
include_once('../../../common.php');

header('Content-Type: application/json; charset=utf-8');

// 로그인 회원만 차단 가능
if (!$is_member) {
    echo json_encode(array('result' => 'login'));
    exit;
}

$wr_id = isset($_POST['wr_id']) ? (int)$_POST['wr_id'] : 0;

if (!$wr_id) {
    echo json_encode(array('result' => 'error', 'msg' => '잘못된 요청입니다.'));
    exit;
}

$my_mb_id = sql_escape_string($member['mb_id']);

// 차단 대상 게시글의 작성자 조회
$row = sql_fetch(" select wr_id, mb_id
                     from {$g5['write_prefix']}messages
                    where wr_id = '{$wr_id}'
                      and wr_is_comment = 0
                    limit 1 ");

if (!isset($row['wr_id']) || !$row['wr_id']) {
    echo json_encode(array('result' => 'error', 'msg' => '존재하지 않는 게시글입니다.'));
    exit;
}

// 회원 ID로만 차단 (비회원 발신인은 차단 대상 아님)
if ($row['mb_id'] === '') {
    echo json_encode(array('result' => 'noid', 'msg' => '회원이 아닌 발신인은 차단할 수 없습니다.'));
    exit;
}

// 본인은 차단 불가
if ($row['mb_id'] === $member['mb_id']) {
    echo json_encode(array('result' => 'self', 'msg' => '본인은 차단할 수 없습니다.'));
    exit;
}

$block_mb_id = sql_escape_string($row['mb_id']);

// 이미 차단했는지 확인
$dup = sql_fetch(" select mb_block_id
                     from {$g5['message_block_table']}
                    where mb_id = '{$my_mb_id}'
                      and block_mb_id = '{$block_mb_id}'
                    limit 1 ");

if (isset($dup['mb_block_id']) && $dup['mb_block_id']) {
    echo json_encode(array('result' => 'duplicate', 'msg' => '이미 차단한 사용자입니다.'));
    exit;
}

// 차단 등록
$sql = " insert into {$g5['message_block_table']}
         set
            mb_id       = '{$my_mb_id}',
            block_mb_id = '{$block_mb_id}',
            mb_datetime = '".G5_TIME_YMDHIS."' ";

sql_query($sql);

echo json_encode(array('result' => 'success', 'msg' => '해당 발신인을 차단했습니다.', 'block_mb_id' => $row['mb_id']));
exit;
