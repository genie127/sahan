<style>
    @font-face {
        font-family: 'GMarketSans';
        src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2001@1.1/GmarketSansLight.woff') format('woff');
        font-weight: 300;
        font-display: swap;
    }

    @font-face {
        font-family: 'GMarketSansMedium';
        src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2001@1.1/GmarketSansMedium.woff') format('woff');
        font-weight: 500;
        font-display: swap;
    }

    @font-face {
        font-family: 'GMarketSansBold';
        src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2001@1.1/GmarketSansBold.woff') format('woff');
        font-weight: 700;
        font-display: swap;
    }


    /* =========================
       Animation
    ========================== */

    @keyframes fadein_top {
        0% {transform: translateY(-150px)}
        100% {transform: translateY(0px)}
    }

    @keyframes fadein_bottom {
        0% {opacity: 0; transform: translateY(150px)}
        100% {opacity: 1; transform: translateY(0px)}
    }

    @keyframes fadein_left {
        0% {opacity: 0; transform: translateX(-150px)}
        100% {opacity: 1; transform: translateY(0px)}
    }

    @keyframes fadein_right {
        0% {opacity: 0; transform: translateX(150px)}
        100% {opacity: 1; transform: translateY(0px)}
    }

    @keyframes twinkle_fadeout {
        0% {opacity: .2}
        50% {opacity: 1}
        100% {opacity: 0}
    }

    @keyframes fadeout {
        0% {opacity: 1}
        100% {opacity: 0}
    }

    @keyframes blink {
        0% {opacity: 0}
        90% {opacity: 1}
        100% {opacity: 0}
    }

    @keyframes pulp {
        0% {opacity: 1; transform: scale(1)}
        50% {opacity: .5; transform: scale(.8)}
        100% {opacity: 1; transform: scale(1)}
    }


    /* =========================
       Common
    ========================== */

    body {padding-top: 0; margin: 0; width: 100%;}
    #hd {display: none;}
    #container {width: 100%; margin: 0; padding: 0;}
    #gnb.sub {position: fixed; transition: .3s; width: 720px; left: 50%; transform:translate(-50%,0); right: initial;}
    p {opacity: 0;}
    p[data-effect="show"] {animation: fadein_bottom 1.2s forwards;}
    .container_sahan {position: relative; max-width: 720px; margin: 0 auto;}

    .container_sahan * { box-sizing: border-box; font-family: 'Pretendard', sans-serif; letter-spacing: -0.025em;}

    .container_sahan img {width: 100%;}


    /* =========================
       첫 번째 전체 영역
    ========================== */

    .sec_bk {position: relative;width: 100%;background: #111 url('<?=G5_IMG_URL?>/about/section_bg.png') no-repeat center top/100% auto; }


    /* =========================
       Sec 01
    ========================== */

    .sec_moon {
        position: relative;
        width: 100%;
    }

    .sec_moon:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1140.998px;
        background: url('<?=G5_IMG_URL?>/about/sec01_star.png') no-repeat center top / 100% auto;
        mix-blend-mode: soft-light;
    }

    .sec_moon .moon {
        animation: fadein_top 2s forwards linear;
    }

    .sec_moon .since {
        margin-top: 72px;
        font-size: 30.002px;
        line-height: 48.002px;
        color: #fff;
        text-align: center;
        animation-delay: 2s;
    }

    .sec_moon .total {
        margin-top: 283.997px;
        background: linear-gradient(256.01deg, #FFFFFF 10.49%, #566774 91.28%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
        font-size: 36px;
        line-height: 59.998px;
        text-align: center;
    }


    /* =========================
       Sec 02
    ========================== */

    .sec_stars {
        margin-top: 243px;
        padding: 47px 0 72px;
        position: relative;
        height: 1156px;
        background: url('<?=G5_IMG_URL?>/about/sec02_bg.png');
    }

    .sec_stars .star {
        position: absolute;
        opacity: .2;
    }

    .sec_stars .star1 {
        top: 47px;
        right: 151.999px;
        width: 85.003px;
    }

    .sec_stars .star2 {
        top: 170.998px;
        left: 111.002px;
        width: 139.997px;
    }

    .sec_stars .star3 {
        top: 348.997px;
        right: 110.002px;
        width: 85.003px;
    }

    .sec_stars .star4 {
        top: 519.003px;
        right: 300.002px;
        width: 115.999px;
        opacity: 0;
    }

    .sec_stars .star5 {
        bottom: 254.002px;
        left: 210.002px;
        width: 85.003px;
    }

    .sec_stars .star6 {
        bottom: 72px;
        right: 249.998px;
        width: 85.003px;
    }

    .sec_stars[data-effect="show"] .star {
        animation: twinkle_fadeout 2s forwards ease-in-out;
    }

    .sec_stars[data-effect="show"] .star2 {
        animation-delay: .4s;
    }

    .sec_stars[data-effect="show"] .star3 {
        animation-delay: 1.2s;
    }

    .sec_stars[data-effect="show"] .star4 {
        animation: blink 3s .4s infinite ease-in-out;
    }

    .sec_stars[data-effect="show"] .star5 {
        animation-delay: .8s;
    }

    .sec_stars[data-effect="show"] .star6 {
        animation-delay: 1.6s;
    }


    /* =========================
       Sec 03
    ========================== */

    .sec_korean {
        position: relative;
        padding-top: 191px;
        background: url('<?=G5_IMG_URL?>/about/sec03_bg.png') no-repeat center top / 100% auto;
    }

    .sec_korean .people {
        font-family: 'GMarketSansMedium', sans-serif;
        font-size: 28px;
        line-height: 39px;
        color: #fff;
        opacity: .13;
        text-align: center;
    }

    .sec_korean .wrap_num {
        position: relative;
        margin-top: 72px;
        padding: 10px 0 267px;
    }

    .sec_korean .wrap_num:before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 540px;
        background: url('<?=G5_IMG_URL?>/about/sec03_planet.png') no-repeat center bottom / 100% auto;
        z-index: 1;
        filter: light;
    }
    .sec_korean .wrap_num:after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 540px;
        background: url('<?=G5_IMG_URL?>/about/sec03_planet.png') no-repeat center bottom / 100% auto;
        z-index: 1;
        filter: light;
    }

    .sec_korean .num {
        font-family: 'GMarketSans', sans-serif;
        font-size: 261px;
        text-align: center;
        background: linear-gradient(180deg, #FFFFFF 7.79%, #4E6FDC 53.86%, #02001F 91.56%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
        line-height: 263px;
    }

    .sec_korean .desc {
        margin-top: 59px;
        font-size: 30px;
        line-height: 72px;
        color: #fff;
        text-align: center;
    }

    .sec_korean .desc em {
        font-weight: 500;
        font-size: 55px;
        color: #fff;
    }


    /* =========================
       Sec 04
    ========================== */

    .sec_bubble {
        margin-top: 320px;
    }


    /* =========================
       Sec 05
    ========================== */

    .sec_sky {
        margin-top: 72px;
        background: url('<?=G5_IMG_URL?>/about/sec05_bg.png') no-repeat center top / 100% auto;
        display: flex;
        flex-direction: column;
        padding-top: 541px;
    }

    .sec_sky p {
        font-size: 30px;
        line-height: 48px;
        background: linear-gradient(256.01deg, #FFFFFF 10.49%, #566774 91.28%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
        text-shadow: 0px 0px 30px rgba(48, 101, 209, 0.5);
    }

    .sec_sky .txt01 {
        padding-left: 150px;
        text-align: center;
        align-self: flex-start;
    }

    .sec_sky .txt02 {
        margin-top: 402px;
        padding-right: 111px;
        text-align: center;
        align-self: flex-end;
    }

    .sec_sky .txt03 {
        margin-top: 463px;
        padding-left: 106px;
        text-align: center;
        align-self: flex-start;
    }

    .sec_sky .txt04 {
        margin-top: 412px;
        text-align: center;
        width: 100%;
        font-size: 36px;
        line-height: 60px;
        font-weight: 600;
        background: linear-gradient(183deg, #FFFFFF 10.49%, #94cfff 95.28%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
        text-shadow: 0px 0px 30px rgba(48, 101, 209, 0.5);
    }

    .sec_sky p[data-effect="show"] {
        animation-name: fadein_left;
    }

    .sec_sky .txt02[data-effect="show"] {
        animation-name: fadein_right;
    }

    .sec_sky .txt04[data-effect="show"] {
        animation-name: fadein_bottom;
    }


    /* =========================
       Sec 06
    ========================== */

    .sec_comet {
        margin: 327px auto 0;
        width: 155px;
    }

    .sec_comet[data-effect="show"] {
        animation-name: fadeout, blink;
        animation-duration: 3s, 3s;
        animation-delay: .3s, 3s;
        animation-iteration-count: 1, infinite;
        animation-timing-function: ease-out;
    }

    .bottle {
        margin-top: 296px;
        font-size: 30px;
        line-height: 48px;
        color: #fff;
        text-shadow: 0px 0px 30px rgba(48, 101, 209, 0.63);
        text-align: center;
    }


    /* =========================
       Sec 07 ~ Rescue
    ========================== */

    .sec_rescue {
        margin-top: 397px;
        padding: 285px 0 263px;
        background: url('<?=G5_IMG_URL?>/about/sec08_bg.png') no-repeat center top / 100% auto;
    }

    .sec_rescue p {
        font-size: 30px;
        line-height: 48px;
        color: #fff;
        text-shadow: 0px 0px 30px rgba(48, 101, 209, 0.63);
        text-align: center;
    }


    /* =========================
       Click 화면
       
       sec_bk의 마지막 100vh를
       sec_wh가 겹쳐서 사용
    ========================== */

    .sec_wave {
        position: relative;

        width: 100%;
        height: 100vh;

        display: flex;
        align-items: center;
        justify-content: center;

        background: url('<?=G5_IMG_URL?>/about/sec08_bg.png') no-repeat center bottom / 100% auto;
    }

    .sec_wave .btn_next {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 79px;

        background: none;
        border: none;

        cursor: pointer;
    }

    .sec_wave .btn_next img {
        animation: pulp 2.5s infinite ease-in-out;
    }

    .sec_wave .btn_next span {
        width: 164px;
        height: 73px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 37px;
        border: 1px solid rgba(101, 121, 170, .8);

        color: #a4e2ff;
        font-size: 31.35px;
        line-height: 1;
    }


    /* =========================
       두 번째 전체 영역
       
       sec_bk의 마지막 100vh와 겹침
    ========================== */

    .sec_wh {
        position: relative;
        padding-top: 384px;
        margin-top: -100vh;
        min-height: 100vh;
        background: #fff url('<?=G5_IMG_URL?>/about/sec09_bg.png') no-repeat center top / 100% auto;

        opacity: 0;
        visibility: hidden;
        pointer-events: none;

        transition:
            opacity 1.5s ease,
            visibility 0s linear 1.5s;

        z-index: 2;
    }
    .sec_wh *{
        display: none;
    }

    .sec_wh.is-active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transition:
            opacity 1.5s ease,
            visibility 0s;
        height: auto;
    }
    .sec_wh.is-active *{
        display: block;
    }

    .sec_wh .think {font-size: 30px; color: #414d48; text-align: center;}


    /* =========================
       Sec Net
    ========================== */

    .sec_net{ margin-top: 685px;}
    .sec_net p{font-size: 30px; line-height: 48px; color: #222b41; text-align: center;}

    .sec_sl{margin-top: 633px; padding-bottom: 419px;}
    .sec_sl .simple{background: linear-gradient(16.72deg, #6E7C9B 8.02%, #3C4757 85.14%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; text-shadow: 0px 0px 20px rgba(198, 226, 255, 0.5); font-size:48px; text-align: center; font-weight:600}
    .sec_sl .install{margin-top:207px;  font-size:26px; line-height: 40px; color:#414d48; text-align: center;}
    .sec_sl .install em{font-size:30px; font-weight:600;}
    
    .sec_introduce{padding: 487px 0 1400px; background: url('<?=G5_IMG_URL?>/about/section2_bg.png') no-repeat center bottom /100% auto;}
    .sec_introduce .desc{background: linear-gradient(266.55deg, #485F62 18.68%, #253431 85.3%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; text-shadow: 0px 0px 20px rgba(220, 251, 255, 0.3); font-size: 30px; line-height: 48px; text-align: center;}
    .sec_introduce .desc + .desc{margin-top: 266px;}
    .sec_introduce p.for{margin-top: 308px; color: #D1DEFF; text-shadow: 0px 0px 15px rgba(45, 70, 87, 0.8); text-align: center; font-size:30px;}
    .sec_introduce .logo{margin: 809px auto 0; width: 417px;}
    .sec_introduce .logo + p{margin-top: 208px;}

</style>


<script src="https://code.jquery.com/jquery-4.0.0.min.js"
    integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao="
    crossorigin="anonymous"></script>


<script>
    let lastScrollTop = 0;

    $(window).on('scroll', function () {

        const currentScrollTop = $(this).scrollTop();


        /* =========================
           data-effect
        ========================== */

       $('[data-effect]:not([data-effect="show"])').each(function () {
            const $this = $(this);

            if ($this.closest('.sec_wh').length && !$this.closest('.sec_wh').hasClass('is-active')) return;

            const elementTop = $this.offset().top * .9;

            if (currentScrollTop >= elementTop) {
                $this.attr('data-effect', 'show');
            }
            if (currentScrollTop < secWaveTop) {
                $('.sec_wh').removeClass('is-active');
                $('.sec_wh [data-effect="show"]').attr('data-effect', '');
            }
        });


        /* =========================
           GNB
        ========================== */

        if (currentScrollTop <= 0) {

            $('#gnb').css(
                'transform',
                'translateX(-50%)'
            );

        } else if (currentScrollTop > lastScrollTop) {

            $('#gnb').css(
                'transform',
                'translate(-50%,200%)'
            );

        } else if (currentScrollTop < lastScrollTop) {

            $('#gnb').css(
                'transform',
                'translate(-50%,0)'
            );

        }


        /* =========================
           sec_wave 위로 올라가면
           sec_wh 다시 숨김
        ========================== */

        const secWaveTop = $('.sec_wave').offset().top;

        if (currentScrollTop < secWaveTop) {

            $('.sec_wh').removeClass('is-active');

        }


        lastScrollTop = currentScrollTop;

    });


    $(function () {

        /* =========================
           Click
           
           sec_bk → sec_wh
        ========================== */

        $('.btn_next').on('click', function () {

            $('.sec_wh').addClass('is-active');
            $('.think').attr('data-effect','show');

        });

    });
</script>


<div class="container_sahan">


    <!-- ==================================================
         첫 번째 화면 전체
    =================================================== -->

    <div class="sec_bk">
        <div class="sec_moon">
            <div class="moon">
                <img src="<?=G5_IMG_URL?>/about/sec01_moon.png" alt="">
            </div>
            <p class="since" data-effect="show">
                1982년,
                <br>
                첫 우주관광선 출범 이후
            </p>
            <p class="total" data-effect>
                통신이 끊긴 우주난민의 수는
                <br>
                전세계적으로 2200명에 달하며
            </p>
        </div>

        <div class="sec_stars" data-effect>
            <div class="star star1">
                <img src="<?=G5_IMG_URL?>/about/sec02_star01.png" alt="">
            </div>
            <div class="star star2">
                <img src="<?=G5_IMG_URL?>/about/sec02_star02.png" alt="">
            </div>
            <div class="star star3">
                <img src="<?=G5_IMG_URL?>/about/sec02_star03.png" alt="">
            </div>
            <div class="star star4">
                <img src="<?=G5_IMG_URL?>/about/sec02_star04.png" alt="">
            </div>
            <div class="star star5">
                <img src="<?=G5_IMG_URL?>/about/sec02_star05.png" alt="">
            </div>
            <div class="star star6">
                <img src="<?=G5_IMG_URL?>/about/sec02_star06.png" alt="">
            </div>
        </div>

        <div class="sec_korean">
            <p class="people">
                Out of 2,200 people
            </p>
            <div class="wrap_num">
                <p class="num" data-effect>
                    146
                </p>
            </div>
            <p class="desc" data-effect>
                그중 한국인은
                <br>
                <em>총 146명입니다.</em>
            </p>
        </div>

        <div class="sec_bubble">
            <img src="<?=G5_IMG_URL?>/about/sec04_bubble.png" alt="">
        </div>

        <div class="sec_sky">
            <p class="txt01" data-effect>
                그들이
                <br>
                살아 있는지
            </p>
            <p class="txt02" data-effect>
                살아 있다면
                <br>
                무사한지
            </p>
            <p class="txt03" data-effect>
                언제쯤 지구로
                <br>
                돌아올 수 있는지
            </p>
            <p class="txt04" data-effect>
                오로지 지구의 시간을 살아가는
                <br>
                우리는 아무것도 알 수 없습니다.
            </p>
        </div>

        <div class="sec_comet" data-effect>
            <img src="<?=G5_IMG_URL?>/about/sec06_comet.png" alt="">
        </div>

        <p class="bottle" data-effect>
            우주에서 낙오된 전파를 찾는 것은
            <br>
            마치 바다에 던져진 유리병 편지를
            <br>
            찾아내는 것과 같은 작업입니다.
        </p>

        <div class="sec_rescue">
            <p data-effect>
                무턱대고 손이 닿는 대로
                <br>
                건져 볼 수밖에 없죠.
            </p>
        </div>

        <div class="sec_wave">
            <button class="btn_next">
                <img
                    src="<?=G5_IMG_URL?>/about/sec07_star.png"
                    alt=""
                >
                <span>
                    Click!
                </span>
            </button>
        </div>
    </div>

    <div class="sec_wh">
        <p class="think" data-effect>
            그 막연함 앞에 모두가 포기했을 때
            <br>
            우리는 생각했습니다.
        </p>

        <div class="sec_net">
            <p data-effect>
                그렇다면
                <br>
                최대한 많은 그물을
                <br>
                드리워 보자.
            </p>
        </div>

        <div class="sec_sl">
            <p class="simple" data-effect>
                아주 간단합니다.
            </p>
            <div class="swiper sl_phone">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide"></li>
                    <li class="swiper-slide"></li>
                    <li class="swiper-slide"></li>
                    <li class="swiper-slide"></li>
                </ul>
            </div>
            <p class="install" data-effect>
                <em>앱 하나만 설치하시면, </em>
                <br>
                <br>보고 싶은 이들에게 적은 메시지가 
                <br>저희 KKO 통신의 위성에 저장되어
                <br>매일 저녁 우주 곳곳으로 쏘아 보낼 수 있는 
                <br>텍스트 데이터로 변환됩니다.
            </p>
        </div>
        <div class="sec_introduce">
            <p class="desc" data-effect>지금 이 순간에도 우리와 같은,</p>
            <p class="desc" data-effect>또는,</p>
            <p class="for" data-effect>
                다른 시간에 있을
                <br>가족, 친구, 연인에게 보내는 KKO의 위로.
            </p>
            <p class="logo" data-effect>
                <img src="<?=G5_IMG_URL?>/about/sec09_logo.png" alt="SAHAN">
            </p>
            <p class="for" data-effect>
                &lt;사한&gt;입니다
            </p>>
        </div>
        


    </div>


</div>