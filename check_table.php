<?php
define('_GNUBOARD_', true);
include_once('common.php');

// 전체 테이블 목록
$res = sql_query("SHOW TABLES");
echo "=== All Tables ===\n";
while($row = sql_fetch_array($res)) {
    echo $row[0]."\n";
}
