<?php
/**
 * Expo 푸시 알림 발송 스크립트
 * 
 * ────────────────────────────────────────────────────────────
 * 크론잡 등록 (매년 10월 21일 00:00:00 KST 자동 실행):
 *   0 0 21 10 * /usr/bin/php /var/www/html/api/push/send_push.php >> /var/log/push_send.log 2>&1
 * 
 * 수동 실행:
 *   php send_push.php
 *   php send_push.php --title="제목" --body="내용"
 * 
 * 웹 호출 (비상용 — IP 제한 권장):
 *   https://yourdomain.com/api/push/send_push.php?secret=여기에_시크릿키
 * ────────────────────────────────────────────────────────────
 */

// ── 웹 직접 호출 방어 ────────────────────────────────────────────────
// CLI 실행이 아닌 경우 시크릿 키 검사
define('PUSH_SECRET_KEY', 'sahan_push_2026!@#$');  // ← cron-job.org URL에 이 값 사용

$is_cli = (php_sapi_name() === 'cli');

if (!$is_cli) {
    header('Content-Type: text/plain; charset=utf-8');
    $secret = isset($_GET['secret']) ? $_GET['secret'] : '';
    if (!hash_equals(PUSH_SECRET_KEY, $secret)) {
        http_response_code(403);
        echo "접근 거부\n";
        exit;
    }
}

// ── DB 연결 설정 로드 ────────────────────────────────────────────────
define('_GNUBOARD_', true);

// CLI 실행 시 __DIR__ 기준으로 절대 경로 계산
$root_path = dirname(dirname(__DIR__));

$dbconfig_file = $root_path . '/data/dbconfig.php';
if (!file_exists($dbconfig_file)) {
    log_msg('오류: dbconfig.php 를 찾을 수 없습니다. 경로: ' . $dbconfig_file);
    exit(1);
}

include_once($dbconfig_file);

// ── 발송 메시지 설정 ─────────────────────────────────────────────────
// CLI 인자로 제목/내용 오버라이드 가능: --title="제목" --body="내용"
$push_title = '사한절';                             // ← 원하는 제목으로 수정
$push_body  = 'Happy Birthday To 희건,사한'; // ← 원하는 내용으로 수정
$push_data  = [];                                        // 앱에 추가로 전달할 데이터 (선택)

if ($is_cli) {
    foreach ($argv as $arg) {
        if (preg_match('/^--title=(.+)$/', $arg, $m)) $push_title = $m[1];
        if (preg_match('/^--body=(.+)$/',  $arg, $m)) $push_body  = $m[1];
    }
}

// ── DB 연결 ──────────────────────────────────────────────────────────
$mysqli = new mysqli(G5_MYSQL_HOST, G5_MYSQL_USER, G5_MYSQL_PASSWORD, G5_MYSQL_DB);
if ($mysqli->connect_errno) {
    log_msg('오류: DB 연결 실패 - ' . $mysqli->connect_error);
    exit(1);
}
$mysqli->set_charset('utf8mb4');

// ── 토큰 전체 조회 ───────────────────────────────────────────────────
$table  = G5_TABLE_PREFIX . 'device_tokens';
$result = $mysqli->query("SELECT dt_token FROM `{$table}` WHERE dt_token != '' ORDER BY dt_id ASC");

if (!$result) {
    log_msg('오류: 토큰 조회 실패 - ' . $mysqli->error);
    $mysqli->close();
    exit(1);
}

$tokens = [];
while ($row = $result->fetch_assoc()) {
    $tokens[] = $row['dt_token'];
}
$result->free();
$mysqli->close();

$total = count($tokens);
if ($total === 0) {
    log_msg('등록된 토큰 없음. 발송 종료.');
    exit(0);
}

log_msg("총 {$total}개 토큰 발송 시작. 제목: [{$push_title}]");

// ── Expo Push API 배치 발송 (100개씩) ───────────────────────────────
$expo_url   = 'https://exp.host/--/api/v2/push/send';
$batch_size = 100;
$batches    = array_chunk($tokens, $batch_size);
$success    = 0;
$fail       = 0;

foreach ($batches as $batch_index => $batch_tokens) {
    $messages = [];
    foreach ($batch_tokens as $token) {
        $messages[] = [
            'to'    => $token,
            'title' => $push_title,
            'body'  => $push_body,
            'data'  => $push_data,
            'sound' => 'default',
        ];
    }

    $response = expo_push_send($expo_url, $messages);

    if ($response === false) {
        log_msg("배치 " . ($batch_index + 1) . ": HTTP 요청 실패");
        $fail += count($batch_tokens);
        continue;
    }

    $decoded = json_decode($response, true);
    if (!isset($decoded['data']) || !is_array($decoded['data'])) {
        log_msg("배치 " . ($batch_index + 1) . ": 응답 파싱 실패 - " . substr($response, 0, 200));
        $fail += count($batch_tokens);
        continue;
    }

    foreach ($decoded['data'] as $item) {
        if (isset($item['status']) && $item['status'] === 'ok') {
            $success++;
        } else {
            $fail++;
            $detail = isset($item['message']) ? $item['message'] : '알 수 없는 오류';
            log_msg("발송 실패 토큰: " . ($item['details']['expoPushToken'] ?? '?') . " - {$detail}");
        }
    }

    log_msg("배치 " . ($batch_index + 1) . "/" . count($batches) . " 완료 (성공: {$success}, 실패: {$fail})");

    // API 과부하 방지: 배치 사이에 잠깐 대기
    if (count($batches) > 1 && $batch_index < count($batches) - 1) {
        usleep(300000); // 0.3초
    }
}

log_msg("발송 완료. 성공: {$success}, 실패: {$fail}, 전체: {$total}");
exit(0);

// ── 헬퍼 함수 ────────────────────────────────────────────────────────

/**
 * Expo Push API HTTP 요청 (curl 또는 file_get_contents 폴백)
 */
function expo_push_send($url, $messages)
{
    $payload = json_encode($messages, JSON_UNESCAPED_UNICODE);
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
        'Accept-Encoding: gzip, deflate',
    ];

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $response = curl_exec($ch);
        $err      = curl_error($ch);
        curl_close($ch);

        if ($err) {
            log_msg('cURL 오류: ' . $err);
            return false;
        }
        return $response;
    }

    // curl 없을 때 file_get_contents 폴백
    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => implode("\r\n", $headers),
            'content' => $payload,
            'timeout' => 30,
        ],
        'ssl' => ['verify_peer' => true],
    ]);

    $response = @file_get_contents($url, false, $context);
    return $response;
}

/**
 * 로그 출력 (CLI: stdout, 웹: echo)
 */
function log_msg($msg)
{
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n";
    echo $line;
    if (php_sapi_name() === 'cli') {
        // flush 보장
        if (ob_get_level()) ob_flush();
        flush();
    }
}
