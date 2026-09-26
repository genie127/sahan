<?php
/**
 * 앱 푸시 토큰 등록 API
 * 
 * POST /api/push/register.php
 * Body (JSON): {
 *   "token":     "ExponentPushToken[xxxxxx]",   // 필수
 *   "platform":  "ios" | "android",              // 선택
 *   "device_id": "uuid-string"                   // 선택 (중복 방지용)
 * }
 * 
 * Response (JSON): { "success": true }
 *                  { "success": false, "message": "오류내용" }
 */

// ── CORS 허용 (앱 WebView에서 직접 호출 시 필요) ─────────────────────
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'POST 요청만 허용됩니다.']);
    exit;
}

// ── DB 연결 (그누보드 dbconfig.php 직접 사용) ────────────────────────
// dbconfig.php 는 _GNUBOARD_ 상수가 없으면 exit 하므로 먼저 정의
define('_GNUBOARD_', true);

// 이 파일의 위치: /api/push/register.php  →  루트는 두 단계 위
$root_path = dirname(dirname(__DIR__));

$dbconfig_file = $root_path . '/data/dbconfig.php';
if (!file_exists($dbconfig_file)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB 설정 파일을 찾을 수 없습니다.']);
    exit;
}

include_once($dbconfig_file);

// mysqli 직접 연결 (그누보드 공통 함수 없이 독립 실행 가능하도록)
$mysqli = new mysqli(G5_MYSQL_HOST, G5_MYSQL_USER, G5_MYSQL_PASSWORD, G5_MYSQL_DB);
if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB 연결 실패']);
    exit;
}
$mysqli->set_charset('utf8mb4');

// ── 입력값 파싱 ──────────────────────────────────────────────────────
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    // form-data 폴백
    $input = $_POST;
}

$token     = isset($input['token'])     ? trim($input['token'])     : '';
$platform  = isset($input['platform'])  ? trim($input['platform'])  : '';
$device_id = isset($input['device_id']) ? trim($input['device_id']) : '';
$mb_id     = isset($input['mb_id'])     ? trim($input['mb_id'])     : '';

// ── 유효성 검사 ──────────────────────────────────────────────────────
if (!$token) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'token 값이 필요합니다.']);
    $mysqli->close();
    exit;
}

// Expo 토큰 형식 간단 검증: ExponentPushToken[...] 또는 ExpoPushToken[...]
if (!preg_match('/^Expo(nent)?PushToken\[.+\]$/', $token)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => '올바른 Expo 푸시 토큰 형식이 아닙니다.']);
    $mysqli->close();
    exit;
}

// 길이 제한
$token     = substr($token,     0, 255);
$platform  = substr(preg_replace('/[^a-z]/', '', strtolower($platform)), 0, 10);
$device_id = substr($device_id, 0, 255);
$mb_id     = substr(preg_replace('/[^a-zA-Z0-9_]/', '', $mb_id), 0, 20);

// device_id 없으면 token 을 대신 사용
if (!$device_id) {
    $device_id = $token;
}

// ── DB 저장 (device_id 기준 upsert) ─────────────────────────────────
$table = G5_TABLE_PREFIX . 'device_tokens';

$stmt = $mysqli->prepare("
    INSERT INTO `{$table}`
        (dt_token, dt_platform, dt_mb_id, dt_device_id, dt_created_at, dt_updated_at)
    VALUES (?, ?, ?, ?, NOW(), NOW())
    ON DUPLICATE KEY UPDATE
        dt_token      = VALUES(dt_token),
        dt_platform   = VALUES(dt_platform),
        dt_mb_id      = VALUES(dt_mb_id),
        dt_updated_at = NOW()
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB 준비 오류: ' . $mysqli->error]);
    $mysqli->close();
    exit;
}

$stmt->bind_param('ssss', $token, $platform, $mb_id, $device_id);
$result = $stmt->execute();

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB 저장 오류: ' . $stmt->error]);
    $stmt->close();
    $mysqli->close();
    exit;
}

$stmt->close();
$mysqli->close();

echo json_encode(['success' => true, 'message' => '토큰이 등록되었습니다.']);
