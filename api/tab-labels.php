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

$menu_datas = get_menu_db(0, true);

$labels = [];
foreach ($menu_datas as $row) {
    if (empty($row)) continue;

    $labels[] = [
        'name'   => $row['me_name'],   // 탭 식별 키 (이미지 파일명 등에 사용)
        'label'  => $row['me_name'],   // 탭에 표시할 텍스트
        'link'   => $row['me_link'],   // 연결 URL
        'target' => $row['me_target'], // 링크 타겟
    ];
}

echo json_encode($labels, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
