
<?php

?>

<style>
    body.has_subhd{padding-top: 40px;}
    .subtit {margin-bottom: 45px; font-size:53.5px; line-height: 1.3; color:#5268A5;}
    .wrap_setli{margin-top: 40px;}
    .wrap_setli p{font-size:16px; line-height: 1.5; color:#9AA3B2}
    .wrap_setli p + ul{margin-top: 26.5px;}
    .wrap_setli ul{padding-bottom: 13.5px; border-bottom:1px solid #E3E7EF}
    .wrap_setli ul li{}
    .wrap_setli ul li + li{margin-top: 16px;}
    .wrap_setli ul li a,
    .wrap_setli ul li button{display: flex; align-items: center; justify-content: space-between; width: 100%; border:none; background: none;}
    .wrap_setli ul li p{font-size:21.5px; color:#2F3744; font-weight:500}
    .wrap_setli ul li p em{color:#5268A5; font-weight:600}
    .wrap_setli ul li a .arr{position: relative; width: 9.5px; height: 16px;}
    .wrap_setli ul li a .arr:after{content:''; position: absolute; width: 12px; height: 12px; border:1px solid #93A2CB; border-width:1px 1px 0 0; transform:rotate(45deg)}
    .wrap_setli ul li a .ver{font-size:18.5px; line-height: 1.5; }
    .wrap_setli ul li .toggle{position: relative; display: block; width: 66.5px; height: 32px; border-radius:16px; background: #E3E7EF; transition:.3s}
    .wrap_setli ul li .toggle .toggle_btn{position: absolute; left: 6.5px; top: 50%; transform:translateY(-50%); width: 25.5px; height: 25.5px; border-radius:50%; background: #FEFEFB; transition:.3s}
    .wrap_setli ul li .toggle.on{background: #5268A5;}
    .wrap_setli ul li .toggle.on .toggle_btn{position: absolute; left: calc(100% - 32px);}
    .wrap_setli ul li.right{text-align: right;}
    .wrap_setli ul li.right a{display: inline-block; color:#9AA3B2; font-size: 16px; font-weight:500; text-decoration: underline;}
    .wrap_setli.app ul{border-bottom:none}


@media(max-width:720px){
    body.has_subhd{padding-top: 35.5px;}
    .subtit {margin-bottom: 30px; font-size:40px; line-height: 1.3; color:#5268A5;}
    .wrap_setli{margin-top: 30px;}
    .wrap_setli p{font-size:12px;}
    .wrap_setli p + ul{margin-top: 20px;}
    .wrap_setli ul{padding-bottom: 10px;}
    .wrap_setli ul li + li{margin-top: 12px;}
    .wrap_setli ul li p{font-size:16px;}
    .wrap_setli ul li a .arr{width: 7px; height: 12px;}
    .wrap_setli ul li a .arr:after{width: 9px; height: 9px;}
    .wrap_setli ul li a .ver{font-size:14px;}
    .wrap_setli ul li .toggle{width: 50px; height: 24px; border-radius:12px;}
    .wrap_setli ul li .toggle .toggle_btn{left: 5px; width: 19px; height: 19px;}
    .wrap_setli ul li .toggle.on .toggle_btn{left: calc(100% - 24px);}
    .wrap_setli ul li.right a{font-size: 12px;}
}

</style>


<h2 class="subtit">
    <?=$g5['title']?>
</h2>

<div class="wrap_content">
    <div class="wrap_setli">
        <ul>
            <?if($member['mb_id']){?>
            <li>
                <a href="
                <?if($is_admin){?>
                /adm
                <?}else{?>
                <?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php
                <?}?>">
                    <p><em><?php echo $member['mb_id']?></em> 님</p> <span class="arr"></span>
                </a>
            </li>
            <li class="right"><a href="<?php echo G5_BBS_URL; ?>/logout.php">로그아웃</a></li>
            <?}else{?>
            <li><a href="<?php echo G5_BBS_URL; ?>/login.php"><p>로그인 / 회원가입</p> <span class="arr"></span></a></li>
            <?}?>
        </ul>
    </div>
    <?php if (defined('G5_IS_APP') && G5_IS_APP) { ?>
    <div class="wrap_setli">
        <p>푸시 알림 설정</p>
        <ul>
            <li><button><p>사한절 알림 수신 동의</p> <span class="toggle"><span class="toggle_btn"></span></span></button></li>
        </ul>
    </div>
    <?php } ?>
    <div class="wrap_setli">
        <p>이용약관</p>
        <ul>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision"><p>이용약관</p> <span class="arr"></span></a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy"><p>개인정보처리방침</p><span class="arr"></span></a></li>
        </ul>
    </div>
    <div class="wrap_setli app">
        <ul>
            <li><a href="javascript:void()"><p>앱 버전</p><span class="ver">1.0.0</span></a></li>
            <li class="right"><a href="//x.com/b1ack2overs" target="_blank">오류/개선문의</a></li>
        </ul>
    </div>

</div>

