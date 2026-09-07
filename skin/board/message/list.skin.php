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
?>
<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">
    <h2 class="subtit">
        Message
    </h2>
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
                <a href="/bbs/board.php?bo_table=messages&type=mine">내게 온 메세지</a>
            </li>
            <?}?>

            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'all'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=all">전체공개</a>
            </li>

            <?if($is_board_admin){?>
            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'adm_messages'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=adm_messages">관리자용 전체메세지</a>
            </li>

            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'adm_date'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=adm_date">명대사관리(날짜)</a>
            </li>

            <li class="<?if(isset($_GET['type']) && $_GET['type'] == 'adm_special'){?>on<?}?>">
                <a href="/bbs/board.php?bo_table=messages&type=adm_special">명대사관리(이벤트)</a>
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
    <div id="bo_btn_top">
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
        	<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
            <?php if ($write_href) { ?><li class="btn_write btn_board">
                <a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기">
                    <img src="<?=G5_IMG_URL?>/ico_write.webp" alt="">
            </a></li><?php } ?>
        	<?php if ($is_admin == 'super' || $is_auth) {  ?>
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
            ?>
           <li class="<?php echo $lt_class ?> msg_item">

           <?php
                $is_bookmarked = false;

                $member_id = isset($member['mb_id'])
                    ? trim($member['mb_id'])
                    : '';

                $original_wr_id = (int)$list[$i]['wr_id'];

                if (
                    $is_member &&
                    $member_id !== '' &&
                    (string)$list[$i]['wr_4'] === '1'
                ) {
                    $bookmark = sql_fetch("
                        SELECT wr_id
                        FROM {$g5['write_prefix']}messages
                        WHERE wr_6 = '{$original_wr_id}'
                        AND wr_2 = '".sql_escape_string($member_id)."'
                        AND wr_4 = '0'
                        LIMIT 1
                    ");

                    $is_bookmarked = !empty($bookmark['wr_id']);
                }
                ?>

            <?php if (!empty($member['mb_id']) && $list[$i]['wr_4'] == '1') { ?>

                <button
                    type="button"
                    class="btn_bookmark <?php echo $is_bookmarked ? 'is_bookmarked' : ''; ?>"
                    data-wr-id="<?php echo (int)$list[$i]['wr_id']; ?>"
                    <?php echo $is_bookmarked ? 'disabled' : ''; ?>
                >
                    <img src="<?=G5_IMG_URL?>/ico_bookmark.webp" alt="북마크"/>
                </button>

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
                    <?if($list[$i]['wr_5']){?>
                        <?php echo $list[$i]['wr_5']?>
                    <?}else{?>
                        <?php echo $list[$i]['datetime2'] ?>
                    <?}?>
                <?if($is_admin){?>
                </a>
                <?}?>
            </div>
            <div class="cont"><?php echo $list[$i]['wr_content'] ?></d>
            <div class="send">
                <p class="from">from. 
                    <?if($list[$i]['name'] == '<span class="sv_member">최고관리자</span>'){?>
                        <?if($list[$i]['wr_7']){?>
                            <?php echo $list[$i]['wr_7'] ?>
                        <?}else{?>
                            SAHAN
                        <?}?>
                    <?}else{?>
                        <?php echo $list[$i]['name'] ?>aa
                    <?}?>
                </p>
                <div class="arr"></div>
                <p class="to">to. <?php echo $list[$i]['wr_2'] ?></p>
            </div>
            

        </li>
        <?php } ?>
        <?php if (count($list) == 0) { echo '
            <div class="emtpy_list">
                <img src="'.G5_IMG_URL.'/ico_emptyMessage.webp">
                <p class="txt">수신된 메세지가 없습니다</p>
                <p class="desc">먼저 메세지를 보내보세요</p>

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
         $('.btn_bookmark').on('click', function() {

            var $btn = $(this);
            var wr_id = $btn.data('wr-id');

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

                        alert('내게 온 메세지에 저장되었습니다.');

                        $btn
                            .text('저장됨')
                            .addClass('is_bookmarked')
                            .prop('disabled', true);

                    }

                    else if (data.result === 'duplicate') {

                        alert('이미 저장한 메세지입니다.');

                        $btn
                            .text('저장됨')
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

    })
</script>
<!-- } 게시판 목록 끝 -->
