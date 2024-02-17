<header class="header {{request()->routeIs('index') ? '' : 'not-home'}}">
    <div class="container header__container">
        <div class="header__body">
            <a href="{{route('index')}}" class="header__logo logo">
                <img src="{{asset('img/logo.svg')}}" alt="LOGO">
                <!-- <bold>TRADING REPS</bold> -->
            </a>
            <nav class="header__menu menu">
                <ul class="menu__list">
                    @foreach ($headerCategories as $cat)
                        <li>
                            <a href="{{route('categories.show', $cat)}}">
                                {{$cat->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="buttons-group">
                
            </div>
            <div class="header__burger">
                <span></span>
            </div>
        </div>
    </div>
</header>
