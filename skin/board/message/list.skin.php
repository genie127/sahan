<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;


$is_board_admin = (
    $is_member &&
    (
        $is_admin == 'super' ||
        $group['gr_admin'] == $member['mb_id'] ||
        $board['bo_admin'] == $member['mb_id']
    )
);

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

// 현재 목록 타입 (mine=내게 온 메시지, all=전체공개 에서만 신고/차단 노출)
$cur_type = isset($_GET['type']) ? $_GET['type'] : '';
$show_report_block_tab = ($cur_type === 'mine' || $cur_type === 'all');

// 로그인 회원이 차단한 발신인(mb_id) 목록 조회 (A: 개인별 차단)
$blocked_mb_ids = array();
if ($is_member && !empty($member['mb_id']) && isset($g5['message_block_table'])) {
    $res = sql_query(" select block_mb_id
                         from {$g5['message_block_table']}
                        where mb_id = '".sql_escape_string($member['mb_id'])."' ");
    while ($res && $brow = sql_fetch_array($res)) {
        $blocked_mb_ids[$brow['block_mb_id']] = true;
    }
}
?>

<style>
    body{padding-top: 70px;}
    body.ios_body{padding-top: 105px;}
    #logo img{height: 35px;}
</style>
<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">
    <!-- <h2 class="subtit">
        <?php echo $board['bo_subject']?>
    </h2> -->
     <div class="hd_search board_search">
        <fieldset id="hd_sch">
            <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
            <label for="sch_stx" class="sound_only">검색어 필수</label>
            <input type="text" name="stx" id="sch_stx" maxlength="20" placeholder="발신인 코드를 검색해보세요">
            <button type="submit" id="sch_submit" class="btn_search" value="검색">
                <span class="ico_search"></span>
            </button>
            </form>

            <script>
            function fsearchbox_submit(f)
            {
                var stx = f.stx.value.trim();

                if (stx.length < 2) {
                    alert("검색어는 두글자 이상 입력하십시오.");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                if (!/^[a-zA-Z0-9]+$/.test(stx)) {
                    alert("검색어는 숫자 또는 영문과 숫자만 입력할 수 있습니다.");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                f.stx.value = stx;

                return true;
            }
            </script>

        </fieldset>
    </div>       
    
    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>

    <nav id="bo_cate">
        <ul id="bo_cate_ul">            
            <?if($member['mb_id']){?>
            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'mine'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=mine">내게 온 메시지</a>
            </li>
            <?}?>

            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'all'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=all">전체공개</a>
            </li>

            <?if($is_board_admin){?>
            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'adm_messages'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=adm_messages">유저 메시지</a>
            </li>

            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'adm_bookmarks'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=adm_bookmarks">유저 북마크</a>
            </li>

            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'adm_date'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=adm_date">명대사(날짜별 메인)</a>
            </li>

            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'adm_special'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=adm_special">명대사(썰 검색)</a>
            </li>
            <?}?>
        </ul>
    </nav>
    <!-- } 게시판 카테고리 끝 -->

    <form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div id="bo_btn_top" class="fixed">
        <?/*
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>
        */?>
        <ul class="btn_bo_user">
            <li class="btn_top btn_board">
                <button type="button" id="top_btn">
                    <img src="<?=G5_IMG_URL?>/ico_top.webp" alt="상단으로">
                </button>
            </li>
            <?php if ($write_href) { ?><li class="btn_write btn_board">
                <a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기">
                    <img src="<?=G5_IMG_URL?>/ico_write.webp" alt="">
                </a>
            </li><?php } ?>
        </ul>
    </div>
    <div id="bo_btn_top">
        <?/*
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>
        */?>
        
        <?php if ($is_checkbox) { ?>
            <div scope="col" class="all_chk chk_box">
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk">
                <label for="chkall">
                    <span></span>
                    <b>현재 페이지 게시물  전체선택</b>
                </label>
        </div>
        <?php } ?>
        <ul class="btn_bo_user">
        	<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
        	<?php if ($is_admin == 'super' || $is_auth) {  ?>
            <li>
            	<button type="button" class="btn_bo_sch btn_b01 btn" title="게시판 검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">게시판 검색</span></button>
            </li>
        	<li>
        		<button type="button" class="btn_more_opt is_list_btn btn_b01 btn" title="게시판 리스트 옵션"><i class="fa fa-ellipsis-v" aria-hidden="true"></i><span class="sound_only">게시판 리스트 옵션</span></button>
        		<?php if ($is_checkbox) { ?>	
		        <ul class="more_opt is_list_btn">  
		            <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"><i class="fa fa-trash-o" aria-hidden="true"></i> 선택삭제</button></li>
		            <li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"><i class="fa fa-files-o" aria-hidden="true"></i> 선택복사</button></li>
		            <li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"><i class="fa fa-arrows" aria-hidden="true"></i> 선택이동</button></li>
		        </ul>
		        <?php } ?>
        	</li>
        	<?php }  ?>
        </ul>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->
        	
    <div class="tbl_head01 tbl_wrap">
        <ul class="msg_wrap">
        <?php
            for ($i=0; $i<count($list); $i++) {

                // 내가 차단한 발신인의 메시지는 목록에서 숨김 (관리자 화면 제외)
                if (!$is_admin && $list[$i]['mb_id'] !== '' && isset($blocked_mb_ids[$list[$i]['mb_id']])) {
                    continue;
                }
            ?>
           <li class="<?php echo $lt_class ?> msg_item" data-writer-mb-id="<?php echo htmlspecialchars($list[$i]['mb_id']); ?>">

           <?php
                $is_bookmarked = false;

                $member_id = isset($member['mb_id'])
                    ? trim($member['mb_id'])
                    : '';

                $original_wr_id = (int)$list[$i]['wr_id'];

                if (
                    $is_member &&
                    $member_id !== '' &&
                    ((string)$list[$i]['wr_2'] === '1' || (string)$list[$i]['wr_3'] === '1')
                ) {
                    $bookmark = sql_fetch("
                        SELECT wr_id
                        FROM {$g5['write_prefix']}messages
                        WHERE wr_7 = '{$original_wr_id}'
                        AND wr_5 = '".sql_escape_string($member_id)."'
                        AND wr_2 = '0'
                        LIMIT 1
                    ");

                    $is_bookmarked = !empty($bookmark['wr_id']);
                }
                ?>

            <?php if (!empty($member['mb_id']) && ($list[$i]['wr_2'] == '1' || $list[$i]['wr_3'] == '1')) { ?>

                <button
                    type="button"
                    class="btn_bookmark <?php echo $is_bookmarked ? 'is_bookmarked' : ''; ?>"
                    data-wr-id="<?php echo (int)$list[$i]['wr_id']; ?>"
                    <?php echo $is_bookmarked ? 'disabled' : ''; ?>
                >
                    <img src="<?=G5_IMG_URL?>/ico_bookmark.webp" alt="북마크"/>
                </button>

            <?php } ?>

            <?php
            // 신고 / 차단 버튼
            // 노출 조건: 'mine' 또는 'all' 탭 + 로그인 회원 + 본인 글 아님 + admin 아님
            $writer_mb_id = isset($list[$i]['mb_id']) ? trim($list[$i]['mb_id']) : '';
            $can_report_block = (
                $show_report_block_tab &&
                $is_member &&
                !$is_admin &&
                !empty($member['mb_id']) &&
                $writer_mb_id !== '' &&
                $writer_mb_id !== $member['mb_id']
            );
            if ($can_report_block) {
            ?>
            <div class="msg_report_block" data-wr-id="<?php echo (int)$list[$i]['wr_id']; ?>">
               <button type="button" class="open_opt">...</button>
               <ul>
                    <li>
                        <button type="button" class="btn_report" data-wr-id="<?php echo (int)$list[$i]['wr_id']; ?>">게시글 신고</button>
                    </li>
                    <li>
                        <button type="button" class="btn_block" data-wr-id="<?php echo (int)$list[$i]['wr_id']; ?>">작성자 차단</button>
                    </li>
               </ul>
            </div>
            <?php } ?>

            <?php if ($is_checkbox) { ?>
            <div class="td_chk chk_box">
				<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
            	<label for="chk_wr_id_<?php echo $i ?>">
            		<span></span>
            		<b class="sound_only"><?php echo $list[$i]['subject'] ?></b>
            	</label>
            </div>
            <?php } ?>
            <?if($is_admin){?>
            <div class="td_num2">
            <?php
                echo $list[$i]['num'];
            ?>
            </div>
            <?}?>

            <div class="bo_tit">
                <?if($is_admin){?>
                <a href="<?php echo $list[$i]['href'] ?>">
                <?}?>
                    <?php
                    // 제목 날짜 우선순위:
                    // 1. wr_6 있으면 그대로
                    // 2. wr_subject에 월일 4자리(0101~1231) 있으면 올해연도.MM.DD
                    // 3. 없으면 글 작성일(datetime2)
                    $bo_tit_date = '';
                    if (!empty($list[$i]['wr_6'])) {
                        $bo_tit_date = $list[$i]['wr_6'];
                    } elseif (
                        ($list[$i]['wr_2'] == '1' || $list[$i]['wr_3'] == '1') &&
                        preg_match('/^(\d{2})(\d{2})$/', $list[$i]['wr_subject'], $_dm)
                    ) {
                        $bo_tit_date = date('Y', G5_SERVER_TIME) . '.' . $_dm[1] . '.' . $_dm[2];
                    } else {
                        $bo_tit_date = $list[$i]['datetime2'];
                    }
                    echo $bo_tit_date;
                    ?>
                <?if($is_admin){?>
                </a>
                <?}?>
            </div>
            <div class="cont">
                <?if(strlen($list[$i]['wr_content']) < 400){?>
                    <p>
                        <?if($list[$i]['wr_content'] == '-'){?>
                        <?}else{?>
                            <?php echo $list[$i]['wr_content']; ?></p>
                        <?}?>
                    </p>
                <?}else{?>
                    <p class="short">
                        <?php echo $list[$i]['wr_content'] ?>
                    </p>
                    <button type="button" class="btn_more">더보기</button>
                <?}?>
            </div>
            <div class="send">
                <p class="from">from. 
                    <?if($list[$i]['wr_4']){?>
                        <?php echo $list[$i]['wr_4'] ?>
                    <?}elseif($list[$i]['name'] == '<span class="sv_member">최고관리자</span>'){?>
                        SAHAN
                    <?}else{?>
                        <?php echo $list[$i]['name'] ?>
                    <?}?>
                </p>
                
                <?if($list[$i]['wr_5']){?>
                    <div class="arr"></div>
                    <p class="to">to. 
                        <?=$list[$i]['wr_5']?>
                    </p>
                <?} ?>
            </div>
            

        </li>
        <?php } ?>
        <?php if (count($list) == 0) { echo '
            <div class="empty_list">
                <img src="'.G5_IMG_URL.'/ico_emptyMessage.webp">
                <p class="txt">수신된 메시지가 없습니다</p>
                <p class="desc">먼저 메시지를 보내보세요</p>

            </div>'; } ?>
        </ul>
    </div>
	<!-- 페이지 -->
	<?php echo $write_pages; ?>
	<!-- 페이지 -->
	<?/*
    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
        	<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
        </ul>	
        <?php } ?>
    </div>
    <?php } ?>   
    */?>
    </form>

    <!-- 게시판 검색 시작 { -->
    <div class="bo_sch_wrap">
        <fieldset class="bo_sch">
            <h3>검색</h3>
            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
                <?php echo get_board_sfl_select_options($sfl); ?>
            </select>
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <div class="sch_bar">
                <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder=" 검색어를 입력해주세요">
                <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
            </div>
            <button type="button" class="bo_sch_cls" title="닫기"><i class="fa fa-times" aria-hidden="true"></i><span class="sound_only">닫기</span></button>
            </form>
        </fieldset>
        <div class="bo_sch_bg"></div>
    </div>
    <script>
    $(function() {
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });
    });
    </script>

    <script>
    jQuery(function($){
        // 게시판 검색
        $(".btn_bo_sch").on("click", function() {
            $(".bo_sch_wrap").toggle();
        })
        $('.bo_sch_bg, .bo_sch_cls').click(function(){
            $('.bo_sch_wrap').hide();
        });
        function fmessage_search_submit(f)
        {
            var stx = f.stx.value.trim();

            if (stx.length < 2) {
                alert("검색어는 두글자 이상 입력하십시오.");
                f.stx.select();
                f.stx.focus();
                return false;
            }

            if (!/^[a-zA-Z0-9]+$/.test(stx)) {
                alert("검색어는 숫자 또는 영문과 숫자만 입력할 수 있습니다.");
                f.stx.select();
                f.stx.focus();
                return false;
            }

            f.stx.value = stx;

            return true;
        }
    });
    </script>
    <!-- } 게시판 검색 끝 --> 
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
        
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}

// 게시판 리스트 관리자 옵션
jQuery(function($){
    $(".btn_more_opt.is_list_btn").on("click", function(e) {
        e.stopPropagation();
        $(".more_opt.is_list_btn").toggle();
    });
    $(document).on("click", function (e) {
        if(!$(e.target).closest('.is_list_btn').length) {
            $(".more_opt.is_list_btn").hide();
        }
    });
});
</script>
<?php } ?>

