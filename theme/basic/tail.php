<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>
    </div>
</div>

</div>
<!-- } 콘텐츠 끝 -->

<hr>

<!-- 하단 시작 { -->
<nav id="gnb" class="<?if(!defined("_INDEX_")){?>sub<?}?> ">
    <div class="gnb_wrap">
        <ul id="gnb_1dul">
            <?php
            $menu_datas = get_menu_db(0, true);
            $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
            $i = 0;
            foreach( $menu_datas as $row ){
                if( empty($row) ) continue;

                $current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

                $menu_path = parse_url($row['me_link'], PHP_URL_PATH);
                $menu_query = parse_url($row['me_link'], PHP_URL_QUERY);

                $is_active = false;

                // HOME
                if ($menu_path === '/') {
                    $is_active = ($current_path === '/');
                }

                // 게시판
                else if ($menu_path === '/bbs/board.php') {
                    parse_str($menu_query ?? '', $menu_params);

                    $is_active =
                        isset($menu_params['bo_table']) &&
                        isset($_GET['bo_table']) &&
                        $menu_params['bo_table'] === $_GET['bo_table'];
                }

                // 콘텐츠 페이지
                else if ($menu_path === '/bbs/content.php') {
                    parse_str($menu_query ?? '', $menu_params);

                    $is_active =
                        isset($menu_params['co_id']) &&
                        isset($_GET['co_id']) &&
                        $menu_params['co_id'] === $_GET['co_id'];
                }

                // 그 외 일반 페이지
                else {
                    $is_active = ($current_path === $menu_path);
                }
            ?>
            <li class="gnb_1dli <?php echo $add_class; ?><?if($row['me_name'] == 'HOME'){?>home<?}?> <?php echo $is_active ? 'on' : ''; ?>" data-name="<?php echo $row['me_name'] ?>">
                <a 
                    <?if( $row['me_name'] == 'MESSAGES' && !$member['mb_id']){?>
                    href="/bbs/board.php?bo_table=messages&type=all" target="_<?php echo $row['me_target']; ?>" 
                    <?}else{?>
                    href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" 
                    <?}?>

                    class="gnb_1da">
                    <div class="img_wrap">
                        <?if(defined("_INDEX_")){?>
                            <img src="<?=G5_IMG_URL?>/nav<?php echo $row['me_name'] ?>.png" alt="<?php echo $row['me_name'] ?>" class="off_img">
                        <?}else{?>
                            <img src="<?=G5_IMG_URL?>/navSub<?php echo $row['me_name'] ?>.png" alt="<?php echo $row['me_name'] ?>" class="off_img">
                        <?}?>
                        <img src="<?=G5_IMG_URL?>/nav<?php echo $row['me_name'] ?>_on.png" alt="<?php echo $row['me_name'] ?>" class="on_img">
                    </div>
                    <p><?php echo $row['me_name'] ?></p>
                </a>
            </li>
            <?php
            $i++;
            }   //end foreach $row

            if ($i == 0) {  ?>
                <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
            <?php } ?>
        </ul>
    </div>
</nav>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");