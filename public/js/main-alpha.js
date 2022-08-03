$(document).ready(function () {
    var uaTwo = window.navigator.userAgent;
    var isIETwo = /MSIE|Trident/.test(uaTwo);

    if (isIETwo) {
        document.documentElement.classList.add('ie');
    }

    if (navigator.userAgent.indexOf('Safari') !== -1 &&
        navigator.userAgent.indexOf('Chrome') === -1) {
        $("body").addClass("safari");
    }

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.scroll_to_top').addClass('active');
        } else {
            $('.scroll_to_top').removeClass('active');
        }
    });

    $('.scroll_to_top').click(function () {
        $("html, body").animate({scrollTop: 0}, "slow");
        return false;
    });

    var galleryTop = new Swiper('.gallery-top', {
        slidesPerView: 1,  
        loop: true,
        loopedSlides: 50,
        centeredSlides: true,
        
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: ".swiper-pagination",
            type: "fraction",
        },
    });
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        direction: 'horizontal',
        slidesPerView: 5,
        slideToClickedSlide: true,
        spaceBetween: 18,
        loopedSlides: 50,
        centeredSlides: true,
        loop: true,
        breakpoints: {
            // when window width is >= 320px
            320: {
              slidesPerView: 1
            },
            // when window width is >= 480px
            480: {
              slidesPerView: 1.5
            },
            // when window width is >= 640px
            640: {
              slidesPerView: 3
            },
            978: {
                slidesPerView: 4
            },
            1200: {
                slidesPerView: 5
            }

        },
        navigation: {
            nextEl: '.thumb-button-next',
            prevEl: '.thumb-button-prev',
        },
    });
    galleryTop.controller.control = galleryThumbs;
    galleryThumbs.controller.control = galleryTop;
/*
    $(".account-sidebar li[rel]").click(function (ev) {
        ev.preventDefault();
        $(".tab-content").hide().removeClass("current");
        var activeTab = $(this).attr("rel");
        $("#" + activeTab)
          .fadeIn(200)
          .addClass("current");
      
        $(".account-sidebar li").removeClass("current");
        $(this).addClass("current");
    });
*/
    
    $(".account-sidebar2 li[rel]").click(function (ev) {
        ev.preventDefault();
        $(".tab-content2").hide().removeClass("current");
        var activeTab = $(this).attr("rel");
        $("#" + activeTab)
          .fadeIn(200)
          .addClass("current");
      
        $(".account-sidebar2 li").removeClass("current");
        $(this).addClass("current");
    });

    let open_payments = document.querySelector(".open-add-payments");
    if(open_payments)
    {
        open_payments.addEventListener("click", (ev) =>
        {
            ev.preventDefault();
            let block_payment1 = ev.target.parentElement.parentElement;
            block_payment1.classList.add("hidden-payment");

            let block_next = document.querySelector(".payment-methods-block2");
            block_next.classList.remove("hidden-payment");
        })

        let btn_exit = document.querySelector(".btn-exit");
        btn_exit.addEventListener("click", (ev) =>
        {
            ev.preventDefault();
            let block_payment2 = ev.target.parentElement.parentElement;
            block_payment2.classList.add("hidden-payment");

            let block_prev = document.querySelector(".payment-methods-block1");
            block_prev.classList.remove("hidden-payment");
        })
    }

    let lies = $(".account-sidebar1 li[rel]");
    let account_sidebar1 = document.querySelector(".account-sidebar1 ul");
    if(window.innerWidth <= 950){
        lies.click(function (ev) {
           
            account_sidebar1.style.display = "none";
            ev.preventDefault();
            let mobile_select = document.querySelector(".mobile-select-menu span");
            mobile_select.innerHTML = ev.target.innerHTML;
            
    
            $(".tab-content").hide().removeClass("current");
            var activeTab = $(this).attr("rel");
            $("#" + activeTab)
              .fadeIn(200)
              .addClass("current");
          
            $(".account-sidebar1 li").removeClass("current");
            $(this).addClass("current");
        });
    }else{
        lies.click(function (ev) {
        
        
            ev.preventDefault();
            let mobile_select = document.querySelector(".mobile-select-menu span");
            mobile_select.innerHTML = ev.target.innerHTML;
            
    
            $(".tab-content").hide().removeClass("current");
            var activeTab = $(this).attr("rel");
            $("#" + activeTab)
              .fadeIn(200)
              .addClass("current");
          
            $(".account-sidebar1 li").removeClass("current");
            $(this).addClass("current");
        });
    }
    


    
    let mobile_select = document.querySelector(".mobile-select-menu");
    if(mobile_select){
        mobile_select.addEventListener("click", (ev) =>
        {
            account_sidebar1.style.display = "block";
            let list = ev.target.parentElement.querySelector("ul");
            
            let image_arrow = ev.target.querySelector("img");

            image_arrow.classList.toggle("translate-arrow");
            list.classList.toggle("hidden-list");
           
        })
    }
    
});
