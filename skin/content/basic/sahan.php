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
    font-family: 'GMarketSans';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2001@1.1/GmarketSansBold.woff') format('woff');
    font-weight: 700;
    font-display: swap;
}


    @keyframes fadein_top{
        0%{transform:translateY(-150px)}
        100%{transform:translateY(0px)}
    }
    @keyframes fadein_bottom{
        0%{opacity:0; transform:translateY(150px)}
        100%{opacity:1; transform:translateY(0px)}
    }
    @keyframes fadein_left{
        0%{opacity:0; transform:translateX(-150px)}
        100%{opacity:1; transform:translateY(0px)}
    }
    @keyframes fadein_right{
        0%{opacity:0; transform:translateX(150px)}
        100%{opacity:1; transform:translateY(0px)}
    }

    @keyframes fadeout{
        0%{opacity:.2}
        50%{opacity:1}
        100%{opacity:0}
    }
    @keyframes blink{
        0%{opacity:0}
        90%{opacity:1}
        100%{opacity:0}
    }

    body{padding-top: 0; background: #111; margin: 0; width: 100%;}
    #hd{display: none;}
    #container{margin: 0; padding: 0;}
    #gnb{transition:.3s}

    p{opacity:0;}
    p[data-effect="show"]{animation:fadein_bottom 1.2s forwards}
    
    .container_sahan{position: relative; background: #111; max-width:720px; margin: 0 auto; padding-bottom: 200vh;}
    .container_sahan *{box-sizing:border-box; font-family:'Pretendard', sans-serif; letter-spacing: -0.025em; }
    .container_sahan img{width: 100%;}

    .sec_moon{position: relative;width: 100%; }
    .sec_moon:after{content:''; position: absolute; top: 0; left: 0; right: 0; height: 1140.998px; background: url('<?=G5_IMG_URL?>/about/sec01_star.png') no-repeat center top/100% auto; mix-blend-mode:soft-light}
    .sec_moon .moon{animation:fadein_top 2s forwards linear}
    .sec_moon .since{margin-top: 72px; font-size:30.002px; line-height: 48.002px; color:#fff; text-align: center; animation-delay:2s}
    .sec_moon .total{margin-top: 283.997px; background: linear-gradient(256.01deg, #FFFFFF 10.49%, #566774 91.28%);-webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; font-size:36px; line-height: 59.998px; text-align: center;}

    .sec_stars{margin-top: 243px; padding: 47px 0 72px; position: relative; height: 1156px; background: url('<?=G5_IMG_URL?>/about/sec02_bg.png');}
    .sec_stars .star{position: absolute; opacity:.2}
    .sec_stars .star1{top: 47px; right: 151.999px; width: 85.003px;}
    .sec_stars .star2{top: 170.998px; left: 111.002px; width: 139.997px;}
    .sec_stars .star3{top: 348.997px; right: 110.002px; width: 85.003px;}
    .sec_stars .star4{top: 519.003px; right: 300.002px; width: 115.999px; opacity:0}
    .sec_stars .star5{bottom: 254.002px; left: 210.002px; width: 85.003px;}
    .sec_stars .star6{bottom: 72px; right: 249.998px; width: 85.003px;}
    .sec_stars[data-effect="show"] .star{animation:fadeout 2s forwards ease-in-out}
    .sec_stars[data-effect="show"] .star2{ animation-delay:.4s}
    .sec_stars[data-effect="show"] .star3{animation-delay:1.2s}
    .sec_stars[data-effect="show"] .star4{animation:blink 3s .4s infinite ease-in-out}
    .sec_stars[data-effect="show"] .star5{ animation-delay:.8s}
    .sec_stars[data-effect="show"] .star6{ animation-delay:1.6s}

    .sec_korean{position: relative; padding-top: 191px; background: url('<?=G5_IMG_URL?>/about/sec03_bg.png') no-repeat center top/100% auto; }
    .sec_korean .people{font-family:'GMarketSansMedium', sans-serif; font-size:28px; line-height: 39px; color:#fff; opacity:.13; text-align: center;}
    .sec_korean .wrap_num{position: relative; margin-top: 72px; padding: 10px 0 267px;}
    .sec_korean .wrap_num:after{content:''; position: absolute; left: 0; right: 0; bottom: 0px; height: 540px; background: url('<?=G5_IMG_URL?>/about/sec03_planet.png') no-repeat center bottom/100% auto; z-index: 1; filter:light}
    .sec_korean .num{font-family:'GMarketSans', sans-serif; font-size:261px; text-align: center; background: linear-gradient(180deg, #FFFFFF 7.79%, #4E6FDC 53.86%, #02001F 91.56%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; line-height: 263px;}
    .sec_korean .desc{ margin-top: 59px; font-size:30px; line-height: 72px; color:#fff; text-align: center;}
    .sec_korean .desc em{font-weight:500; font-size:55px; color:#fff;}

    .sec_bubble{margin-top: 320px;}

    .sec_sky{margin-top: 72px; background: url('<?=G5_IMG_URL?>/about/sec05_bg.png') no-repeat center top/100% auto; display: flex; flex-direction:column; padding-top: 541px;}
    .sec_sky p{font-size: 30px; line-height: 48px; background: linear-gradient(256.01deg, #FFFFFF 10.49%, #566774 91.28%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; text-shadow: 0px 0px 30px rgba(48, 101, 209, 0.5); }
    .sec_sky .txt01{padding-left: 150px; text-align: center; align-self: flex-start;}
    .sec_sky .txt02{margin-top: 402px; padding-right: 111px; text-align: center; align-self: flex-end;}
    .sec_sky .txt03{margin-top: 463px; padding-left: 106px; text-align: center; align-self: flex-start;}
    .sec_sky .txt04{margin-top: 412px; text-align: center; width: 100%; font-size:36px; line-height: 60px; font-weight:600; background: linear-gradient(183deg, #FFFFFF 10.49%, #94cfff 95.28%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; text-shadow: 0px 0px 30px rgba(48, 101, 209, 0.5); }
    .sec_sky p[data-effect="show"]{animation-name:fadein_left;}
    .sec_sky .txt02[data-effect="show"]{animation-name:fadein_right;}
    .sec_sky .txt04[data-effect="show"]{animation-name:fadein_bottom;}

    .sec_comet{margin: 327px auto 0; width: 155px; opacity:0}
    .sec_comet[data-effect="show"]{animation-name: fadein_top , blink; animation-duration: 1s, 3s; animation-delay: 0, 3s; animation-iteration-count: 1, infinite; animation-timing-function:ease-out}
</style>
<script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
<script>
  let lastScrollTop = 0;

    $(window).on('scroll', function () {
        const currentScrollTop = $(this).scrollTop();
        console.log(currentScrollTop)

        // 효과
        $('[data-effect]:not([data-effect="show"])').each(function () {
            const $this = $(this);
            const elementTop = $this.offset().top - 500;

            if (currentScrollTop >= elementTop) {
                $this.attr('data-effect', 'show');
            }
        });
        /*
        // GNB
        if (currentScrollTop <= 0) {
            $('#gnb').css('transform', 'translateY(0)');
        } else if (currentScrollTop > lastScrollTop) {
            $('#gnb').css('transform', 'translateY(100px)');
        } else if (currentScrollTop < lastScrollTop) {
            $('#gnb').css('transform', 'translateY(0)');
        }
            
        lastScrollTop = currentScrollTop;
        */

    });
</script>

<div class="container_sahan">
    <div class="sec_moon">
        <div class="moon">
            <img src="<?=G5_IMG_URL?>/about/sec01_moon.png" alt="">
        </div>
        <p class="since" data-effect="show">1982년, <br>첫 우주관광선 출범 이후 </p>
        <p class="total" data-effect> 통신이 끊긴 우주난민의 수는<br>전세계적으로 2200명에 달하며 </p>
    </div>
    <div class="sec_stars" data-effect>
        <div class="star star1"><img src="<?=G5_IMG_URL?>/about/sec02_star01.png" alt=""></div>
        <div class="star star2"><img src="<?=G5_IMG_URL?>/about/sec02_star02.png" alt=""></div>
        <div class="star star3"><img src="<?=G5_IMG_URL?>/about/sec02_star03.png" alt=""></div>
        <div class="star star4"><img src="<?=G5_IMG_URL?>/about/sec02_star04.png" alt=""></div>
        <div class="star star5"><img src="<?=G5_IMG_URL?>/about/sec02_star05.png" alt=""></div>
        <div class="star star6"><img src="<?=G5_IMG_URL?>/about/sec02_star06.png" alt=""></div>
    </div>

    <div class="sec_korean">
        <p class="people">Out of 2,200 people</p>
        <div class="wrap_num">
            <p class="num" data-effect>146</p>
        </div>

        <p class="desc" data-effect>
            그중 한국인은<br>
            <em>총 146명입니다.</em>
        </p>
    </div>

    <div class="sec_bubble">
        <img src="<?=G5_IMG_URL?>/about/sec04_bubble.png" alt="">
    </div>

    <div class="sec_sky">
        <p class="txt01" data-effect>그들이 <br>살아 있는지</p>
        <p class="txt02" data-effect>살아 있다면<br>무사한지</p>
        <p class="txt03" data-effect>언제쯤 지구로 <br>돌아올 수 있는지</p>
        <p class="txt04" data-effect>오로지 지구의 시간을 살아가는 <br>우리는 아무것도 알 수 없습니다.</p>
    </div>

    <div class="sec_comet" data-effect>
        <img src="<?=G5_IMG_URL?>/about/sec06_comet.png" alt="">
    </div>

    
</div>