
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

        // 이벤트명대사(wr_3=1)는 latest에서 노출 안 함
        if ($list[$i]['wr_3'] == '1') continue;

        // 날짜 표시 처리
        // 1. wr_6(표기날짜)이 있으면 그것을 사용
        // 2. 날짜명대사(wr_2=1)이고 subject가 MMDD 4자리면 올해연도.MM.DD
        // 3. 일반 게시글이면 wr_datetime의 날짜를 Y.m.d 형식으로 표시
        $title = $list[$i]['subject'];

        if (!empty($list[$i]['wr_6'])) {
            $title = $list[$i]['wr_6'];
        } elseif (
            $list[$i]['wr_2'] == '1' &&
            preg_match('/^(\d{2})(\d{2})$/', $list[$i]['wr_subject'], $_dm)
        ) {
            $title = date('Y', G5_SERVER_TIME) . '.' . $_dm[1] . '.' . $_dm[2];
        } elseif (!empty($list[$i]['wr_datetime'])) {
            $title = date('Y.m.d', strtotime($list[$i]['wr_datetime']));
        }


        // ====================================================
        // 현재 게시글의 북마크 여부
        // 명대사(wr_2=1 또는 wr_3=1)와 일반 게시글 모두 북마크 가능
        // ====================================================
        $is_bookmarked = false;

        if (!empty($member['mb_id'])) {

            $sql = " select wr_id
                     from {$g5['write_prefix']}messages
                     where wr_7 = '".(int)$list[$i]['wr_id']."'
                     and wr_5 = '".sql_escape_string($member['mb_id'])."'
                     and wr_2 = '0'
                     ";

            $bookmark = sql_fetch($sql);

            if (!empty($bookmark['wr_id'])) {
                $is_bookmarked = true;
            }
        }
    ?>

        <li class="basic_li swiper-slide">

            <div class="lt_top">
                <p class="lt_date">
                    <?php echo $title; ?>
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
                <p class="lt_cont">
                    <?if($list[$i]['wr_content'] == '-'){?>
                    <?}else{?>
                        <?php echo $list[$i]['wr_content']; ?>
                    <?}?>
                </p>
            </div>


            <div class="lt_bot">
                 <div class="send">
                    <p class="from">from. 
                        <?if($list[$i]['wr_4']){?>
                            <?php echo $list[$i]['wr_4']?>
                        <?}else{?>
                            <?if($list[$i]['name'] == '<span class="sv_member">최고관리자</span>'){?>
                                SAHAN
                            <?}else{?>
                                    <?php echo $list[$i]['name'] ?>
                            <?}?>
                        <?}?>
                    </p>
                </div>
            </div>

        </li>

    <?php } ?>


    <?php if ($list_count == 0) { ?>

        <li class="empty_li">
            게시물이 없습니다.
        </li>

    <?php } ?>

    </ul>
    <?if($list_count > 1){?>
        <div class="btn_wrap">
            <div class="btn prev" title="이전"></div>
            <div class="btn next" title="다음"></div>
        </div>
    <?}?>
</div>


<script src="<?=G5_URL?>/js/swiper/swiper.min.js"></script>
<script>
$(function() {

    if($('.swiper-slide').length > 1){
        const sl_bookmark = new Swiper('.sl_list',{
            slidesPerView:1,
            effect:'fade',
            fadeEffect:{
                crossFade:true
            },
            spaceBetween:10,
            autoHeight:false,
            navigation:{
                nextEl:'.btn_wrap .next',
                prevEl:'.btn_wrap .prev'
            }
        })
    }

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

});
</script>