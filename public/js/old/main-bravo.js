$(document).ready(function ($) {
    $(window).on('scroll load',function() {
        if($(window).scrollTop() > 1) {
            $('.header').addClass('fixed');
        } else {
            $('.header').removeClass('fixed');
        }
    })

    $('.header__burger').click(function(){
        $('.header__burger, .header__menu').toggleClass('active'); 
        $('body').toggleClass('lock');       
    });

    // acordeon =====================================================
    $('.accordion-list > li > .answer').hide();
    
    $('.accordion-list > li').click(function() {
      if ($(this).hasClass("active")) {
        $(this).removeClass("active").find(".answer").slideUp();
      } else {
        $(".accordion-list > li.active .answer").slideUp();
        $(".accordion-list > li.active").removeClass("active");
        $(this).addClass("active").find(".answer").slideDown();
      }
      return false;
    });
});
