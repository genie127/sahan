<?php
/*
 * 게시글 일괄 등록 처리
 * messages 게시판 전용 - 실제 스킨 필드 구조에 맞춤
 *
 * 컬럼 순서 (CSV):
 * A: wr_content  내용 (필수)
 * B: wr_5        수신인코드
 * C: wr_1        전체공개 (0/1)
 * D: wr_4        발신인코드
 * E: wr_2        날짜명대사 (0/1)
 * F: wr_3        이벤트명대사 (0/1)
 * G: wr_subject  표기날짜 - 날짜명대사일 때 월일 4자리 (예: 0316)
 * H: wr_6        임의날짜 (2024.03.16 형식)
 * I: wr_8        공개확인 (항상 1)
 * J: mb_id       회원ID
 * K: wr_datetime 작성일시
 */
$sub_menu = "300100";
require_once './_common.php';

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    alert('잘못된 접근입니다.', G5_ADMIN_URL.'/write_bulk_import.php');
    exit;
}

$bo_table   = isset($_POST['bo_table']) ? preg_replace('/[^a-z0-9_]/i', '', $_POST['bo_table']) : '';
$skip_hdr   = !empty($_POST['skip_header']);
$default_ip = isset($_POST['default_ip']) ? preg_replace('/[^0-9\.]/', '', trim($_POST['default_ip'])) : '127.0.0.1';

if ($bo_table !== 'messages') {
    alert('허용되지 않은 게시판입니다.');
    exit;
}

$write_table = $g5['write_prefix'] . $bo_table;

// ── 파일 업로드 확인 ─────────────────────────────────────────────────
if (empty($_FILES['import_file']) || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
    $code = isset($_FILES['import_file']['error']) ? $_FILES['import_file']['error'] : 'none';
    alert('파일 업로드 오류가 발생했습니다. (code:'.$code.')');
    exit;
}

$file_tmp = $_FILES['import_file']['tmp_name'];
$file_ext = strtolower(pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION));

if ($file_ext !== 'csv') {
    alert('CSV 파일(.csv)만 업로드 가능합니다.');
    exit;
}

// ── 파일 읽기 & 인코딩 변환 ──────────────────────────────────────────
$content = file_get_contents($file_tmp);
if ($content === false) { alert('파일을 읽을 수 없습니다.'); exit; }

// UTF-8 BOM 제거
$content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

// EUC-KR / CP949 대응
$enc = mb_detect_encoding($content, ['UTF-8','EUC-KR','CP949','ISO-8859-1'], true);
if ($enc && $enc !== 'UTF-8') {
    $content = mb_convert_encoding($content, 'UTF-8', $enc);
}

$content = str_replace(["\r\n", "\r"], "\n", $content);

// ── CSV 파싱 ─────────────────────────────────────────────────────────
$lines = explode("\n", $content);
$rows  = [];
foreach ($lines as $line) {
    $line = rtrim($line);
    if ($line === '') continue;
    $rows[] = str_getcsv($line, ',', '"');
}

if (empty($rows)) { alert('CSV 파일에 데이터가 없습니다.'); exit; }

$start    = $skip_hdr ? 1 : 0;
$data_rows = array_slice($rows, $start);

if (empty($data_rows)) { alert('등록할 데이터가 없습니다.'); exit; }
if (count($data_rows) > 500) { alert('한 번에 최대 500건까지만 등록 가능합니다. 현재: '.count($data_rows).'건'); exit; }

// ── wr_num 기준값 ─────────────────────────────────────────────────────
$row_num = sql_fetch("SELECT MIN(wr_num) as mn FROM `{$write_table}`");
$wr_num  = (isset($row_num['mn']) && $row_num['mn'] !== null) ? (int)$row_num['mn'] : 0;

$success = 0;
$fail    = 0;
$errs    = [];
$now     = date('Y-m-d H:i:s');

