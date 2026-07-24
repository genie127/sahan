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
    <div class="bg"><img src="<?php echo G5_IMG_URL?>/sahan/bg.png" alt=""></div>
    <div class="bg_comet delay2"><img src="<?php echo G5_IMG_URL?>/sahan/comet.png" alt=""></div>
    <div class="bg_comet delay3 comet2"><img src="<?php echo G5_IMG_URL?>/sahan/comet02.png" alt=""></div>
    <div class="star">
        <img src="<?php echo G5_IMG_URL?>/sahan/star01.png" alt="" class="">
        <img src="<?php echo G5_IMG_URL?>/sahan/star02.png" alt="" class="delay3">
        <img src="<?php echo G5_IMG_URL?>/sahan/star03.png" alt="" class="delay2">
        <img src="<?php echo G5_IMG_URL?>/sahan/star04.png" alt="" class="delay1">
        <img src="<?php echo G5_IMG_URL?>/sahan/star05.png" alt="" class="delay4">
    </div>
    <div class="dot_wrap">
        <div class="dot03">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot301.png" alt="" class="star_delay10">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot302.png" alt="" class="star_delay11">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot303.png" alt="" class="star_delay12">
        </div>
        <div class="dot05">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot501.png" alt="" class="star_delay3">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot502.png" alt="" class="star_delay4">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot503.png" alt="" class="star_delay5">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot504.png" alt="" class="star_delay6">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot505.png" alt="" class="star_delay7">
        </div>
        <div class="dot06">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot601.png" alt="" class="star_delay2">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot602.png" alt="" class="star_delay3">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot603.png" alt="" class="star_delay4">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot604.png" alt="" class="star_delay5">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot605.png" alt="" class="star_delay6">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot606.png" alt="" class="star_delay7">
        </div>
        <div class="dot07">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot701.png" alt="">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot702.png" alt="" class="star_delay1">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot703.png" alt="" class="star_delay2">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot704.png" alt="" class="star_delay3">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot705.png" alt="" class="star_delay4">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot706.png" alt="" class="star_delay5">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot707.png" alt="" class="star_delay6">
        </div>
        <div class="dot010">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1001.png" alt="star_delay2">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1002.png" alt="" class="star_delay3">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1003.png" alt="" class="star_delay4">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1004.png" alt="" class="star_delay5">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1005.png" alt="" class="star_delay6">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1006.png" alt="" class="star_delay7">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1007.png" alt="" class="star_delay8">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1008.png" alt="" class="star_delay9">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1009.png" alt="" class="star_delay10">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1010.png" alt="" class="star_delay11">
        </div>
        <div class="dot014">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1401.png" alt="">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1402.png" alt="" class="star_delay1">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1403.png" alt="" class="star_delay2">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1404.png" alt="" class="star_delay3">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1405.png" alt="" class="star_delay4">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1406.png" alt="" class="star_delay5">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1407.png" alt="" class="star_delay6">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1408.png" alt="" class="star_delay7">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1409.png" alt="" class="star_delay8">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1410.png" alt="" class="star_delay9">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1411.png" alt="" class="star_delay10">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1412.png" alt="" class="star_delay11">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1413.png" alt="" class="star_delay12">
            <img src="<?php echo G5_IMG_URL?>/sahan/dot1414.png" alt="" class="star_delay13">
        </div>
    </div>
    <div class="container">
         <h1 id="logo" class="logo">
            <a href="<?php echo G5_URL?>">
                <img src="<?php echo G5_IMG_URL?>/logo.svg" alt="SAHAN">
            </a>
        </h1>

        <div class="latest_top_wr">
            <?php
            // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
            // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
            // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
            echo latest('theme/basic', 'sentence', 4, 23);		// 최소설치시 자동생성되는 자유게시판
            ?>
        </div>

    </div>
</div>


<?php
include_once('./tail.sub.php');