<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<!-- 상단 시작 { -->
<div id="hd">    
    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>
    <h1 id="logo" class="logo <?if(defined('_INDEX_')) {?>main_logo<?}?>">
        <div class="container">
            <img src="<?php echo G5_IMG_URL?>/logo.svg" alt="SAHAN">
        </div>
    </h1>
    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    ?>
    <button class="btn_search btn_search_open">
        <span class="ico_search"></span>
    </button>
    <div class="hd_search">
        <fieldset id="hd_sch">
            <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
            <label for="sch_stx" class="sound_only">검색어 필수</label>
            <input type="text" name="stx" id="sch_stx" maxlength="20" placeholder="발신인 코드를 검색해보세요">
            <button type="submit" id="sch_submit" class="btn_search" value="검색"></button>
            </form>

            <script>
                $(()=>{
                    // 검색 열기
                    $('.btn_search_open').on('click', function(e) {
                        e.stopPropagation();
                        $('.hd_search').show();
                    });

                    // 검색 영역 내부 클릭 시 유지
                    $('.hd_search').on('click', function(e) {
                        e.stopPropagation();
                    });

                    // 바깥 클릭 시 닫기
                    $(document).on('click', function() {
                        $('.hd_search').hide();
                    });
                })
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
    <?}?>
</div>
<!-- } 상단 끝 -->


<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <div id="container_wr">
   
    <div id="<?php if (!defined("_INDEX_")) { ?>container<?}?>">
        <?php if (!defined("_INDEX_")) { ?><?php }