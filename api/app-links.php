<?php
/**
 * 앱 내 링크 URL API
 * 오류문의, 개선제안 등 앱에서 사용하는 외부 링크를 JSON으로 반환
 * 서버에서 수정하면 앱 빌드 없이 링크 변경 가능
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Access-Control-Allow-Origin: *');

echo json_encode([
    'error_report' => 'https://docs.google.com/spreadsheets/d/1cBSpczog56aoJrTY2lAsbIcJV3YdtQGE-nmD2TKsC1w/edit?gid=0#gid=0',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
