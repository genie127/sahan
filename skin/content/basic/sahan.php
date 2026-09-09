<style>

    @keyframes fadein_top{
        0%{transform:translateY(-150px)}
        100%{transform:translateY(0px)}
    }
    @keyframes fadein_bottom{
        0%{opacity:0; transform:translateY(150px)}
        100%{opacity:1; transform:translateY(0px)}
    }

    @keyframes fadeout{
        0%{opacity:.2}
        50%{opacity:1}
        100%{opacity:0}
    }
    @keyframes blink{
        0%{opacity:0}
        50%{opacity:1}
        100%{opacity:0}
    }

    body{padding-top: 0;}
    #hd{display: none;}
    #container{margin: 0; padding: 0;}
    #gnb{transition:.3s}

    p{opacity:0;}
    p[data-effect="show"]{animation:fadein_bottom 1.2s forwards}
    
    .container_sahan{background: #111; min-height:200vh}
    .container_sahan *{box-sizing:border-box; font-family:'Pretendard', sans-serif; letter-spacing: -0.025em; }
    .container_sahan img{width: 100%;}

    .sec_moon{position: relative;}
    .sec_moon:after{content:''; position: absolute; top: 0; left: 0; right: 0; height: 158.472vw; background: url('<?=G5_IMG_URL?>/about/sec01_star.png') no-repeat center top/100% auto; mix-blend-mode:soft-light}
    .sec_moon .moon{animation:fadein_top 2s forwards linear}
    .sec_moon .since{margin-top: 10vw; font-size:4.167vw; line-height: 6.667vw; color:#fff; text-align: center; animation-delay:.4s}
    .sec_moon .total{margin-top: 39.444vw; background: linear-gradient(256.01deg, #FFFFFF 10.49%, #566774 91.28%);-webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; font-size:5vw; line-height: 8.333vw; text-align: center;}

    .sec_stars{margin-top: 40.278vw; position: relative; height: 144.028vw;}
    .sec_stars .star{position: absolute; opacity:.2}
    .sec_stars .star1{top: 0; right: 21.111vw; width: 11.806vw;}
    .sec_stars .star2{top: 17.222vw; left: 15.417vw; width: 19.444vw;}
    .sec_stars .star3{top: 41.944vw; right: 15.278vw; width: 11.806vw;}
    .sec_stars .star4{top: 65.556vw; right: 41.667vw; width: 16.111vw; opacity:0}
    .sec_stars .star5{bottom: 25.278vw; left: 29.167vw; width: 11.806vw;}
    .sec_stars .star6{bottom: 0; right: 34.722vw; width: 11.806vw;}
    .sec_stars[data-effect="show"] .star{animation:fadeout 2s forwards ease-in-out}
    .sec_stars[data-effect="show"] .star2{ animation-delay:.4s}
    .sec_stars[data-effect="show"] .star3{animation-delay:1.2s}
    .sec_stars[data-effect="show"] .star4{animation:blink 3s .4s infinite ease-in-out}
    .sec_stars[data-effect="show"] .star5{ animation-delay:.8s}
    .sec_stars[data-effect="show"] .star6{ animation-delay:1.6s}
</style>

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

        // GNB
        if (currentScrollTop <= 0) {
            $('#gnb').css('transform', 'translateY(0)');
        } else if (currentScrollTop > lastScrollTop) {
            $('#gnb').css('transform', 'translateY(100px)');
        } else if (currentScrollTop < lastScrollTop) {
            $('#gnb').css('transform', 'translateY(0)');
        }

        lastScrollTop = currentScrollTop;
    });
</script>

<div class="container_sahan">
    <div class="sec_moon">
        <div class="moon">
            <img src="<?=G5_IMG_URL?>/about/sec01_moon.png" alt="">
        </div>
        <p class="since" data-effect="show">1982년, <br>첫 우주관광선 출범 이후 </p>
        <p class="total" data-effect> 통신이 끊긴 우주난민의 수는<br>전세계적으로 2200명에 달하며 </p>
    </div>
    <div class="sec_stars" data-effect>
        <div class="star star1"><img src="<?=G5_IMG_URL?>/about/sec02_star01.png" alt=""></div>
        <div class="star star2"><img src="<?=G5_IMG_URL?>/about/sec02_star02.png" alt=""></div>
        <div class="star star3"><img src="<?=G5_IMG_URL?>/about/sec02_star03.png" alt=""></div>
        <div class="star star4"><img src="<?=G5_IMG_URL?>/about/sec02_star04.png" alt=""></div>
        <div class="star star5"><img src="<?=G5_IMG_URL?>/about/sec02_star05.png" alt=""></div>
        <div class="star star6"><img src="<?=G5_IMG_URL?>/about/sec02_star06.png" alt=""></div>
    </div>
    
</div>