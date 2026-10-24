<?php
/**
 * GNB 메뉴 탭 레이블 API
 * 관리자에서 설정한 메뉴(me_name, me_link) 목록을 JSON으로 반환
 * 앱에서 하단 탭 레이블 동기화 용도로 사용
 */

define('_GNUBOARD_', true);
require_once dirname(__DIR__) . '/common.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

// tab-labels.json 파일에서 탭 레이블 매핑을 읽어옴
$json_file = __DIR__ . '/tab-labels.json';
$raw = file_exists($json_file) ? json_decode(file_get_contents($json_file), true) : [];

$labels = [];
foreach ($raw as $name => $label) {
    $labels[] = [
        'name'  => $name,
        'label' => $label,
    ];
}

echo json_encode($labels, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
