<?php
/*
 * 게시글 일괄 등록 (CSV 업로드)
 * messages 게시판 전용 - 실제 스킨 필드 구조에 맞춤
 */
$sub_menu = "300100";
require_once './_common.php';

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
    exit;
}

// 샘플 CSV 다운로드
if (isset($_GET['download_sample'])) {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="messages_import_sample.csv"');
    // UTF-8 BOM (Excel 한글 깨짐 방지)
    echo "\xEF\xBB\xBF";
    // 헤더
    echo "내용,수신인코드,전체공개,발신인코드,날짜명대사,이벤트명대사,표기날짜(wr_subject),임의날짜(wr_6),공개확인,회원ID,작성일시\n";
    // 예시 1: 일반 메시지 (수신인에게만)
    echo "\"<p>안녕하세요! 보내는 메시지입니다.</p>\",USER001,0,SAHAN,0,0,,,1,admin,2024-03-15 10:00:00\n";
    // 예시 2: 전체공개 메시지
    echo "\"<p>전체 공개 메시지 내용입니다.</p>\",USER002,1,SAHAN,0,0,,,1,,2024-03-16 11:00:00\n";
    // 예시 3: 날짜 명대사 (wr_subject=0316, wr_6=목록표시날짜)
    echo "\"<p>오늘의 명대사입니다.</p>\",,1,SAHAN,1,0,0316,2024.03.16,1,admin,2024-03-16 09:00:00\n";
    // 예시 4: 이벤트 명대사 (wr_subject 비워도 됨)
    echo "\"<p>이벤트 특별 메시지입니다.</p>\",,1,SAHAN,0,1,,,1,admin,2024-03-20 10:00:00\n";
    exit;
}

$bo_table = 'messages';
$g5['title'] = '게시글 일괄 등록 - MESSAGES';
require_once G5_ADMIN_PATH.'/admin.head.php';
?>

