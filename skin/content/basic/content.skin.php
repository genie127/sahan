<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);
?>
<?if ($co_id == 'sahan'){?>

    <?php
        include_once(__DIR__ . '/sahan.php');
    ?>

<?}else if($co_id == 'settings'){?>
    
    <?php
        include_once(__DIR__ . '/settings.php');
    ?>

<?}else {?>
    404
<?}?>