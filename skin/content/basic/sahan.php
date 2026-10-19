
<?
add_stylesheet(
    '<link rel="stylesheet" href="'.G5_URL.'/js/swiper/swiper.min.css">',
    0
);
?>
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

    @keyframes fadein {
        0% {opacity: 0}
        100% {opacity: 1}
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

    html, body {padding: 0; margin: 0; width: 100%; background: #081521;}
    #hd {display: none;}
    #container {width: 100%; margin: 0; padding: 0;}
    #gnb.sub {position: fixed; transition: .3s; width: 720px; left: 50%; transform:translate(-50%,0); right: initial;}
    #container p {opacity: 0;}
    #container p[data-effect="show"] {animation: fadein_bottom 1.2s forwards;}
    .container_sahan {position: relative; max-width: 991px;  margin: 0 auto;}

    .container_sahan * { box-sizing: border-box; font-family: 'Pretendard', sans-serif; letter-spacing: -0.025em;}

    .container_sahan img {width: 100%;}


    /* =========================
       첫 번째 전체 영역
    ========================== */

    .sec_bk {position: relative;width: 100%;background: #081521 url('<?=G5_IMG_URL?>/about/section_bg.png') no-repeat center top/100% auto; }
    /* .sec_bk {position: relative;width: 100%;background: #081521 url('<?=G5_IMG_URL?>/about/section_bg.png') no-repeat center -72px/100% auto; } */
    /* .sec_bk {position: relative;width: 100%;background: #081521 url('<?=G5_IMG_URL?>/about/KakaoTalk_20260926_212957162.png') no-repeat center top/100% auto; } */

    /* .sec_bk {position: relative;width: 100%;background: url('<?=G5_IMG_URL?>/about/1000096349.png') no-repeat center top/100% auto; } */

    /* =========================
       Sec 01
    ========================== */

    .sec_moon {position: relative; width: 100%;}
    .sec_moon .moon img {}
    .sec_moon:after {content: ''; position: absolute; top: 0; left: 0; right: 0; background: url('<?=G5_IMG_URL?>/about/sec01_star.png') no-repeat center top / 100% auto; mix-blend-mode: soft-light;}
    /* .sec_moon .moon {animation: fadein_top 2s forwards linear;} */
    .sec_moon .since {color: #fff; text-align: center; }
    .sec_moon .total {background: linear-gradient(256.01deg, #FFFFFF 10.49%, #566774 91.28%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; text-align: center;}


    /* =========================
       Sec 02
    ========================== */

    .sec_stars {position: relative; background: url('<?=G5_IMG_URL?>/about/sec02_bg.png') no-repeat center top/100% auto;}
    .sec_stars .star {position: absolute; opacity: 0;}
    .sec_stars .star1 {}
    .sec_stars .star2 {}
    .sec_stars .star3 {}
    .sec_stars .star4 {opacity: 0;}
    .sec_stars .star5 {}
    .sec_stars .star6 {}
    .sec_stars[data-effect="show"] .star {animation: blink 2s forwards ease-in-out;}
    .sec_stars[data-effect="show"] .star2 {animation-delay: .4s;}
    .sec_stars[data-effect="show"] .star3 {animation-delay: .8s;}
    .sec_stars[data-effect="show"] .star4 {animation-delay: 1.2s;}
    .sec_stars[data-effect="show"] .star5 {animation-delay: 1.6s;}
    .sec_stars[data-effect="show"] .star6 {animation-delay: 2s; animation-iteration-count: infinite}


    /* =========================
       Sec 03
    ========================== */

    .sec_korean {position: relative;}
    .sec_korean .people {position: relative; font-family: 'GMarketSansMedium', sans-serif; color: #fff; text-align: center; z-index: 5; opacity:.5}
    .sec_korean .wrap_num {position: relative;}
    .sec_korean .wrap_num:before {content: ''; position: absolute; left: 0; right: 0; bottom: 0; background: url('<?=G5_IMG_URL?>/about/sec03_planet.png') no-repeat center bottom / 100% auto; z-index: 1; }
    .sec_korean .wrap_num:after {content: ''; position: absolute; left: 0; right: 0; bottom: 0; background: url('<?=G5_IMG_URL?>/about/sec03_planet_aura.png') no-repeat center top / 100% auto; z-index: 1; mix-blend-mode:soft-light}
    .sec_korean .num {font-family: 'GMarketSans', sans-serif; text-align: center; background: linear-gradient(180deg, #FFFFFF 7.79%, #4E6FDC 53.86%, #02001F 91.56%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent;}
    .sec_korean .desc {color: #fff; text-align: center;}
    .sec_korean .desc em {font-weight: 500; color: #fff; line-height: 1;}


    /* =========================
       Sec 04
    ========================== */

    .sec_bubble {}
    .sec_bubble img{}


    /* =========================
       Sec 05
    ========================== */

    .sec_sky {display: flex; flex-direction: column;}
    .sec_sky p {background: linear-gradient(256.01deg, #FFFFFF 10.49%, #566774 91.28%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent;}
    .sec_sky .txt01 {text-align: center; align-self: flex-start;}
    .sec_sky .txt02 {text-align: center; align-self: flex-end;}
    .sec_sky .txt03 {text-align: center; align-self: flex-start;}
    .sec_sky .txt04 {text-align: center; width: 100%; font-weight: 600; background: linear-gradient(183deg, #FFFFFF 10.49%, #94cfff 95.28%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent;}
    .sec_sky p[data-effect="show"] {animation-name: fadein_left;}
    .sec_sky .txt02[data-effect="show"] {animation-name: fadein_right;}
    .sec_sky .txt04[data-effect="show"] {animation-name: fadein_bottom;}


    /* =========================
       Sec 06
    ========================== */

    .sec_comet {margin: 0 auto;}
    .sec_comet[data-effect="show"] {animation-name: fadeout, blink; animation-duration: 3s, 3s; animation-delay: .3s, 3s; animation-iteration-count: 1, infinite; animation-timing-function: ease-out;}
    .bottle {color: #fff; text-align: center;}


    /* =========================
       Sec 07 ~ Rescue
    ========================== */

    .sec_rescue p {color: #fff; text-align: center;}


    /* =========================
       Click 화면
       
       sec_bk의 마지막 100vh를
       sec_wh가 겹쳐서 사용
    ========================== */

    .sec_wave {position: relative; width: 100%; height: 100vh; display: flex; align-items: center; justify-content: center;}
    .sec_wave .btn_next {display: flex; flex-direction: column; align-items: center; justify-content: center; background: none; border: none; cursor: pointer;}
    .sec_wave .btn_next img {animation: pulp 2.5s infinite ease-in-out;}
    .sec_wave .btn_next span {display: flex; align-items: center; justify-content: center; border: 1px solid rgba(101, 121, 170, .8); color: #a4e2ff; line-height: 1;}


    /* =========================
       두 번째 전체 영역
       
       sec_bk의 마지막 100vh와 겹침
    ========================== */

    .sec_wh {position: relative; margin-top: -100vh; height: 0; overflow: hidden; background: #000 url('<?=G5_IMG_URL?>/about/section2_bg.png') no-repeat center top / 100% auto; opacity: 0; visibility: hidden; pointer-events: none; transition: opacity 1.5s ease, visibility 0s linear 1.5s; z-index: 2;}
    
    /* .sec_wh {position: relative;width: 100%;background: url('<?=G5_IMG_URL?>/about/1000096347.png') no-repeat center top/100% auto; } */
    .sec_wh *{display: none;}
    .sec_wh.is-active {opacity: 1; visibility: visible; pointer-events: auto; transition: opacity 1.5s ease, visibility 0s; height: auto; overflow: visible; min-height: 110vh;}
    .sec_wh.is-active *{display: block;}
    .sec_wh .think {color: #414d48; text-align: center;}

    /* =========================
       Sec Net
    ========================== */

    .sec_net{}
    .sec_net p{color: #222b41; text-align: center;}

    .sec_sl{overflow:hidden; }
    .sec_sl .sl_phone{overflow:visible; margin: 0 auto;}
    .sec_sl .sl_phone .swiper-wrapper{display: flex !important;}
    .sec_sl .sl_phone .swiper-slide{transform:scale(.7); transition:.3s;}
    .sec_sl .sl_phone .swiper-slide img{width: 100%;}
    .sec_sl .sl_phone .swiper-slide-active{transform:scale(1.2); z-index: 2;}
    .sec_sl .simple{background: linear-gradient(16.72deg, #6E7C9B 8.02%, #3C4757 85.14%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; text-align: center; font-weight:600}
    .sec_sl .install{color:#414d48; text-align: center;}
    .sec_sl .install em{font-weight:600;}
    
    .sec_introduce{}
    .sec_introduce .desc{background: linear-gradient(266.55deg, #485F62 18.68%, #253431 85.3%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; text-align: center;}
    .sec_introduce .desc + .desc{}
    .sec_introduce p{color: #D1DEFF; text-align: center;}
    .sec_introduce p.for{}
    .sec_introduce .logo{margin: 0 auto;}
    
    /* .sec_introduce .sec_stars{background-color: #000;} */
    .sec_introduce .sec_stars[data-effect="show"] .star {animation-name: blink, fadein; animation-duration: 1s, 1s; animation-delay:0s, 2s; animation-fill-mode: forwards; animation-timing-function: ease-in-out;}
    .sec_introduce .sec_stars[data-effect="show"] .star2 {animation-delay: .3s, 2s;}
    .sec_introduce .sec_stars[data-effect="show"] .star3 {animation-delay: .6s, 2s;}
    .sec_introduce .sec_stars[data-effect="show"] .star4 {animation-delay: .9s, 2s;}
    .sec_introduce .sec_stars[data-effect="show"] .star5 {animation-delay: 1.2s, 2s;}
    .sec_introduce .sec_stars[data-effect="show"] .star6 {animation-delay: 1.5s, 2s; animation-iteration-count: 1,1}
    .sec_introduce .sahan{background: url('<?=G5_IMG_URL?>/about/section2_bg.png') no-repeat center bottom/100% auto;}
    

    @media(max-width:991px){
            
        /* .sec_bk{background-position-y: -10vw;} */
        /* =========================
        Sec 01
        ========================== */

        .sec_moon:after {height: 158.472vw;}
        .sec_moon .moon img {margin-top: -10vw;}
        .sec_moon .since {margin-top: -5.494vw; font-size: 4.167vw; line-height: 6.667vw;}
        .sec_moon .total {margin-top: 77.018vw; font-size: 5vw; line-height: 8.333vw;}


        /* =========================
        Sec 02
        ========================== */

        .sec_stars {margin-top: 33.75vw; padding: 6.528vw 0 10vw; height: 157.778vw;}
        .sec_stars .star1 {top: 6.831vw; right: 21.111vw; width: 11.806vw;}
        .sec_stars .star2 {top: 23.75vw; left: 15.417vw; width: 19.444vw;}
        .sec_stars .star3 {top: 48.876vw; right: 15.278vw; width: 11.806vw;}
        .sec_stars .star4 {top: 72.084vw; right: 41.667vw; width: 16.111vw;}
        .sec_stars .star5 {top: 114.005vw; left: 29.167vw; width: 11.806vw;}
        .sec_stars .star6 {top: 139.424vw; right: 34.031vw; width: 11.806vw;}


        /* =========================
        Sec 03
        ========================== */

        .sec_korean {margin-top: 5.045vw;}
        .sec_korean .people {font-size: 3.889vw; line-height: 5.417vw;}
        .sec_korean .wrap_num {margin-top: 10vw; padding: 1.389vw 0 37.083vw;}
        .sec_korean .wrap_num:before {height: 75vw;}
        .sec_korean .wrap_num:after {height: 75vw;}
        .sec_korean .num {font-size: 36.25vw; line-height: 36.528vw;}
        .sec_korean .desc {margin-top: 6.879vw; font-size: 4.167vw; line-height: 10vw;}
        .sec_korean .desc em {font-size: 7.639vw;}


        /* =========================
        Sec 04
        ========================== */

        .sec_bubble {margin: 41.667vw auto 0 20.833vw;}
        .sec_bubble img{width: 59.583vw;}


        /* =========================
        Sec 05
        ========================== */

        .sec_sky {margin-top: 10vw; padding-top: 73.101vw;}
        .sec_sky p {font-size: 4.167vw; line-height: 6.667vw; text-shadow: 0vw 0vw 4.167vw rgba(48, 101, 209, 0.5);}
        .sec_sky .txt01 {padding-left: 20.833vw;}
        .sec_sky .txt02 {margin-top: 55.49vw; padding-right: 15.417vw;}
        .sec_sky .txt03 {margin-top: 61.389vw; padding-left: 14.722vw;}
        .sec_sky .txt04 {margin-top: 88.444vw; font-size: 5vw; line-height: 8.333vw; text-shadow: 0vw 0vw 4.167vw rgba(48, 101, 209, 0.5);}


        /* =========================
        Sec 06
        ========================== */

        .sec_comet {margin: 57.194vw auto 0; width: 21.528vw;}
        .bottle {margin-top: 119.759vw; font-size: 4.167vw; line-height: 6.667vw; text-shadow: 0vw 0vw 4.167vw rgba(48, 101, 209, 0.63);}


        /* =========================
        Sec 07 ~ Rescue
        ========================== */

        .sec_rescue {padding: 83.268vw 0 36.528vw;}
        .sec_rescue p {font-size: 4.167vw; line-height: 6.667vw; text-shadow: 0vw 0vw 4.167vw rgba(48, 101, 209, 0.63);}


        /* =========================
        Click 화면
        
        sec_bk의 마지막 100vh를
        sec_wh가 겹쳐서 사용
        ========================== */

        .sec_wave{margin-top: 28.22vw;}
        .sec_wave .btn_next {gap: 10.972vw;}
        .sec_wave .btn_next img {width: 30.972vw;}
        .sec_wave .btn_next span {width: 22.778vw; height: 10.139vw; border-radius: 5.139vw; font-size: 4.354vw;}


        /* =========================
        두 번째 전체 영역
        
        sec_bk의 마지막 100vh와 겹침
        ========================== */

        .sec_wh {padding-top: 27.953vw;}
        .sec_wh .think {font-size: 4.167vw;}

        /* =========================
        Sec Net
        ========================== */

        .sec_net{margin-top: 75.453vw;}
        .sec_net p{font-size: 4.67vw; line-height: 6.667vw;}

        .sec_sl{margin-top: 101.324vw; padding-bottom: 23.885vw;}
        .sec_sl .sl_phone{width: 55.611vw; margin: 26.738vw auto 0;}
        .sec_sl .simple{text-shadow: 0vw 0vw 2.778vw rgba(198, 226, 255, 0.5); font-size: 7vw;}
        .sec_sl .install{margin-top: 26.763vw; font-size: 3.611vw; line-height: 5.556vw;}
        .sec_sl .install em{font-size: 4.167vw;}
        
        .sec_introduce{padding: 27.583vw 0 0;}
        .sec_introduce .desc{text-shadow: 0vw 0vw 2.778vw rgba(220, 251, 255, 0.3); font-size: 3.611vw; line-height: 6.667vw;}
        .sec_introduce .desc + .desc{margin-top: 38.342vw;}
        .sec_introduce p{text-shadow: 0vw 0vw 2.083vw rgba(45, 70, 87, 0.8); font-size: 4.167vw;}
        .sec_introduce .sec_stars{margin-top: 57.61vw; height: 202.178vw;}
        .sec_introduce p.for{margin-top: 41.481vw;}
        .sec_introduce .logo{margin:6.536vw auto 0; width: 57.917vw;}
        .sec_introduce .sahan{padding-bottom: 241.806vw;}
    }
    @media(min-width:991px){
            
      
        /* .sec_bk{background-position-y: -10vw;} */
        /* =========================
        Sec 01
        ========================== */

        .sec_moon:after {height: 1570.458px;}
        .sec_moon .moon img {margin-top: -99.1px;}
        .sec_moon .since {margin-top: -54.446px; font-size: 41.295px; line-height: 66.07px;}
        .sec_moon .total {margin-top: 763.248px; font-size: 49.55px; line-height: 82.58px;}


        /* =========================
        Sec 02
        ========================== */

        .sec_stars {margin-top: 334.463px; padding: 64.692px 0 99.1px; height: 1563.58px;}
        .sec_stars .star1 {top: 67.695px; right: 209.21px; width: 116.997px;}
        .sec_stars .star2 {top: 235.362px; left: 152.782px; width: 192.69px;}
        .sec_stars .star3 {top: 484.361px; right: 151.405px; width: 116.997px;}
        .sec_stars .star4 {top: 714.352px; right: 412.92px; width: 159.66px;}
        .sec_stars .star5 {top: 1129.79px; left: 289.045px; width: 116.997px;}
        .sec_stars .star6 {top: 1381.692px; right: 337.247px; width: 116.997px;}


        /* =========================
        Sec 03
        ========================== */

        .sec_korean {margin-top: 49.996px;}
        .sec_korean .people {font-size: 38.54px; line-height: 53.682px;}
        .sec_korean .wrap_num {margin-top: 99.1px; padding: 13.765px 0 367.493px;}
        .sec_korean .wrap_num:before {height: 743.25px;}
        .sec_korean .wrap_num:after {height: 743.25px;}
        .sec_korean .num {font-size: 359.238px; line-height: 361.992px;}
        .sec_korean .desc {margin-top: 68.171px; font-size: 41.295px; line-height: 99.1px;}
        .sec_korean .desc em {font-size: 75.702px;}


        /* =========================
        Sec 04
        ========================== */

        .sec_bubble {margin: 412.92px auto 0 206.455px;}
        .sec_bubble img{width: 590.468px;}


        /* =========================
        Sec 05
        ========================== */

        .sec_sky {margin-top: 99.1px; padding-top: 724.431px;}
        .sec_sky p {font-size: 41.295px; line-height: 66.07px; text-shadow: 0px 0px 41.295px rgba(48, 101, 209, 0.5);}
        .sec_sky .txt01 {padding-left: 206.455px;}
        .sec_sky .txt02 {margin-top: 549.906px; padding-right: 152.782px;}
        .sec_sky .txt03 {margin-top: 608.365px; padding-left: 145.895px;}
        .sec_sky .txt04 {margin-top: 876.48px; font-size: 49.55px; line-height: 82.58px; text-shadow: 0px 0px 41.295px rgba(48, 101, 209, 0.5);}


        /* =========================
        Sec 06
        ========================== */

        .sec_comet {margin: 566.793px auto 0; width: 213.342px;}
        .bottle {margin-top: 1186.812px; font-size: 41.295px; line-height: 66.07px; text-shadow: 0px 0px 41.295px rgba(48, 101, 209, 0.63);}


        /* =========================
        Sec 07 ~ Rescue
        ========================== */

        .sec_rescue {padding: 825.186px 0 361.992px;}
        .sec_rescue p {font-size: 41.295px; line-height: 66.07px; text-shadow: 0px 0px 41.295px rgba(48, 101, 209, 0.63);}


        /* =========================
        Click 화면
        
        sec_bk의 마지막 100vh를
        sec_wh가 겹쳐서 사용
        ========================== */

        .sec_wave{margin-top: 279.66px;}
        .sec_wave .btn_next {gap: 108.733px;}
        .sec_wave .btn_next img {width: 306.933px;}
        .sec_wave .btn_next span {width: 225.73px; height: 100.477px; border-radius: 50.927px; font-size: 43.148px;}


        /* =========================
        두 번째 전체 영역
        
        sec_bk의 마지막 100vh와 겹침
        ========================== */

        .sec_wh {padding-top: 277.014px;}
        .sec_wh .think {font-size: 41.295px;}

        /* =========================
        Sec Net
        ========================== */

        .sec_net{margin-top: 747.739px;}
        .sec_net p{font-size: 46.28px; line-height: 66.07px;}

        .sec_sl{margin-top: 1004.121px; padding-bottom: 236.7px;}
        .sec_sl .sl_phone{width: 551.105px; margin: 264.974px auto 0;}
        .sec_sl .simple{text-shadow: 0px 0px 27.53px rgba(198, 226, 255, 0.5); font-size: 69.37px;}
        .sec_sl .install{margin-top: 265.221px; font-size: 35.785px; line-height: 55.06px;}
        .sec_sl .install em{font-size: 41.295px;}
        
        .sec_introduce{padding: 273.348px 0 0;}
        .sec_introduce .desc{text-shadow: 0px 0px 27.53px rgba(220, 251, 255, 0.3); font-size: 35.785px; line-height: 66.07px;}
        .sec_introduce .desc + .desc{margin-top: 379.969px;}
        .sec_introduce p{text-shadow: 0px 0px 20.643px rgba(45, 70, 87, 0.8); font-size: 41.295px;}
        .sec_introduce .sec_stars{margin-top: 570.915px; height: 2003.584px;}
        .sec_introduce p.for{margin-top: 411.077px;}
        .sec_introduce .logo{margin:64.772px auto 0; width: 573.957px;}
        .sec_introduce .sahan{padding-bottom: 2396.297px;}
    }

</style>

<script src="https://code.jquery.com/jquery-4.0.0.min.js"
    integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao="
    crossorigin="anonymous"></script>
<script src="<?=G5_URL?>/js/swiper/swiper.min.js"></script>

<script>
    let lastScrollTop = 0;
    let secWhActivated = false; // sec_wh가 is-active된 적 있는지 플래그
    let secWaveTopCache = null; // 클릭 직전 sec_wave 문서 절대 위치 캐싱

    $(window).on('scroll', function () {

        const currentScrollTop = $(this).scrollTop();


        /* =========================
           GNB
        ========================== */

        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        const isAtBottom = currentScrollTop + clientHeight >= scrollHeight - 2;

        if (currentScrollTop <= 0 || isAtBottom) {

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
           sec_wave 위로 완전히 올라가면
           sec_wh 다시 숨김
           
           기준: sec_wave의 문서 절대 top(캐싱값)보다
           현재 scrollTop이 작으면 = sec_wave가 화면 아래로 내려간 상태
        ========================== */

        if (secWhActivated && secWaveTopCache !== null) {
            // sec_wave의 bottom(top + height)보다 scrollTop이 위로 올라가면 비활성
            const secWaveBottom = secWaveTopCache + $('.sec_wave').outerHeight();
            if (currentScrollTop < secWaveTopCache) {
                secWhActivated = false;
                secWaveTopCache = null;
                $('.sec_wh').removeClass('is-active');
                $('.sec_wh [data-effect="show"]').attr('data-effect', '');
            }
        }


        /* =========================
           data-effect
           
           viewport 기준: 요소의 top이 화면 하단 85% 지점에 닿으면 show
        ========================== */

        const windowHeight = $(window).height();

        $('[data-effect]:not([data-effect="show"])').each(function () {
            const $this = $(this);

            // sec_wh 내부 요소는 sec_wh가 is-active일 때만 처리
            if ($this.closest('.sec_wh').length && !$this.closest('.sec_wh').hasClass('is-active')) return;

            // offset().top은 문서 기준 절대 위치 → viewport 기준으로 변환
            const elementTopInViewport = $this.offset().top - currentScrollTop;

            if (elementTopInViewport < windowHeight * 0.85) {
                $this.attr('data-effect', 'show');
            }
        });


        lastScrollTop = currentScrollTop;

    });


    $(function () {

        /* =========================
           Click
           
           sec_bk → sec_wh
        ========================== */

        let sl_phone = null;

        $('.btn_next').on('click', function () {

            // 이미 활성화 상태면 중복 처리 방지
            if (secWhActivated) return;

            // sec_wave 상단이 viewport 최상단에 오도록 스크롤
            // (sec_wave가 height:100vh이고 버튼이 flex 중앙이므로 top에 맞추면 정확히 맞음)
            secWaveTopCache = $('.sec_wave').offset().top;

            $('html, body').animate({
                scrollTop: secWaveTopCache
            }, 400, function () {

                // 스크롤 완료 후 sec_wh 활성화
                secWhActivated = true;
                $('.sec_wh').addClass('is-active');

                // think는 즉시 show
                $('.think').attr('data-effect', 'show');

                // sec_wh * {display:none} 해제 이후에 Swiper 초기화
                // (한 프레임 뒤에 실행해야 슬라이드 크기 정상 계산)
                setTimeout(function () {
                    if (sl_phone) {
                        sl_phone.destroy(true, true);
                        sl_phone = null;
                    }
                    sl_phone = new Swiper('.sl_phone', {
                        slidesPerView: 1,
                        spaceBetween: -72,
                        centeredSlides: true,
                        speed: 300,
                        loop: true,
                        loopAdditionalSlides: 8,
                        autoplay: {
                            delay: 3000,
                        }
                    });
                }, 50);

            });

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
            <p class="people" data-effect>
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
                    Click
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
                    <li class="swiper-slide"><img src="<?=G5_IMG_URL?>/about/sl_phone01.png" alt=""></li>
                    <li class="swiper-slide"><img src="<?=G5_IMG_URL?>/about/sl_phone02.png" alt=""></li>
                    <li class="swiper-slide"><img src="<?=G5_IMG_URL?>/about/sl_phone03.png" alt=""></li>
                    <li class="swiper-slide"><img src="<?=G5_IMG_URL?>/about/sl_phone01.png" alt=""></li>
                    <li class="swiper-slide"><img src="<?=G5_IMG_URL?>/about/sl_phone02.png" alt=""></li>
                    <li class="swiper-slide"><img src="<?=G5_IMG_URL?>/about/sl_phone03.png" alt=""></li>
                    <li class="swiper-slide"><img src="<?=G5_IMG_URL?>/about/sl_phone01.png" alt=""></li>
                    <li class="swiper-slide"><img src="<?=G5_IMG_URL?>/about/sl_phone02.png" alt=""></li>
                    <li class="swiper-slide"><img src="<?=G5_IMG_URL?>/about/sl_phone03.png" alt=""></li>
                </ul>
            </div>
            <p class="install" data-effect>
                <em>앱 하나만 설치하시면, </em>
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
            <div class="sahan" data-effect>
                <p data-effect>&lt;사한&gt;입니다</p>
                <p class="logo" data-effect>
                    <img src="<?=G5_IMG_URL?>/about/sec09_logo.png" alt="SAHAN">
                </p>
            </div>
        </div>
        


    </div>


</div>