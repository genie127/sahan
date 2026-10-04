<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<div class="main_wrap">
    <div class="bg" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/bg.png')"></div>
    <div class="bg_comet delay2" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/comet.png')"></div>
    <div class="bg_comet delay3 comet2" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/comet02.png')"></div>
    <div class="star obj_cover">
        <div class="star_img" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/star01.png')"></div>
        <div class="star_img delay3" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/star02.png')"></div>
        <div class="star_img delay2" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/star03.png')"></div>
        <div class="star_img delay1" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/star04.png')"></div>
        <div class="star_img delay4" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/star05.png')"></div>
    </div>
    <div class="dot_wrap obj_cover">
        <div class="dot03">
            <div class="dot_img star_delay10" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot301.png')"></div>
            <div class="dot_img star_delay11" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot302.png')"></div>
            <div class="dot_img star_delay12" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot303.png')"></div>
        </div>
        <div class="dot05">
            <div class="dot_img star_delay3" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot501.png')"></div>
            <div class="dot_img star_delay4" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot502.png')"></div>
            <div class="dot_img star_delay5" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot503.png')"></div>
            <div class="dot_img star_delay6" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot504.png')"></div>
            <div class="dot_img star_delay7" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot505.png')"></div>
        </div>
        <div class="dot06">
            <div class="dot_img star_delay2" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot601.png')"></div>
            <div class="dot_img star_delay3" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot602.png')"></div>
            <div class="dot_img star_delay4" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot603.png')"></div>
            <div class="dot_img star_delay5" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot604.png')"></div>
            <div class="dot_img star_delay6" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot605.png')"></div>
            <div class="dot_img star_delay7" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot606.png')"></div>
        </div>
        <div class="dot07">
            <div class="dot_img" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot701.png')"></div>
            <div class="dot_img star_delay1" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot702.png')"></div>
            <div class="dot_img star_delay2" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot703.png')"></div>
            <div class="dot_img star_delay3" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot704.png')"></div>
            <div class="dot_img star_delay4" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot705.png')"></div>
            <div class="dot_img star_delay5" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot706.png')"></div>
            <div class="dot_img star_delay6" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot707.png')"></div>
        </div>
        <div class="dot010">
            <div class="dot_img star_delay2" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1001.png')"></div>
            <div class="dot_img star_delay3" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1002.png')"></div>
            <div class="dot_img star_delay4" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1003.png')"></div>
            <div class="dot_img star_delay5" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1004.png')"></div>
            <div class="dot_img star_delay6" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1005.png')"></div>
            <div class="dot_img star_delay7" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1006.png')"></div>
            <div class="dot_img star_delay8" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1007.png')"></div>
            <div class="dot_img star_delay9" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1008.png')"></div>
            <div class="dot_img star_delay10" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1009.png')"></div>
            <div class="dot_img star_delay11" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1010.png')"></div>
        </div>
        <div class="dot014">
            <div class="dot_img" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1401.png')"></div>
            <div class="dot_img star_delay1" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1402.png')"></div>
            <div class="dot_img star_delay2" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1403.png')"></div>
            <div class="dot_img star_delay3" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1404.png')"></div>
            <div class="dot_img star_delay4" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1405.png')"></div>
            <div class="dot_img star_delay5" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1406.png')"></div>
            <div class="dot_img star_delay6" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1407.png')"></div>
            <div class="dot_img star_delay7" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1408.png')"></div>
            <div class="dot_img star_delay8" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1409.png')"></div>
            <div class="dot_img star_delay9" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1410.png')"></div>
            <div class="dot_img star_delay10" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1411.png')"></div>
            <div class="dot_img star_delay11" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1412.png')"></div>
            <div class="dot_img star_delay12" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1413.png')"></div>
            <div class="dot_img star_delay13" style="background-image:url('<?php echo G5_IMG_URL?>/sahan/dot1414.png')"></div>
        </div>
    </div>
    <?php
       $today_mmdd = date('md', G5_SERVER_TIME);

        $sql = " select count(*) as cnt
                from {$g5['write_prefix']}messages
                where wr_is_comment = 0
                and wr_2 = '1'
                and wr_subject = '{$today_mmdd}' ";

        $row = sql_fetch($sql);

        if ($row['cnt'] > 0) {
    ?>
        <div class="list_sentence">
            <?php
            // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
            // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
            // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
            echo latest('theme/basic', 'messages', 50, 200);		// 최소설치시 자동생성되는 자유게시판
            ?>
        </div>
        <?php
        }
    ?>

    </div>
</div>

<script>
(function(){
    // 배경 이미지 로드 완료 후 페이드인 (로딩 전 검은 화면 노출 방지)
    var bgEl = document.querySelector('.main_wrap .bg');
    if (bgEl) {
        var bgStyle = bgEl.style.backgroundImage || window.getComputedStyle(bgEl).backgroundImage;
        var match = bgStyle.match(/url\(["']?([^"')]+)["']?\)/);
        if (match && match[1]) {
            bgEl.style.opacity = '0';
            bgEl.style.transition = 'opacity 0.3s ease';
            var img = new Image();
            img.onload = function() { bgEl.style.opacity = '1'; };
            img.src = match[1];
            if (img.complete) bgEl.style.opacity = '1';
        }
    }
})();
</script>

<?php
include_once('./tail.php');