<style>
.import-wrap { max-width: 980px; margin: 20px auto; }
.import-wrap h2 { font-size: 20px; margin-bottom: 16px; }
.import-wrap h3 { font-size: 15px; margin: 22px 0 8px; padding-bottom: 5px; border-bottom: 2px solid #ddd; }
.import-wrap table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 13px; }
.import-wrap th { background: #3d3d3d; color: #fff; padding: 9px 12px; text-align: left; font-weight: normal; }
.import-wrap td { padding: 8px 12px; border-bottom: 1px solid #e0e0e0; vertical-align: top; }
.import-wrap tr:nth-child(even) td { background: #f8f8f8; }
.req { color: #e74c3c; font-weight: bold; }
.tip-box { background: #fffbe6; border: 1px solid #f0c36d; padding: 14px 18px; border-radius: 4px; margin-bottom: 18px; }
.tip-box strong { color: #7a5c00; display: block; margin-bottom: 6px; font-size: 14px; }
.tip-box ul { margin: 0; padding-left: 20px; }
.tip-box li { margin-bottom: 5px; color: #555; font-size: 13px; }
.warn-box { background: #fdf2f2; border: 1px solid #e8b4b8; padding: 12px 18px; border-radius: 4px; margin-bottom: 18px; }
.warn-box strong { color: #c0392b; display: block; margin-bottom: 4px; }
.warn-box ul { margin: 0; padding-left: 20px; }
.warn-box li { font-size: 13px; color: #666; margin-bottom: 3px; }
.sample-link { display: inline-block; margin: 12px 0 4px; padding: 9px 18px; background: #27ae60; color: #fff !important; text-decoration: none; border-radius: 3px; font-size: 13px; }
.sample-link:hover { background: #219a52; }
.upload-area { border: 2px dashed #bbb; padding: 28px 20px; text-align: center; border-radius: 6px; background: #fafafa; margin-top: 8px; }
.upload-area p { margin: 0 0 10px; color: #666; font-size: 13px; }
.submit-btn { background: #2980b9; color: #fff; border: none; padding: 12px 30px; font-size: 14px; border-radius: 4px; cursor: pointer; margin-top: 14px; }
.submit-btn:hover { background: #2471a3; }
code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; font-family: monospace; font-size: 12px; }
.opt-row { margin: 10px 0; font-size: 13px; }
.type-badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 11px; color: #fff; margin-left: 4px; }
.type-normal { background: #2980b9; }
.type-open { background: #27ae60; }
.type-sentence { background: #8e44ad; }
</style>

<div class="import-wrap">
    <h2>📨 MESSAGES 게시판 &mdash; 게시글 일괄 등록</h2>

    <div class="tip-box">
        <strong>📌 사용 방법</strong>
        <ul>
            <li>아래 <strong>샘플 CSV 파일</strong>을 다운로드하여 엑셀로 열고 데이터를 입력합니다.</li>
            <li>완성 후 엑셀에서 <strong>다른 이름으로 저장 → CSV UTF-8 (쉼표로 분리) (*.csv)</strong> 로 저장하세요.</li>
            <li>저장한 CSV 파일을 아래에서 업로드하면 즉시 등록됩니다.</li>
            <li>한 번에 <strong>최대 500건</strong>까지 처리 가능합니다.</li>
        </ul>
    </div>

    <div class="warn-box">
        <strong>⚠ 메시지 타입별 필수 규칙</strong>
        <ul>
            <li><span class="type-badge type-normal">일반 메시지</span> 수신인코드(B열) <strong>필수</strong>, 전체공개=0</li>
            <li><span class="type-badge type-open">전체공개 메시지</span> 전체공개(C열)=1, 수신인코드 없어도 됨</li>
            <li><span class="type-badge type-sentence">날짜 명대사</span> 날짜명대사(E열)=1, 임의날짜(G열) 필수 <code>2024.03.16</code> 형식</li>
            <li><span class="type-badge type-sentence">이벤트 명대사</span> 이벤트명대사(F열)=1</li>
            <li>날짜명대사/이벤트명대사는 동시에 1로 설정할 수 없습니다.</li>
        </ul>
    </div>

    <h3>📊 엑셀 컬럼 양식 (총 11열)</h3>
    <table>
        <thead>
        <tr>
            <th width="60">열</th>
            <th width="160">항목명 (DB 필드)</th>
            <th width="80">필수</th>
            <th>설명 / 입력값</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong>A열</strong></td>
            <td>내용 <code>wr_content</code></td>
            <td><span class="req">✅ 필수</span></td>
            <td>메시지 본문. HTML 태그 가능. 쉼표·줄바꿈 포함 시 큰따옴표로 감싸세요.<br>예: <code>"&lt;p&gt;안녕하세요!&lt;/p&gt;"</code></td>
        </tr>
        <tr>
            <td><strong>B열</strong></td>
            <td>수신인코드 <code>wr_5</code></td>
            <td>조건부 필수</td>
            <td>받는 사람의 코드. 전체공개·명대사면 비워도 됨.<br>일반 메시지는 <strong>필수</strong> (이 값이 제목으로도 저장됨)</td>
        </tr>
        <tr>
            <td><strong>C열</strong></td>
            <td>전체공개 <code>wr_1</code></td>
            <td><span class="req">✅ 필수</span></td>
            <td><code>1</code> = 전체 목록에 노출 &nbsp; <code>0</code> = 수신인에게만 노출</td>
        </tr>
        <tr>
            <td><strong>D열</strong></td>
            <td>발신인코드 <code>wr_4</code></td>
            <td>선택</td>
            <td>from. 옆에 표시되는 코드. 숫자·영문 모두 가능. 비워두면 회원ID 또는 SAHAN 표시.<br>예: <code>SAHAN</code></td>
        </tr>
        <tr>
            <td><strong>E열</strong></td>
            <td>날짜명대사 <code>wr_2</code></td>
            <td><span class="req">✅ 필수</span></td>
            <td><code>1</code> = 날짜 명대사 &nbsp; <code>0</code> = 일반</td>
        </tr>
        <tr>
            <td><strong>F열</strong></td>
            <td>이벤트명대사 <code>wr_3</code></td>
            <td><span class="req">✅ 필수</span></td>
            <td><code>1</code> = 이벤트 명대사 &nbsp; <code>0</code> = 일반 &nbsp; (E열과 동시에 1 불가)</td>
        </tr>
        <tr style="background:#fff8e6;">
            <td><strong>G열</strong></td>
            <td>표기날짜 <code>wr_subject</code></td>
            <td>조건부 필수</td>
            <td>날짜명대사(E열=1)일 때 <strong>월일 4자리</strong> 입력. 이벤트명대사·일반은 비워도 됨.<br>예: <code>0316</code> (3월 16일)</td>
        </tr>
        <tr>
            <td><strong>H열</strong></td>
            <td>임의날짜 <code>wr_6</code></td>
            <td>조건부 필수</td>
            <td>날짜명대사(E열=1)일 때 목록에 표시될 날짜. 일반 메시지는 비워도 됨.<br>예: <code>2024.03.16</code></td>
        </tr>
        <tr>
            <td><strong>I열</strong></td>
            <td>공개확인 <code>wr_8</code></td>
            <td><span class="req">✅ 필수</span></td>
            <td>항상 <code>1</code> 입력</td>
        </tr>
        <tr>
            <td><strong>J열</strong></td>
            <td>회원ID <code>mb_id</code></td>
            <td>선택</td>
            <td>등록자 회원 ID. 비워두면 비회원 처리. 예: <code>admin</code></td>
        </tr>
        <tr>
            <td><strong>K열</strong></td>
            <td>작성일시 <code>wr_datetime</code></td>
            <td>선택</td>
            <td>비워두면 현재 시간 자동 입력. 형식: <code>2024-03-15 10:00:00</code></td>
        </tr>
        </tbody>
    </table>

    <a href="<?php echo G5_ADMIN_URL; ?>/write_bulk_import.php?download_sample=1" class="sample-link">
        ⬇ 샘플 CSV 파일 다운로드
    </a>

    <h3>📁 CSV 파일 업로드</h3>
    <form method="post" enctype="multipart/form-data" action="<?php echo G5_ADMIN_URL; ?>/write_bulk_import_update.php">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">

        <div class="upload-area">
            <p>📂 CSV 파일을 선택하세요 (최대 10MB)</p>
            <input type="file" name="import_file" accept=".csv,text/csv" required>
        </div>

        <div class="opt-row">
            <label>
                <input type="checkbox" name="skip_header" value="1" checked>
                첫 번째 행(헤더 행)은 건너뜁니다
            </label>
        </div>
        <div class="opt-row">
            <label>
                기본 작성자 IP:
                <input type="text" name="default_ip" value="127.0.0.1" size="18" style="margin-left:6px;">
            </label>
        </div>

        <button type="submit" class="submit-btn">🚀 일괄 등록 시작</button>
    </form>
</div>

<?php require_once G5_ADMIN_PATH.'/admin.tail.php'; ?>