// ── 행 처리 루프 ──────────────────────────────────────────────────────
foreach ($data_rows as $idx => $row) {
    $row_no = $idx + $start + 1; // 실제 행 번호(헤더 포함)

    // ── 컬럼 읽기 ──────────────────────────────────────────────────
    $wr_content  = isset($row[0]) ? trim($row[0]) : '';   // A: 내용
    $wr_5        = isset($row[1]) ? trim($row[1]) : '';   // B: 수신인코드
    $wr_1        = isset($row[2]) ? trim($row[2]) : '0';  // C: 전체공개
    $wr_4        = isset($row[3]) ? trim($row[3]) : '';   // D: 발신인코드
    $wr_2        = isset($row[4]) ? trim($row[4]) : '0';  // E: 날짜명대사
    $wr_3        = isset($row[5]) ? trim($row[5]) : '0';  // F: 이벤트명대사
    $wr_subject  = isset($row[6]) ? trim($row[6]) : '';   // G: 표기날짜 (날짜명대사 시 월일 4자리)
    $wr_6        = isset($row[7]) ? trim($row[7]) : '';   // H: 임의날짜
    $wr_8        = isset($row[8]) ? trim($row[8]) : '1';  // I: 공개확인
    $mb_id       = isset($row[9]) ? trim($row[9]) : '';   // J: 회원ID
    $wr_datetime = isset($row[10]) ? trim($row[10]) : ''; // K: 작성일시

    // ── 유효성 검사 ────────────────────────────────────────────────
    if ($wr_content === '') {
        $fail++;
        $errs[] = "{$row_no}행: 내용(A열)이 비어 있습니다.";
        continue;
    }

    // 날짜명대사·이벤트명대사 동시 체크 불가
    $wr_2 = ($wr_2 === '1') ? '1' : '0';
    $wr_3 = ($wr_3 === '1') ? '1' : '0';
    if ($wr_2 === '1' && $wr_3 === '1') {
        $fail++;
        $errs[] = "{$row_no}행: 날짜명대사(E열)와 이벤트명대사(F열)를 동시에 1로 설정할 수 없습니다.";
        continue;
    }

    // 일반 메시지인데 수신인코드도 없고 전체공개도 아닌 경우 경고
    $wr_1 = ($wr_1 === '1') ? '1' : '0';
    $is_sentence = ($wr_2 === '1' || $wr_3 === '1');
    if (!$is_sentence && $wr_1 === '0' && $wr_5 === '') {
        $fail++;
        $errs[] = "{$row_no}행: 일반 메시지는 수신인코드(B열) 또는 전체공개(C열=1)가 필요합니다.";
        continue;
    }

    // 날짜명대사인데 임의날짜 없으면 경고
    if ($wr_2 === '1' && $wr_6 === '') {
        $fail++;
        $errs[] = "{$row_no}행: 날짜명대사(E열=1)일 때 임의날짜(H열)가 필요합니다. 예: 2024.03.16";
        continue;
    }

    // 정수형 변환
    $wr_8 = '1'; // 항상 1

    // 날짜
    if ($wr_datetime === '' || !preg_match('/^\d{4}-\d{2}-\d{2}/', $wr_datetime)) {
        $wr_datetime = $now;
    }

    // wr_subject 처리
    // - 날짜명대사(wr_2=1): G열에서 직접 입력한 월일 4자리 사용 (예: 0316)
    // - 이벤트명대사(wr_3=1): 빈값 허용
    // - 일반 메시지: wr_5(수신인코드)로 자동 세팅 (write_update.php와 동일한 로직)
    if ($wr_2 !== '1' && $wr_3 !== '1') {
        // 일반 메시지: wr_subject = 수신인코드
        $wr_subject = $wr_5;
    }
    // 날짜명대사이면서 wr_subject가 비어있으면 오류
    if ($wr_2 === '1' && $wr_subject === '') {
        $fail++;
        $errs[] = "{$row_no}행: 날짜명대사(E열=1)일 때 표기날짜(G열)에 월일 4자리를 입력하세요. 예: 0316";
        continue;
    }

    // SEO 제목
    $wr_seo_title = '';
    if (function_exists('generate_seo_title') && $wr_subject !== '') {
        $wr_seo_title = generate_seo_title($wr_subject);
    }

    // ── 이스케이프 ─────────────────────────────────────────────────
    $e_subject  = sql_escape_string($wr_subject);
    $e_content  = sql_escape_string($wr_content);
    $e_mb_id    = sql_escape_string($mb_id);
    $e_datetime = sql_escape_string($wr_datetime);
    $e_seo      = sql_escape_string($wr_seo_title);
    $e_ip       = sql_escape_string($default_ip);
    $e_wr_1     = sql_escape_string($wr_1);
    $e_wr_2     = sql_escape_string($wr_2);
    $e_wr_3     = sql_escape_string($wr_3);
    $e_wr_4     = sql_escape_string($wr_4);
    $e_wr_5     = sql_escape_string($wr_5);
    $e_wr_6     = sql_escape_string($wr_6);
    $e_wr_8     = '1';

    $wr_num--;

    $sql = "INSERT INTO `{$write_table}`
                (wr_num, wr_reply, wr_parent, wr_is_comment, wr_comment, wr_comment_reply,
                 ca_name, wr_option, wr_subject, wr_content, wr_seo_title,
                 wr_link1, wr_link2, wr_link1_hit, wr_link2_hit,
                 wr_hit, wr_good, wr_nogood,
                 mb_id, wr_password, wr_name, wr_email, wr_homepage,
                 wr_datetime, wr_file, wr_last, wr_ip,
                 wr_facebook_user, wr_twitter_user,
                 wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10)
            VALUES
                ({$wr_num}, '', 0, 0, 0, '',
                 '', 'html1', '{$e_subject}', '{$e_content}', '{$e_seo}',
                 '', '', 0, 0,
                 0, 0, 0,
                 '{$e_mb_id}', '', '{$e_mb_id}', '', '',
                 '{$e_datetime}', 0, '{$e_datetime}', '{$e_ip}',
                 '', '',
                 '{$e_wr_1}', '{$e_wr_2}', '{$e_wr_3}', '{$e_wr_4}',
                 '{$e_wr_5}', '{$e_wr_6}', '', '{$e_wr_8}', '', '')";

    $result = sql_query($sql, false);

    if ($result) {
        $new_id = sql_insert_id();
        // wr_parent = 자신의 wr_id (그누보드 원글 구조)
        sql_query("UPDATE `{$write_table}` SET wr_parent = {$new_id} WHERE wr_id = {$new_id}");
        // 새글 테이블
        sql_query("INSERT INTO `{$g5['board_new_table']}` (bo_table, wr_id, wr_parent, bn_datetime)
                   VALUES ('{$bo_table}', {$new_id}, {$new_id}, '{$e_datetime}')");
        $success++;
    } else {
        $fail++;
        $errs[] = "{$row_no}행: DB 오류 - " . htmlspecialchars(mb_substr($wr_content, 0, 30));
    }
}

// 게시판 글 수 업데이트
if ($success > 0) {
    sql_query("UPDATE `{$g5['board_table']}`
               SET bo_count_write = bo_count_write + {$success}
               WHERE bo_table = '{$bo_table}'");
}

// ── 결과 출력 ─────────────────────────────────────────────────────────
$g5['title'] = '일괄 등록 결과';
require_once G5_ADMIN_PATH.'/admin.head.php';
?>
<style>
.result-wrap { max-width: 820px; margin: 20px auto; }
.result-wrap h2 { font-size: 20px; margin-bottom: 16px; }
.rbox { padding: 16px 20px; border-radius: 5px; margin-bottom: 14px; font-size: 14px; }
.rbox-info    { background:#d1ecf1; border:1px solid #bee5eb; color:#0c5460; }
.rbox-ok      { background:#d4edda; border:1px solid #c3e6cb; color:#155724; }
.rbox-err     { background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; }
.err-scroll   { max-height:260px; overflow-y:auto; background:#fff; border:1px solid #ddd; padding:10px 14px; border-radius:4px; margin-top:10px; }
.err-scroll li { margin-bottom:4px; font-size:12px; }
.abtn { display:inline-block; padding:10px 22px; border-radius:4px; text-decoration:none; margin:4px; color:#fff !important; font-size:13px; }
.abtn-gray  { background:#6c757d; }
.abtn-green { background:#27ae60; }
</style>
<div class="result-wrap">
    <h2>📋 일괄 등록 결과</h2>
    <div class="rbox rbox-info">
        처리: <strong><?php echo $success + $fail; ?>건</strong>
        &nbsp;|&nbsp; 성공: <strong><?php echo $success; ?>건</strong>
        &nbsp;|&nbsp; 실패: <strong><?php echo $fail; ?>건</strong>
    </div>
    <?php if ($success > 0): ?>
    <div class="rbox rbox-ok">✅ <strong><?php echo $success; ?>건</strong> 성공적으로 등록되었습니다.</div>
    <?php endif; ?>
    <?php if ($fail > 0): ?>
    <div class="rbox rbox-err">
        ❌ <strong><?php echo $fail; ?>건</strong> 등록 실패
        <div class="err-scroll"><ul>
            <?php foreach ($errs as $e): ?>
            <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul></div>
    </div>
    <?php endif; ?>
    <div style="margin-top:20px;">
        <a href="<?php echo G5_ADMIN_URL; ?>/write_bulk_import.php" class="abtn abtn-gray">← 다시 업로드</a>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table; ?>" class="abtn abtn-green" target="_blank">게시판 확인 →</a>
    </div>
</div>
<?php require_once G5_ADMIN_PATH.'/admin.tail.php'; ?>
