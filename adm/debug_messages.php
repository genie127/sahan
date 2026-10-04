<?php
$sub_menu = "300100";
require_once './_common.php';
if ($is_admin != 'super') { echo 'no'; exit; }

$rows = sql_query("SELECT wr_id, wr_subject, wr_2, wr_3, wr_6, wr_datetime, wr_date FROM g5_write_messages WHERE wr_is_comment = 0 ORDER BY wr_id DESC LIMIT 20");

echo '<pre style="font-size:13px;">';
echo str_pad('wr_id', 8) . str_pad('wr_subject', 14) . str_pad('wr_2', 6) . str_pad('wr_3', 6) . str_pad('wr_6', 14) . str_pad('wr_datetime', 26) . 'wr_date' . "\n";
echo str_repeat('-', 90) . "\n";
while ($r = sql_fetch_array($rows)) {
    echo str_pad($r['wr_id'], 8)
       . str_pad($r['wr_subject'], 14)
       . str_pad($r['wr_2'], 6)
       . str_pad($r['wr_3'], 6)
       . str_pad($r['wr_6'], 14)
       . str_pad($r['wr_datetime'], 26)
       . $r['wr_date'] . "\n";
}
echo '</pre>';

// list 배열에서 실제로 wr_subject, wr_2, wr_6이 어떻게 오는지도 확인
echo '<hr><h3>list 배열 raw 확인 (최근 5개)</h3>';
$rows2 = sql_query("SELECT * FROM g5_write_messages WHERE wr_is_comment = 0 ORDER BY wr_id DESC LIMIT 5");
echo '<pre style="font-size:12px;">';
while ($r = sql_fetch_array($rows2)) {
    echo "wr_id={$r['wr_id']} | wr_subject=[{$r['wr_subject']}] | wr_2=[{$r['wr_2']}] | wr_3=[{$r['wr_3']}] | wr_6=[{$r['wr_6']}] | wr_datetime=[{$r['wr_datetime']}] | wr_date=[{$r['wr_date']}]\n";
    // preg_match 테스트
    $match = preg_match('/^(\d{2})(\d{2})$/', $r['wr_subject'], $dm);
    echo "  -> preg_match 결과: " . ($match ? "OK → " . date('Y') . ".{$dm[1]}.{$dm[2]}" : "불일치 (subject 길이=" . strlen($r['wr_subject']) . ", hex=" . bin2hex($r['wr_subject']) . ")") . "\n\n";
}
echo '</pre>';