<script>
     $(()=>{
        $('.msg_item .btn_more').click(function(){
            const box = $(this).closest('.cont');
            if(box.hasClass('open')){
                box.removeClass('open')
                box.find('.btn_more').text('더보기')
            }else{
                box.addClass('open')
                box.find('.btn_more').text('닫기')
            }
            
        })
         $('.btn_bookmark').on('click', function() {

            var $btn = $(this);
            var wr_id = $btn.data('wr-id');

            // 저장 여부 확인
            var confirmed = confirm(
                '내게 온 메시지로 저장하시겠습니까?\n(저장 후 삭제는 불가합니다)'
            );

            // 취소한 경우 저장 요청하지 않음
            if (!confirmed) {
                return;
            }


            $.ajax({
                url: '<?php echo G5_THEME_URL; ?>/act/bookmark_message.php',
                type: 'POST',
                dataType: 'json',

                data: {
                    wr_id: wr_id
                },

                success: function(data) {

                    console.log('북마크 응답:', data);

                    if (data.result === 'success') {

                        alert('내게 온 메시지에 저장되었습니다.');

                        $btn
                            .addClass('is_bookmarked')
                            .prop('disabled', true);

                    }

                    else if (data.result === 'duplicate') {

                        alert('이미 저장한 메시지입니다.');

                        $btn
                            .addClass('is_bookmarked')
                            .prop('disabled', true);

                    }

                    else if (data.result === 'login') {

                        alert('로그인이 필요합니다.');

                    }

                    else {

                        console.log(data);

                        alert('저장하지 못했습니다.');
                    }
                },

                error: function(xhr) {

                    console.log('북마크 AJAX 오류');
                    console.log(xhr.responseText);

                    alert('서버 오류가 발생했습니다.');

                }

            });

        });

        // ============================================
        // 신고/차단 옵션 토글
        // ============================================
        $('.msg_report_block .open_opt').on('click', function(e) {
            e.stopPropagation();
            var $box = $(this).closest('.msg_report_block');
            // 다른 열린 옵션은 닫기
            $('.msg_report_block').not($box).removeClass('on');
            $box.toggleClass('on');
        });

        // 옵션 ul 내부 클릭은 바깥 클릭으로 처리하지 않음
        $('.msg_report_block ul').on('click', function(e) {
            e.stopPropagation();
        });

        // 바깥(ul 이외) 클릭 시 열린 옵션 닫기
        $(document).on('click', function() {
            $('.msg_report_block').removeClass('on');
        });

        // ============================================
        // 메시지 신고
        // ============================================
        $('.btn_report').on('click', function() {
            var $btn = $(this);
            var wr_id = $btn.data('wr-id');

            // 옵션 닫기
            $btn.closest('.msg_report_block').removeClass('on');

            var reason = prompt('신고 사유를 입력해주세요.');

            // 취소(null) 시 중단
            if (reason === null) {
                return;
            }

            reason = reason.trim();
            if (reason === '') {
                alert('신고 사유를 입력해주세요.');
                return;
            }

            $.ajax({
                url: '<?php echo G5_THEME_URL; ?>/act/report_message.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    wr_id: wr_id,
                    reason: reason
                },
                success: function(data) {
                    if (data.result === 'success') {
                        alert(data.msg || '신고가 접수되었습니다.');
                    } else if (data.result === 'login') {
                        alert('로그인이 필요합니다.');
                    } else {
                        alert(data.msg || '신고하지 못했습니다.');
                    }
                },
                error: function(xhr) {
                    console.log('신고 AJAX 오류');
                    console.log(xhr.responseText);
                    alert('서버 오류가 발생했습니다.');
                }
            });
        });

        // ============================================
        // 발신인 차단
        // ============================================
        $('.btn_block').on('click', function() {
            var $btn = $(this);
            var wr_id = $btn.data('wr-id');

            // 옵션 닫기
            $btn.closest('.msg_report_block').removeClass('on');

            var confirmed = confirm('이 발신인을 차단하시겠습니까?\n차단하면 해당 발신인의 메시지가 목록에서 보이지 않습니다.');
            if (!confirmed) {
                return;
            }

            $.ajax({
                url: '<?php echo G5_THEME_URL; ?>/act/block_message.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    wr_id: wr_id
                },
                success: function(data) {
                    if (data.result === 'success') {
                        alert(data.msg || '차단했습니다.');
                        // 차단한 발신인의 현재 화면 메시지 전체 즉시 제거
                        var blockedId = data.block_mb_id || '';
                        if (blockedId) {
                            $('.msg_item[data-writer-mb-id="' + blockedId + '"]').fadeOut();
                        } else {
                            $btn.closest('.msg_item').fadeOut();
                        }
                    } else if (data.result === 'duplicate') {
                        alert(data.msg || '이미 차단한 사용자입니다.');
                        var blockedId2 = data.block_mb_id || '';
                        if (blockedId2) {
                            $('.msg_item[data-writer-mb-id="' + blockedId2 + '"]').fadeOut();
                        } else {
                            $btn.closest('.msg_item').fadeOut();
                        }
                    } else if (data.result === 'login') {
                        alert('로그인이 필요합니다.');
                    } else {
                        alert(data.msg || '차단하지 못했습니다.');
                    }
                },
                error: function(xhr) {
                    console.log('차단 AJAX 오류');
                    console.log(xhr.responseText);
                    alert('서버 오류가 발생했습니다.');
                }
            });
        });

    })
</script>
<!-- } 게시판 목록 끝 -->
