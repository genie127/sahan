
<?php
global $member, $is_member;


add_stylesheet(
    '<link rel="stylesheet" href="'.G5_URL.'/js/swiper/swiper.min.css">',
    0
);

add_stylesheet(
    '<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">',
    0
);
if (!defined('_GNUBOARD_')) exit;


$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="list swiper sl_list">
    <ul class="swiper-wrapper">

    <?php for ($i = 0; $i < $list_count; $i++) {

        $title = substr($list[$i]['subject'], 0, 2)
               . '.'
               . substr($list[$i]['subject'], 2, 4);


        // ====================================================
        // 현재 게시글의 북마크 여부
        // ====================================================
        $is_bookmarked = false;

        if (!empty($member['mb_id'])) {

            $sql = " select wr_id
                     from {$g5['write_prefix']}messages
                     where wr_6 = '".(int)$list[$i]['wr_id']."'
                     and wr_2 = '".sql_escape_string($member['mb_id'])."'
                     and wr_5 = '".sql_escape_string($list[$i]['wr_5'])."'
                     and wr_4 = '0'
                     ";

            $bookmark = sql_fetch($sql);

            if (!empty($bookmark['wr_id'])) {
                $is_bookmarked = true;
            }
        }
    ?>

        <li class="basic_li swiper-slide">

            <p class="lt_date">
                <?if($list[$i]['wr_5']){?>
                    <?php echo $list[$i]['wr_5']; ?>
                <?}else{?>
                    <?php echo $title; ?>
                <?}?>
                <?php if (!empty($member['mb_id'])) { ?>

                    <button
                        type="button"
                        class="btn_bookmark <?php echo $is_bookmarked ? 'is_bookmarked' : ''; ?>"
                        data-wr-id="<?php echo (int)$list[$i]['wr_id']; ?>"
                        <?php echo $is_bookmarked ? 'disabled' : ''; ?>
                    >
                        <img src="<?=G5_IMG_URL?>/ico_bookmark.webp" alt="북마크"/>
                    </button>

                <?php } ?>
            </p>


            <div class="lt_cont">
                <p><?php echo $list[$i]['wr_content']; ?></p>
            </div>

        </li>

    <?php } ?>


    <?php if ($list_count == 0) { ?>

        <li class="empty_li">
            게시물이 없습니다.
        </li>

    <?php } ?>

    </ul>
</div>


<script src="<?=G5_URL?>/js/swiper/swiper.min.js"></script>
<script>
$(function() {

    if($('.swiper-slide').length > 1){
        const sl_bookmark = new Swiper('.sl_list',{
            slidesPerView:1,
        })
    }

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
                        .addClass('is_bookmarked')
                        .prop('disabled', true);

                }

                else if (data.result === 'duplicate') {

                    alert('이미 저장한 메세지입니다.');

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

});
</script>