<header class="header {{request()->routeIs('index') ? '' : 'not-home'}}">
    <div class="container header__container">
        <div class="header__body">
            <a href="{{route('index')}}" class="header__logo logo">
                <img src="{{asset('img/logo.svg')}}" alt="LOGO">
                <!-- <bold>TRADING REPS</bold> -->
            </a>
            <nav class="header__menu menu">
                <ul class="menu__list">
                    <li>
                        <a href="#">
                            Features
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            How It Works
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            FAQ
                        </a>
                    </li>
                    @auth
                    <li>
                        <a href="#">
                            Subscriptions
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="#">
                            Sign Up
                        </a>
                    </li>
                    @endauth
                    <li>
                        <a href="#">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="buttons-group">
                @auth
                    <a href="#" class="btn btn-sm btn-white">
                        Account
                    </a>
                    <form action="#" method="post" id="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-blue">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="#" class="btn btn-sm btn-white">
                        Log In
                    </a>
                @endauth
            </div>
            <div class="header__burger">
                <span></span>
            </div>
        </div>
    </div>
</header>
