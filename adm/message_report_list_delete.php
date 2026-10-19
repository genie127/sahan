<?php
$sub_menu = "300900";
require_once './_common.php';

check_demo();

// 게시판 관리 권한 또는 최고관리자
$auth_check = ($is_admin == 'super');
if (!$auth_check && isset($auth[$sub_menu])) {
    $auth_check = (strpos($auth[$sub_menu], 'd') !== false);
}
if (!$auth_check) {
    alert('삭제 권한이 없습니다.');
}

check_admin_token();

$count = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;

if (!$count) {
    alert("삭제하실 항목을 하나 이상 체크하세요.");
}

for ($i = 0; $i < $count; $i++) {
    $mr_id = (int)$_POST['chk'][$i];
    if ($mr_id > 0) {
        sql_query(" delete from {$g5['message_report_table']} where mr_id = '{$mr_id}' ");
    }
}

goto_url('./message_report_list.php?' . $qstr);
