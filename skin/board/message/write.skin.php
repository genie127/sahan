<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<section id="bo_w">
    <div class="sub_header">
        <div class="container">
            <button onclick="history.back()" class="arr_prev"></button>
            <h3>
                <?if($bo_table =='messages'){?>
                    메세지 쓰기
                <?}else{?>
                    게시글 등록
                <?}?>
            </h3>
        </div>
    </div>

    <h4 class="sub_tit">Write</h4>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) { 
        $option = '';
        if ($is_notice) {
            $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="notice" name="notice"  class="selec_chk" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice"><span></span>공지</label></li>';
        }
        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html"><span></span>html</label></li>';
            }
        }
        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="secret" name="secret"  class="selec_chk" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret"><span></span>비밀글</label></li>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }
        if ($is_mail) {
            $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="mail" name="mail"  class="selec_chk" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail"><span></span>답변메일받기</label></li>';
        }
    }
    echo $option_hidden;
    ?>

    <?php if ($is_category) { ?>
    <div class="bo_w_select write_div">
        <label for="ca_name" class="sound_only">분류<strong>필수</strong></label>
        <select name="ca_name" id="ca_name" required>
            <option value="">분류를 선택하세요</option>
            <?php echo $category_option ?>
        </select>
    </div>
    <?php } ?>

    <div class="bo_w_info write_div">
	    <?php if ($is_name) { ?>
	        <label for="wr_name" class="sound_only">이름<strong>필수</strong></label>
	        <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input half_input required" placeholder="이름">
	    <?php } ?>
	
	    <?php if ($is_password) { ?>
	        <label for="wr_password" class="sound_only">비밀번호<strong>필수</strong></label>
	        <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input half_input <?php echo $password_required ?>" placeholder="비밀번호">
	    <?php } ?>
	
	    <?php if ($is_email) { ?>
			<label for="wr_email" class="sound_only">이메일</label>
			<input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input half_input email " placeholder="이메일">
	    <?php } ?>
	    
	
	    <?php if ($is_homepage) { ?>
	        <label for="wr_homepage" class="sound_only">홈페이지</label>
	        <input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="frm_input half_input" size="50" placeholder="홈페이지">
	    <?php } ?>
	</div>
	
    <?/*
    <?php if ($option) { ?>
    <div class="write_div">
        <span class="sound_only">옵션</span>
        <ul class="bo_v_option">
        <?php echo $option ?>
        </ul>
    </div>
    <?php } ?>
    */?>
    

    <?if($is_admin){?>
    <div class="write_div checkbox_wrap sentence">
        <input type="checkbox" id="wr_2" name="wr_2" value="1" <?php echo $wr_2 == '1' ? 'checked' : ''; ?>>
        <label for="wr_2"><span class="checkbox"></span><p>날짜 명대사 (오늘 월/일 4자리 제목, latest 노출)</p></label>
    </div>
    <div class="write_div checkbox_wrap sentence">
        <input type="checkbox" id="wr_3" name="wr_3" value="1" <?php echo $wr_3 == '1' ? 'checked' : ''; ?>>
        <label for="wr_3"><span class="checkbox"></span><p>이벤트 명대사 (발신자 검색으로만 노출)</p></label>
    </div>
    <?}?>

    <div class="select_open write_div checkbox_wrap">
        <input type="checkbox" id="wr_1" name="wr_1" value="1" <?php echo $wr_1 == '1' ? 'checked' : ''; ?>>
        <label for="wr_1"><span class="checkbox"></span><p>전체공개</p></label>
        <div class="about_this">
            <span class="ico_info"><img src="<?=G5_IMG_URL?>/ico_info.png" alt=""></span>
            <p>전체공개 설정 시 전체 목록 또는 검색 목록에서 노출되며 <br>전체공개 미 설정 시 수신인에게만 노출됩니다.</p></div>
    </div>

    <?if($is_admin){?>
    <div class="wrap_send write_div">
        <div class="send_info">
            <label for="wr_4">발신인 코드</label>
            <input type="text" id="wr_4" name="wr_4" placeholder="발신자로 표기될 코드를 써주세요." value="<?php echo $wr_4?>">
        </div>
        <span class="noti">검색할 때 쓰이는 코드입니다.<br>알파벳을 섞어야 해당 코드로의 회원가입을 막을 수 있습니다.</span>
    </div>
    <?}?>

    <div class="wrap_send write_div">
        <div class="send_info">
            <label for="wr_5">수신인</label>
            <input type="text" id="wr_5" name="wr_5" placeholder="받는 사람의 코드를 입력해주세요" required value="<?php echo $wr_5?>">
        </div>
        <div class="for_me">
        <button type="button" onclick="checkForMe(this)" class="checkbox_wrap"><span class="checkbox"></span><p>내게 쓰기</p></button>
        </div>
    </div>
    
    <?if($is_admin){?>
    <div class="wrap_send write_div">
        <div class="date">
            <label for="wr_6">임의 날짜</label>
            <input type="text" id="wr_6" name="wr_6" inputmode="numeric" placeholder="0000.00.00 (미기입시 작성날짜 노출)" value="<?php echo $wr_6?>" style="width:85%">
        </div>
    </div>
    <?}?>

    <div class="wrap_send write_div is-hidden">
        <input type="text" id="wr_7" name="wr_7" value="<?php echo $wr_id ?>" hidden>
    </div>

    <div class="bo_w_tit write_div">
        <label for="wr_subject" class="sound_only">제목<strong>필수</strong></label>
        
        <div id="autosave_wrapper" class="write_div">
            <input type="text" name="wr_subject" value="<?if($subject){?><?php echo $subject?><?}?>" id="wr_subject" required class="frm_input full_input required" size="50" maxlength="255" placeholder="오늘 날짜 4자리 (예: 0921)" hidden>
            <?php if ($is_member) { // 임시 저장된 글 기능 ?>
            <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
            <?php if($editor_content_js) echo $editor_content_js; ?>
            <?/*<button type="button" id="btn_autosave" class="btn_frmline">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>*/?>
            <div id="autosave_pop">
                <strong>임시 저장된 글 목록</strong>
                <ul></ul>
                <div><button type="button" class="autosave_close">닫기</button></div>
            </div>
            <?php } ?>
        </div>        
    </div>

    <div class="write_div">
        <label for="wr_content" class="sound_only">내용<strong>필수</strong></label>
        <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
            <?php if($write_min || $write_max) { ?>
            <!-- 최소/최대 글자 수 사용 시 -->
            <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
            <?php } ?>
            <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
            <?php if($write_min || $write_max) { ?>
            <!-- 최소/최대 글자 수 사용 시 -->
            <div id="char_count_wrap"><span id="char_count"></span>글자</div>
            <?php } ?>
        </div>
    </div>

    <div class="write_div checkbox_wrap confirm_privacy">
        <input type="checkbox" id="wr_8" name="wr_8" value="1" <?php echo $wr_8 == '1' ? 'checked' : ''; ?> required>
        <label for="wr_8"><span class="checkbox"></span><p>이 메시지가 주파수 변환 과정에서 <br>타인에게 공개될 수 있음을 확인했습니다.</p></label>
    </div>

    <?/*
    <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
    <div class="bo_w_link write_div">
        <label for="wr_link<?php echo $i ?>"><i class="fa fa-link" aria-hidden="true"></i><span class="sound_only"> 링크  #<?php echo $i ?></span></label>
        <input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){ echo $write['wr_link'.$i]; } ?>" id="wr_link<?php echo $i ?>" class="frm_input full_input" size="50">
    </div>
    <?php } ?>
*/?>
    <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
    <div class="bo_w_flie write_div">
        <div class="file_wr write_div">
            <label for="bf_file_<?php echo $i+1 ?>" class="lb_icon"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #<?php echo $i+1 ?></span></label>
            <input type="file" name="bf_file[]" id="bf_file_<?php echo $i+1 ?>" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
        </div>
        <?php if ($is_file_content) { ?>
        <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="full_input frm_input" size="50" placeholder="파일 설명을 입력해주세요.">
        <?php } ?>

        <?php if($w == 'u' && $file[$i]['file']) { ?>
        <span class="file_del">
            <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
        </span>
        <?php } ?>
        
    </div>
    <?php } ?>


    <?php if ($is_use_captcha) { //자동등록방지  ?>
    <div class="write_div">
        <?php echo $captcha_html ?>
    </div>
    <?php } ?>

    <div class="btn_confirm write_div">
        <!-- <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn_cancel btn">취소</a> -->
        <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn">전송하기</button>
    </div>
    </form>

    <script>
    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?php echo $write_min; ?>); // 최소
    var char_max = parseInt(<?php echo $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");

    $(function() {
        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });
    <?php } ?>
    function checkForMe(e){
        $(e).toggleClass('on')
        if($(e).hasClass('on')){
            $("#wr_5").val('<?=$member['mb_id']?>')
            $("#wr_5").attr('readonly', true)
        }else{
            $("#wr_5").val('')
            $("#wr_5").attr('readonly', false)
        }
    }
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    $(() => {

    // wr_2(날짜명대사), wr_3(이벤트명대사) 상태에 따라 UI 갱신
    function updateSentenceMode() {
        const isDateSentence  = $('#wr_2').is(':checked');
        const isEventSentence = $('#wr_3').is(':checked');
        const isSentence = isDateSentence || isEventSentence;

        if (!isSentence) {
            // 일반 메세지
            $(".select_open").show();
            $(".for_me").show();

            // wr_5 = 수신인 → 숫자 입력
            $("#wr_5").attr('placeholder', '받는 사람의 코드를 입력해주세요');
            $("label[for='wr_5']").text('수신인');
            $("#wr_5").attr('inputmode', 'numeric');
            $("#wr_5").prop('required', true);
            $("#wr_5").prop('disabled', false);

            // subject 숨기고 값 자동 처리 (서버에서 wr_5로 덮어씀)
            $('#wr_subject').attr('hidden', true);
            $('#wr_subject').prop('required', false);
            $('#wr_subject').val('');

            $(".confirm_privacy").show();
            $("#wr_8").prop('checked', false);

        } else {
            // 명대사 모드 (날짜 또는 이벤트)
            $("#wr_5").prop('required', false);
            $("#wr_5").prop('disabled', false);

            $("#wr_8").prop('checked', true);
            $(".confirm_privacy").hide();
            $(".select_open").hide();
            $(".for_me").hide();

            if (isDateSentence) {
                // 날짜명대사: subject 표시, 빈값으로 직접 입력 (오늘 월/일 4자리)
                $('#wr_subject').attr('hidden', false);
                $('#wr_subject').prop('required', true);
                // 수정(w=u)일 때는 기존 값 유지, 신규 작성 시 빈값
                <?php if ($w == 'u'): ?>
                $('#wr_subject').val('<?php echo $subject ?>');
                <?php else: ?>
                $('#wr_subject').val('');
                <?php endif; ?>
                $("#wr_5").attr('inputmode', '');
            } else {
                // 이벤트명대사: subject 숨김, 빈값 (서버에서 자동처리)
                $('#wr_subject').attr('hidden', true);
                $('#wr_subject').prop('required', false);
                $('#wr_subject').val('');
                $("#wr_5").attr('inputmode', '');
            }
        }

        // 날짜명대사/이벤트명대사 동시 체크 방지
        if (isDateSentence) $('#wr_3').prop('disabled', true);
        else $('#wr_3').prop('disabled', false);

        if (isEventSentence) $('#wr_2').prop('disabled', true);
        else $('#wr_2').prop('disabled', false);
    }

    // 체크 변경 시
    $('#wr_2, #wr_3').change(updateSentenceMode);

    // 페이지 로딩 시 현재 체크 상태 적용
    updateSentenceMode();


    // wr_5(수신인/발신인) 입력 제한
    $('#wr_5').on('input', function() {
        const isDateSentence  = $('#wr_2').prop('checked');
        const isEventSentence = $('#wr_3').prop('checked');
        const isSentence = isDateSentence || isEventSentence;

        if (isSentence) {
            // 명대사 → 영문 + 숫자
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        } else {
            // 일반 메시지 → 숫자
            this.value = this.value.replace(/[^0-9]/g, '');
        }
    });

    $('.about_this').click(function() {
        $(this).find('p').toggle();
    });

});
    </script>
</section>
<!-- } 게시물 작성/수정 끝 -->