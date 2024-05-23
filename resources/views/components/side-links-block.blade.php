<div class="links sidebar__links">
    <button class="links__button-toggle">
        Useful Links
        <img
            src="{{asset('images/icons/links-arrow-white.svg')}}"
            alt="Arrow icon"
            title="Arrow icon"
        />
    </button>
    <div class="links__wrapper">
        <div class="links__menu">
            <div class="links__desc">
                <button class="links__button-close">
                    <img
                        src="{{asset('images/icons/close.svg')}}"
                        alt="Clsoe icon"
                        title="Clsoe icon"
                    />
                </button>
                <div class="links__desc-caption">
                    USEFUL LINKS
                </div>
            </div>
            <ul class="links__list links__menu-list">
                <li>
                    <a href="{{route('index')}}">Home</a>
                </li>
                <li><a href="{{route('contact-us')}}">Contact Us</a></li>
                <li><a href="{{route('terms')}}">Terms</a></li>
                <li><a href="{{route('privacy')}}">Privacy Privacy</a></li>
                <li><a href="{{route('about-us')}}">About Us</a></li>
                <li><a href="{{route('rate')}}">Review Policy</a></li>
            </ul>
        </div>
    </div>
</div>
