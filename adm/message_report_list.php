<?php
$sub_menu = "300900";
require_once './_common.php';

// 게시판 관리 권한 또는 최고관리자
$auth_check = ($is_admin == 'super');
if (!$auth_check && isset($auth[$sub_menu])) {
    $auth_check = (strpos($auth[$sub_menu], 'r') !== false);
}
if (!$auth_check) {
    alert('접근 권한이 없습니다.');
}

// 검색 (신고자 / 작성자 ID, 사유)
$sfl = isset($_GET['sfl']) ? preg_replace('/[^a-z0-9_.]/i', '', $_GET['sfl']) : '';
$stx = isset($_GET['stx']) ? trim($_GET['stx']) : '';

$sql_search = " where (1) ";
if ($stx !== '') {
    $allowed_sfl = array('reporter_mb_id', 'writer_mb_id', 'mr_reason', 'wr_subject');
    if (!in_array($sfl, $allowed_sfl)) $sfl = 'reporter_mb_id';
    $stx_esc = sql_escape_string($stx);
    $sql_search .= " and ({$sfl} like '%{$stx_esc}%') ";
}

// 정렬
$sst = isset($_GET['sst']) ? preg_replace('/[^a-z0-9_]/i', '', $_GET['sst']) : '';
$sod = isset($_GET['sod']) ? strtolower($_GET['sod']) : '';
$allowed_sst = array('mr_id', 'wr_id', 'reporter_mb_id', 'writer_mb_id', 'mr_datetime');
if (!in_array($sst, $allowed_sst)) $sst = 'mr_id';
if (!in_array($sod, array('asc', 'desc'))) $sod = 'desc';
$sql_order = " order by {$sst} {$sod} ";

// 전체 건수
$row = sql_fetch(" select count(*) as cnt from {$g5['message_report_table']} {$sql_search} ");
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'] ? $config['cf_page_rows'] : 15;
$total_page = ceil($total_count / $rows);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$from_record = ($page - 1) * $rows;

$sql = " select * from {$g5['message_report_table']} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall btn_ov02">전체목록</a>';

$g5['title'] = "메세지 신고내역";
require_once './admin.head.php';

$colspan = 8;
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">신고 건수</span><span class="ov_num"><?php echo number_format($total_count) ?>건</span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="reporter_mb_id" <?php echo $sfl == 'reporter_mb_id' ? 'selected' : ''; ?>>신고자 ID</option>
        <option value="writer_mb_id" <?php echo $sfl == 'writer_mb_id' ? 'selected' : ''; ?>>작성자 ID</option>
        <option value="wr_subject" <?php echo $sfl == 'wr_subject' ? 'selected' : ''; ?>>제목</option>
        <option value="mr_reason" <?php echo $sfl == 'mr_reason' ? 'selected' : ''; ?>>신고사유</option>
    </select>
    <label for="stx" class="sound_only">검색어</label>
    <input type="text" name="stx" value="<?php echo htmlspecialchars($stx, ENT_QUOTES); ?>" id="stx" class="frm_input">
    <input type="submit" value="검색" id="fsearch_submit" class="btn_submit">
</form>

<form name="freportlist" id="freportlist" method="post" action="./message_report_list_delete.php" onsubmit="return freportlist_submit(this);">
    <input type="hidden" name="sfl" value="<?php echo htmlspecialchars($sfl, ENT_QUOTES); ?>">
    <input type="hidden" name="stx" value="<?php echo htmlspecialchars($stx, ENT_QUOTES); ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">

    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th scope="col">
                        <label for="chkall" class="sound_only">전체선택</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col">번호</th>
                    <th scope="col">글ID</th>
                    <th scope="col">제목</th>
                    <th scope="col">작성자</th>
                    <th scope="col">신고자</th>
                    <th scope="col">신고사유</th>
                    <th scope="col">신고일시</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $view_url = G5_BBS_URL . '/board.php?bo_table=messages';
                $count = 0;
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $bg = 'bg' . ($i % 2);
                ?>
                    <tr class="<?php echo $bg; ?>">
                        <td class="td_chk">
                            <label for="chk_<?php echo $i; ?>" class="sound_only">선택</label>
                            <input type="checkbox" name="chk[]" value="<?php echo (int)$row['mr_id']; ?>" id="chk_<?php echo $i; ?>">
                        </td>
                        <td class="td_num"><?php echo (int)$row['mr_id']; ?></td>
                        <td class="td_num">
                            <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=messages&amp;wr_id=<?php echo (int)$row['wr_id']; ?>" target="_blank"><?php echo (int)$row['wr_id']; ?></a>
                        </td>
                        <td class="td_subject"><?php echo htmlspecialchars($row['wr_subject'], ENT_QUOTES); ?></td>
                        <td class="td_mbid"><?php echo htmlspecialchars($row['writer_mb_id'], ENT_QUOTES); ?></td>
                        <td class="td_mbid"><?php echo htmlspecialchars($row['reporter_mb_id'], ENT_QUOTES); ?></td>
                        <td class="td_left" style="text-align:left; white-space:pre-line; word-break:break-all;"><?php echo nl2br(htmlspecialchars($row['mr_reason'], ENT_QUOTES)); ?></td>
                        <td class="td_datetime"><?php echo $row['mr_datetime']; ?></td>
                    </tr>
                <?php
                    $count++;
                }

                if ($count == 0) {
                    echo '<tr><td colspan="' . $colspan . '" class="empty_table">신고 내역이 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="btn_list01 btn_list">
        <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
    </div>
</form>

<?php
$pagelist = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page=');
echo $pagelist;
?>

<script>
    function freportlist_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }
        if (document.pressed == "선택삭제") {
            if (!confirm("선택한 신고 내역을 정말 삭제하시겠습니까?")) {
                return false;
            }
        }
        return true;
    }
</script>

<?php
require_once './admin.tail.php';
