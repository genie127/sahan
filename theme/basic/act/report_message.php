<?php
include_once('../../../common.php');

header('Content-Type: application/json; charset=utf-8');

// 로그인 회원만 신고 가능
if (!$is_member) {
    echo json_encode(array('result' => 'login'));
    exit;
}

$wr_id  = isset($_POST['wr_id']) ? (int)$_POST['wr_id'] : 0;
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

if (!$wr_id) {
    echo json_encode(array('result' => 'error', 'msg' => '잘못된 요청입니다.'));
    exit;
}

if ($reason === '') {
    echo json_encode(array('result' => 'need_reason', 'msg' => '신고 사유를 입력해주세요.'));
    exit;
}

// 사유 길이 제한 (과도한 입력 방지)
if (mb_strlen($reason, 'UTF-8') > 1000) {
    $reason = mb_substr($reason, 0, 1000, 'UTF-8');
}

$reporter_mb_id = sql_escape_string($member['mb_id']);

// 신고 대상 게시글 조회
$row = sql_fetch(" select wr_id, wr_subject, mb_id
                     from {$g5['write_prefix']}messages
                    where wr_id = '{$wr_id}'
                      and wr_is_comment = 0
                    limit 1 ");

if (!isset($row['wr_id']) || !$row['wr_id']) {
    echo json_encode(array('result' => 'error', 'msg' => '존재하지 않는 게시글입니다.'));
    exit;
}

// 내 글은 신고 불가
if ($row['mb_id'] !== '' && $row['mb_id'] === $member['mb_id']) {
    echo json_encode(array('result' => 'self', 'msg' => '본인 글은 신고할 수 없습니다.'));
    exit;
}

// 동일 게시글 중복 신고 방지
$dup = sql_fetch(" select mr_id
                     from {$g5['message_report_table']}
                    where wr_id = '{$wr_id}'
                      and reporter_mb_id = '{$reporter_mb_id}'
                    limit 1 ");

if (isset($dup['mr_id']) && $dup['mr_id']) {
    echo json_encode(array('result' => 'duplicate', 'msg' => '이미 신고한 게시글입니다.'));
    exit;
}

// 신고 저장
$sql = " insert into {$g5['message_report_table']}
         set
            wr_id          = '{$wr_id}',
            wr_subject     = '".sql_escape_string($row['wr_subject'])."',
            writer_mb_id   = '".sql_escape_string($row['mb_id'])."',
            reporter_mb_id = '{$reporter_mb_id}',
            mr_reason      = '".sql_escape_string($reason)."',
            mr_datetime    = '".G5_TIME_YMDHIS."',
            mr_ip          = '".sql_escape_string($_SERVER['REMOTE_ADDR'])."' ";

sql_query($sql);

echo json_encode(array('result' => 'success', 'msg' => '신고가 접수되었습니다.'));
exit;
