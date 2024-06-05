document.addEventListener('DOMContentLoaded', function () {

    /**show more */
    // const showMoreBtn = document.querySelectorAll('.show-more--js');

    // if(showMoreBtn) {
    // 	showMoreBtn.forEach(element => {
    // 		element.addEventListener('click',function() {
    // 			this.parentNode.classList.toggle('active');
    // 			this.classList.toggle('active');
    // 		});
    // 	});
    // }

    /** Відео **/

    function findVideos() {
        let videos = document.querySelectorAll('.video');

        for (let i = 0; i < videos.length; i++) {
            setupVideo(videos[i]);
        }
    }

    function setupVideo(video) {
        let link = video.querySelector('.video__link');
        let media = video.querySelector('.video__media');
        let button = video.querySelector('.video__button');
        let id = parseMediaURL(media);

        video.addEventListener('click', () => {
            let iframe = createIframe(id);

            link.remove();
            button.remove();
            video.appendChild(iframe);
        });

        link.removeAttribute('href');
        video.classList.add('video--enabled');
    }

    function parseMediaURL(media) {
        let regexp = /https:\/\/i\.ytimg\.com\/vi\/([a-zA-Z0-9_-]+)\/maxresdefault\.jpg/i;
        let url = media.src;
        let match = url.match(regexp);

        return match[1];
    }

    function createIframe(id) {
        let iframe = document.createElement('iframe');

        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('allow', 'autoplay');
        iframe.setAttribute('src', generateURL(id));
        iframe.classList.add('video__media');

        return iframe;
    }

    function generateURL(id) {
        let query = '?rel=0&showinfo=0&autoplay=1';

        return 'https://www.youtube.com/embed/' + id + query;
    }

    findVideos();


    /**mobile menu */
    const mobBtn = document.querySelector('.js-menu'),
        mobMenu = document.querySelector('.header__menu'),
        body = document.querySelector('body');

    mobBtn.addEventListener('click', () => {
        mobMenu.classList.toggle('active');
        mobBtn.classList.toggle('active');
        body.classList.toggle('active');
    });



    /***search modal */
    const searchBtn = document.querySelector('.header__search-button'),
        searchBlock = document.querySelector('.header__search'),
        searchBtnClose = document.querySelector('.header__search-closeBtn');

    searchBtn.addEventListener('click', () => {
        searchBlock.classList.add('active');
    });
    searchBtnClose.addEventListener('click', () => {
        searchBlock.classList.remove('active');
    });


    window.onclick = function (event) {
        if (event.target == searchBlock) {
            searchBlock.classList.remove('active');
        }
    };

    /* anchor**/
    const links = document.querySelectorAll(".anchor-link");

    for (const link of links) {
        link.addEventListener("click", clickHandler);
    };

    function clickHandler(e) {
        e.preventDefault();
        const href = this.getAttribute("href").split("#");
        const offsetTop = document.getElementById(href[1]).getBoundingClientRect().top + document.documentElement.scrollTop - 20;
        scroll({
            top: offsetTop,
            behavior: "smooth"
        });
    };


    /**sidebar links */

    const menuButtons = document.querySelectorAll('.links__menu-button');
    const subMenuItem = document.querySelectorAll('.links__submenu-item');
    const subMenuWrap = document.querySelector('.links__submenu');
    const menuList = document.querySelector('.links__menu');
    const submenuButtons = document.querySelectorAll('.links__submenu-button');

    menuButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetSubmenu = document.getElementById(targetId);

            subMenuWrap.classList.add('opened');

            subMenuItem.forEach(submenu => {
                if (submenu.id !== targetId) {
                    submenu.classList.remove('open');
                }
            });

            targetSubmenu.classList.toggle('open');
            menuList.classList.toggle('opened');
        });
    });

    submenuButtons.forEach(button => {
        button.addEventListener('click', function () {
            const submenu = this.closest('.links__submenu');
            submenu.classList.remove('open');
            menuList.classList.remove('opened');
            subMenuWrap.classList.remove('opened');
            setTimeout
            subMenuItem.forEach(item => {
                setTimeout(function () {
                    item.classList.remove('open');
                }, 200);

            });
        });
    });


    const linksMobBtn = document.querySelector('.links__button-toggle'),
        linksMobWrap = document.querySelector('.links__wrapper'),
        linksMobBtnClose = document.querySelector('.links__button-close');

    if (linksMobBtn) {
        linksMobBtn.addEventListener('click', () => {
            linksMobWrap.classList.add('active');
            body.classList.add('active');
        });
    }
    if (linksMobBtnClose) {
        linksMobBtnClose.addEventListener('click', () => {
            linksMobWrap.classList.remove('active');
            body.classList.remove('active');
        });
    }

    /**accordion */
    expanderList = document.querySelectorAll('.js-button-expander');

    $('.js-button-expander').click(function (e) {
        var expandParent = $(this).parent();
        var expandTarget = $(expandParent).children('.js-expand-content');

        for (var i = 0; i < expanderList.length; i++) {
            if (expanderList[i] == this) {
                for (var j = 0; j < expandTarget.length; j++) {
                    if ($(expandTarget[j]).hasClass('expanded')) {
                        $(expandParent).removeClass('active');
                        $(expandTarget[j]).removeClass('expanded');
                        $(expandTarget[j]).slideUp();
                    } else {
                        $(expandParent).addClass('active');
                        $(expandTarget[j]).addClass('expanded');
                        $(expandTarget[j]).slideDown();
                    }
                }
            } else {
                var expanderListParent = $(expanderList[i]).parent();
                var expanderListTarget = $(expanderListParent).children('.js-expand-content');

                if ($(expanderListTarget).hasClass('expanded') && $(expanderListParent).hasClass('active')) {
                    $(expanderListParent).removeClass('active');
                    $(expanderListTarget).removeClass('expanded');
                    $(expanderListTarget).slideUp();
                }
            }
        }
    });


    if ($(window).width() <= 1140) {
        $(".sidebar__nav-button").click(function () {
            $(".sidebar__nav-list").slideToggle(500);
            $(this).toggleClass('active');
        });
        $(".sidebar__details-button").click(function () {
            $(".sidebar__details-list").slideToggle(500);
            $(this).toggleClass('active');
        });
    }

    if ($('.screens-slider').length) {
        $('.screens-slider').slick({
            infinite: false,
            lazyLoad: 'ondemand',
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: true,
            speed: 800,
            responsive: [
                {
                    breakpoint: 799,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                    }
                },

            ]
        });
    }
});
