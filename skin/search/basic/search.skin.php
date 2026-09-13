<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css">', 0);
?>

<!-- 전체검색 시작 { -->
 <div class="hd_search board_search">
     <fieldset id="hd_sch">
     <form name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
     <input type="hidden" name="srows" value="<?php echo $srows ?>">
         <legend>상세검색</legend>
         <?php echo $group_select ?>
         <script>document.getElementById("gr_id").value = "<?php echo $gr_id ?>";</script>
     
         <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
             <input type="text" name="stx" value="<?php echo $text_stx ?>" id="stx" required  placeholder="발신인 코드를 검색해보세요">
             <button type="submit" id="sch_submit" class="btn_search" value="검색">
                <span class="ico_search"></span>
            </button>     
         <script>
         function fsearch_submit(f)
         {
             var stx = f.stx.value.trim();
             if (stx.length < 2) {
                 alert("검색어는 두글자 이상 입력하십시오.");
                 f.stx.select();
                 f.stx.focus();
                 return false;
             }
     
             // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
             var cnt = 0;
             for (var i = 0; i < stx.length; i++) {
                 if (stx.charAt(i) == ' ')
                     cnt++;
             }
     
             if (cnt > 1) {
                 alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                 f.stx.select();
                 f.stx.focus();
                 return false;
             }
             f.stx.value = stx;
     
             f.action = "";
             return true;
         }
         </script>
     </form>
     </fieldset>
 </div>

<div id="sch_result">
    <?php
    if ($stx) {
        if ($board_count) {
    ?>
    <?php
        }
    }
    ?>

    <?php
    if ($stx) {
        if ($board_count) {
     ?>
    <?php
        } else {
     ?>
    <div class="empty_list">
        <img src="<?=G5_IMG_URL?>/ico_emptyMessage.webp">
        <p class="txt">검색된 메세지가 없습니다</p>
        <p class="desc">먼저 메세지를 보내보세요</p>
    </div>
    <?php } }  ?>

    <hr>

    <?php if ($stx && $board_count) { ?><section class="sch_res_list"><?php }  ?>
    <?php
    $k=0;
    for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
     ?>
		<div class="search_board_result">
        
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

                $original_wr_id = (int)$list[$idx][$i]['wr_id'];

                if (
                    $is_member &&
                    $member_id !== '' &&
                    (string)$list[$idx][$i]['wr_4'] === '1'
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

            <?php if ($is_checkbox) { ?>
            <div class="td_chk chk_box">
				<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$idx][$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
            	<label for="chk_wr_id_<?php echo $i ?>">
            		<span></span>
            		<b class="sound_only"><?php echo $list[$idx][$i]['subject'] ?></b>
            	</label>
            </div>
            <?php } ?>
            <?if($is_admin){?>
            <div class="td_num2">
            <?php
                echo $list[$idx][$i]['num'];
            ?>
            </div>
            <?}?>

            <div class="bo_tit">
                
                <?php if ($list[$idx][$i]['wr_5']) { ?>
                    <?php echo $list[$idx][$i]['wr_5']; ?>
                <?php } else { ?>
                     <?php echo date('Y.m.d', strtotime($list[$idx][$i]['wr_datetime'])); ?>
                <?php } ?>
                
                <?php if (!empty($member['mb_id']) && $list[$idx][$i]['wr_4'] == '1') { ?>

                    <button
                        type="button"
                        class="btn_bookmark <?php echo $is_bookmarked ? 'is_bookmarked' : ''; ?>"
                        data-wr-id="<?php echo (int)$list[$idx][$i]['wr_id']; ?>"
                        <?php echo $is_bookmarked ? 'disabled' : ''; ?>
                    >
                        <img src="<?=G5_IMG_URL?>/ico_bookmark.webp" alt="북마크"/>
                    </button>

                <?php } ?>
            </div>
            <div class="cont"><?php echo $list[$idx][$i]['wr_content'] ?></d>
            <div class="send">
                <p class="from">from. 
                    <?if($list[$idx][$i]['wr_4'] == 1){?>
                        <?php echo $list[$idx][$i]['wr_2']?>
                    <?}else{?>
                        <?php echo $list[$idx][$i]['name'] ?>
                    <?}?>
                </p>
                <div class="arr"></div>
                <p class="to">to. 
                    <?if($list[$idx][$i]['wr_4'] == 1){?>
                        <?php echo $member['mb_id']?>
                    <?}else{?>
                        <?php echo $list[$idx][$i]['wr_2'] ?>
                    <?}?>
                </p>
            </div>
            

        </li>
        <?php } ?>
        </ul>
		</div>
    <?php }		//end for?>
    <?php if ($stx && $board_count) {  ?></section><?php }  ?>

    <?php echo $write_pages ?>

</div>


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
<!-- } 전체검색 끝 -->