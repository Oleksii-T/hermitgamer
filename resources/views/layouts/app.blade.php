<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>@yield('title', $page->meta_title)</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="og:image" content="{{asset('images/image.jpg')}}">
    <meta property="description" content="@yield('description', $page->meta_description)">
    <link rel="shortcut icon" href="{{asset('images/favicon/favicon.png')}}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{asset('images/favicon/apple-touch-icon.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('images/favicon/apple-touch-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('images/favicon/apple-touch-icon-114x114.png')}}">

    <meta name="theme-color" content="rgb(4, 3, 15)" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="rgb(4, 3, 15)" media="(prefers-color-scheme: dark)" />

    <link rel="stylesheet" href="{{asset('css/slick.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom-swal.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
</head>

<body>
    @if ($currentUser)
        @php
            $editUrl = match (Route::currentRouteName()) {
                'games.show' => route('admin.games.edit', $game),
                'posts.show' => route('admin.posts.edit', $post),
                'categories.show' => route('admin.categories.edit', $category),
                'authors.show' => route('admin.authors.edit', $author),
                default => null
            };
        @endphp
        <div class="admin-header">
            <div class="admin-header-item">
                <a href="{{route('admin.index')}}">
                    {{config('app.name')}} Admin
                </a>
            </div>
            @if ($editUrl)
                <div class="admin-header-item">
                    <a href="{{$editUrl}}">Edit</a>
                </div>
            @endif
        </div>
    @endif
    <header class="header" id="header">
        <a class="header__logo" href="{{route('index')}}">
            <img src="{{asset('images/logo.png')}}" alt="HermitGamer" title="HermitGamer">
        </a>
        <button class="header__button-menu js-menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="header__menu">
            <div class="header__search">
                <form action="{{route('search')}}" class="header__search-dialog">
                    <div class="header__search-closeBtn"><img src="{{asset('images/icons/close.svg')}}" alt=""></div>
                    <div class="header__search-title">Search</div>
                    <p class="header__search-text">Start typing to search for a specific article on our website</p>
                    <div class="header__search-field">
                        <input type="text" name="search" class="header__search-input" placeholder="Search for something...">
                    </div>
                </form>
            </div>
            <ul class="header__menu-list">
                @foreach (\App\Models\Category::forHeader() as $category)
                    <li>
                        <a href="{{route('categories.show', $category)}}">{{$category->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="header__menu-info">
                <ul class="socials header__menu-socials">
                    <li>
                        <a href="#"><img src="{{asset('images/icons/facebook.svg')}}" alt="Facebook" title="facebook"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{asset('images/icons/instagram.svg')}}" alt="Instagram" title="instagram"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{asset('images/icons/twitter.svg')}}" alt="X (twitter)" title="X (twitter)"></a>
                    </li>
                </ul>
                <div class="header__menu-copy">2024 © hermitgamer.com. All Rights Reserved</div>
            </div>
        </nav>
        <button type="button" class="header__search-button"><img src="{{asset('images/icons/search-white.svg')}}" alt=""></button>
    </header>
    @if ($bcs??false)
        <ul class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
            @foreach ($bcs as $i => $bc)
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" @if($bc[1]??false) href="{{$bc[1]}}" @endif>
                        <span itemprop="name">{{$bc[0]}}</span>
                    </a>
                    <meta itemprop="position" content="{{$i}}" />
                </li>
            @endforeach
        </ul>
    @endif
    <div class="page {{$pageClass??''}}">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="footer__content">
            <div class="footer__info">
                <div class="footer__logo"><img src="{{asset('images/logo.png')}}" alt="HermitGamer" title="HermitGamer"></div>
                <p class="footer__text">HermitGamer is the world’s leading independent online gaming authority,
                    providing trusted video games reviews and guides.</p>
                <ul class="socials footer__socials">
                    <li>
                        <a href="#"><img src="{{asset('images/icons/facebook.svg')}}" alt="Facebook" title="facebook"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{asset('images/icons/instagram.svg')}}" alt="Instagram" title="instagram"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{asset('images/icons/twitter.svg')}}" alt="X (twitter)" title="X (twitter)"></a>
                    </li>
                </ul>
            </div>
            <div class="footer__menu">
                <div class="footer__menu-item">
                    <p>HELPFUL LINKS</p>
                    <ul>
                        <li>
                            <a href="{{route('about-us')}}">About Us</a>
                        </li>
                        <li>
                            <a href="{{route('contact-us')}}">Contact Us</a>
                        </li>
                        <li>
                            <a href="{{route('rate')}}">How We Rate</a>
                        </li>
                    </ul>
                </div>
                <div class="footer__menu-item">
                    <p>Policy Links</p>
                    <ul>
                        <li>
                            <a href="{{route('privacy')}}">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="{{route('terms')}}">Terms & Conditions</a>
                        </li>
                    </ul>
                </div>
                <div class="footer__menu-item">
                    <p>Explore</p>
                    <ul>
                        <li>
                            <a href="{{route('categories.show', 'reviews')}}">Reviews</a>
                        </li>
                        <li>
                            <a href="{{route('categories.show', 'cheats')}}">Cheats</a>
                        </li>
                        <li>
                            <a href="{{route('categories.show', 'guides')}}">Guides</a>
                        </li>
                        <li>
                            <a href="{{route('categories.show', 'mods')}}">Mods</a>
                        </li>
                        <li>
                            <a href="{{route('categories.show', 'top-lists')}}">Top Lists</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer__copy">
            {{date('Y')}} © hermitgamer.com. All Rights Reserved
        </div>
    </footer>
</body>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/lazysizes.min.js')}}"></script>
<script src="{{asset('js/slick.min.js')}}"></script>
<script src="{{asset('js/scripts.js')}}"></script>
<script src="{{asset('js/custom.js')}}?v={{time()}}"></script>

<script type="text/javascript">
    window.Laravel = {!!$LaravelDataForJS!!};
    console.log(`window.Laravel`, window.Laravel); //! LOG
</script>

@yield('scripts')

</html>
