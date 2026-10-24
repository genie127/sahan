<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/register.lib.php');

// 회원 닉네임 열거 공격 방지를 위한 Rate Limit (분당 30회)
if (function_exists('check_rate_limit') && !check_rate_limit('ajax_mb_nick_check', 30, 60)) {
    die('너무 많은 요청이 발생했습니다. 잠시 후 다시 시도해 주세요.');
}

$mb_nick = isset($_POST['reg_mb_nick']) ? trim($_POST['reg_mb_nick']) : '';
$mb_id   = isset($_POST['reg_mb_id']) ? trim($_POST['reg_mb_id']) : '';

set_session('ss_check_mb_nick', '');

if ($msg = empty_mb_nick($mb_nick)) die($msg);

// 레벨 10 이상은 닉네임 자유, 미만은 숫자 8자리
$mb_level = 0;
if ($mb_id) {
    $tmp_row = sql_fetch(" select mb_level from {$g5['member_table']} where mb_id = '$mb_id' ");
    $mb_level = $tmp_row ? (int)$tmp_row['mb_level'] : 0;
}

if ($mb_level < 10) {
    if ($msg = valid_mb_nick_numeric($mb_nick)) die($msg);
} else {
    if ($msg = valid_mb_nick($mb_nick)) die($msg);
}

if ($msg = count_mb_nick($mb_nick)) die($msg);
if ($msg = exist_mb_nick($mb_nick, $mb_id)) die($msg);
if ($msg = reserve_mb_nick($mb_nick)) die($msg);

set_session('ss_check_mb_nick', $mb_nick);