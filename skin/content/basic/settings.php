
<?php

?>

<style>
    .wrap_setli{margin-top: 60px;}
    .wrap_setli p{font-size:24px; line-height: 1.5; color:#9AA3B2}
    .wrap_setli p + ul{margin-top: 40px;}
    .wrap_setli ul{padding-bottom: 20px; border-bottom:1px solid #E3E7EF}
    .wrap_setli ul li{}
    .wrap_setli ul li + li{margin-top: 24px;}
    .wrap_setli ul li a,
    .wrap_setli ul li button{display: flex; align-items: center; justify-content: space-between; width: 100%; border:none; background: none;}
    .wrap_setli ul li p{font-size:32px; color:#2F3744; font-weight:500}
    .wrap_setli ul li p em{color:#5268A5; font-weight:600}
    .wrap_setli ul li a .arr{position: relative; width: 14px; height: 24px;}
    .wrap_setli ul li a .arr:after{content:''; position: absolute; width: 18px; height: 18px; border:1px solid #93A2CB; border-width:1px 1px 0 0; transform:rotate(45deg)}
    .wrap_setli ul li a .ver{font-size:28px; line-height: 1.5; }
    .wrap_setli ul li .toggle{position: relative; display: block; width: 100px; height: 48px; border-radius:24px; background: #E3E7EF; transition:.3s}
    .wrap_setli ul li .toggle .toggle_btn{position: absolute; left: 10px; top: 50%; transform:translateY(-50%); width: 38px; height: 38px; border-radius:50%; background: #FEFEFB; transition:.3s}
    .wrap_setli ul li .toggle.on{background: #5268A5;}
    .wrap_setli ul li .toggle.on .toggle_btn{position: absolute; left: calc(100% - 48px);}
    .wrap_setli ul li.right{text-align: right;}
    .wrap_setli ul li.right a{display: inline-block; color:#9AA3B2; font-size: 24px; font-weight:500; text-decoration: underline;}
    .wrap_setli.app ul{border-bottom:none}

    @media(max-width:780px){
        .wrap_setli{margin-top: 7.692vw;}
        .wrap_setli p{font-size:3.077vw;}
        .wrap_setli p + ul{margin-top: 5.128vw;}
        .wrap_setli ul{padding-bottom: 2.564vw;}
        .wrap_setli ul li + li{margin-top: 3.077vw;}
        .wrap_setli ul li p{font-size:4.103vw;}
        .wrap_setli ul li a .arr{width: 1.795vw; height: 3.077vw;}
        .wrap_setli ul li a .arr:after{width: 2.308vw; height: 2.308vw;}
        .wrap_setli ul li a .ver{font-size:3.59vw;}
        .wrap_setli ul li .toggle{width: 12.821vw; height: 6.154vw; border-radius:3.077vw;}
        .wrap_setli ul li .toggle .toggle_btn{left: 1.282vw; width: 4.872vw; height: 4.872vw;}
        .wrap_setli ul li .toggle.on .toggle_btn{left: calc(100% - 6.154vw);}
        .wrap_setli ul li.right a{font-size: 3.077vw;}
    }

</style>

<div class="sub_header">
    <div class="container">
        <button onclick="history.back()" class="arr_prev"></button>
        <h3>설정</h3>
    </div>
</div>

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
    <div class="wrap_setli">
        <p>푸시 알림 설정</p>
        <ul>
            <li><button><p>사한절 알림 수신 동의</p> <span class="toggle"><span class="toggle_btn"></span></span></button></li>
        </ul>
    </div>
    <div class="wrap_setli">
        <p>이용약관</p>
        <ul>
            <li><a href="<?php echo G5_BBS_URL; ?>/privacy.php"><p>이용약관</p> <span class="arr"></span></a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/privacy.php"><p>개인정보처리방침</p><span class="arr"></span></a></li>
        </ul>
    </div>
    <div class="wrap_setli app">
        <ul>
            <li><a href="javascript:void()"><p>앱 버전</p><span class="ver">1.0.0</span></a></li>
            <li class="right"><a href="//x.com/b1ack2overs" target="_blank">오류/개선문의</a></li>
        </ul>
    </div>

</div>

