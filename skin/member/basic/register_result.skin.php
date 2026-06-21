<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원가입결과 시작 { -->
<div id="reg_result" class="register">
    <p class="reg_result_p">
        <strong><?php echo get_text($mb['mb_name']); ?>님,</strong>
        <br>회원가입이 완료되었습니다.
    </p>

    <?php if (is_use_email_certify()) {  ?>
    <p class="result_txt">
        회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.<br>
        발송된 인증메일을 확인하신 후 인증처리를 하시면 사이트를 원활하게 이용하실 수 있습니다.
    </p>
    <div id="result_email">
        <span>아이디</span>
        <strong><?php echo $mb['mb_id'] ?></strong><br>
        <span>이메일 주소</span>
        <strong><?php echo $mb['mb_email'] ?></strong>
    </div>
    <p>
        이메일 주소를 잘못 입력하셨다면, 사이트 관리자에게 문의해주시기 바랍니다.
    </p>
    <?php }  ?>

</div>
<!-- } 회원가입결과 끝 -->
<div class="btn_confirm_reg">
	<a href="<?php echo G5_URL ?>/" class="reg_btn_submit">메인으로</a>
</div>