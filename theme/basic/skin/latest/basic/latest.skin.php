<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="list">
    <ul>
    <?php for ($i=0; $i<$list_count; $i++) {  
        $title = substr($list[$i]['subject'],0,2).'.'.substr($list[$i]['subject'],2,4);
        
        ?>
        <li class="basic_li">
            <?php
            if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";

            echo '<p class="lt_date">'.$title.'</p>';
            ?>
            <div class="lt_cont">
            	<p class=""><?php echo $list[$i]['wr_content'] ?></p>              
            </div>
        </li>
    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
</div>
