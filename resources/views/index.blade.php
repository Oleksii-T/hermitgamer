@extends('layouts.app')

@section('content')
    <section class="cover prime">
        <div class="background prime__background">
            <img src="{{asset('images/prime-bg.webp')}}" class="lazyload" alt="">
        </div>
        <div class="prime__info">
            <h1 class="prime__title">
                {{$page->show('header:title')}}
            </h1>
            <p class="prime__text">
                {{$page->show('header:text')}}
            </p>
            <p class="prime__desc">
                {{$page->show('header:sub-text')}}
            </p>
        </div>
        <ul class="prime__nav">
            <li>
                <a href="{{route('categories.show', 'reviews')}}" class="prime__nav-item">
                    <img src="{{asset('images/icons/prime-nav1.svg')}}" alt="">
                    <span>Games Review</span>
                </a>
            </li>
            <li>
                <a href="{{route('categories.show', 'guides')}}" class="prime__nav-item">
                    <img src="{{asset('images/icons/prime-nav2.svg')}}" alt="">
                    <span>Games Guides</span>
                </a>
            </li>
            <li>
                <a href="{{route('categories.show', 'top-lists')}}" class="prime__nav-item">
                    <img src="{{asset('images/icons/prime-nav3.svg')}}" alt="">
                    <span>Top Lists</span>
                </a>
            </li>
            <li>
                <a href="{{route('categories.show', 'mods')}}" class="prime__nav-item">
                    <img src="{{asset('images/icons/prime-nav4.svg')}}" alt="">
                    <span>Video Games Mods</span>
                </a>
            </li>
        </ul>
        <p class="prime__desc prime__desc--mob">
            {{$page->show('header:sub-text')}}
        </p>
    </section>

    <div class="content">
        <section class="section reviews">
            <h2><span>Video Games Reviews</span></h2>
            <p>We help players all over the world to choose the video game based on numerous criteria. With our
                own review and rating system, we use testing and reviewing games in different genres. Below you
                can check the latest reviews from our experts. You can also find more interesting reviews on the
                video games reviews page.</p>
            <ul class="reviews__list">
                @foreach ($latestReviews as $post)
                    <li>
                        <div class="reviews-item">
                            <a href="{{route('posts.show', $post)}}" class="image reviews-item__image">
                                <img src="{{$post->thumbnail->url}}" class="lazyload" alt="">
                            </a>
                            <div class="reviews-item__date">{{$post->created_at->format('M d, Y')}}</div>
                            <h3 class="reviews-item__title">
                                <a href="{{route('posts.show', $post)}}">{{$post->title}}</a>
                            </h3>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="reviews__wrap">
                <div class="reviews__inner">
                    <h2><span>Guides and Walkthroughs</span></h2>
                    <p>We check and use the most frequent requests of all players to create really necessary and
                        useful guides. If you are stuck at some point in the game, need help to collect some
                        items, or any other help in specific moments, you may find your answers on our page with
                        video game guides. Here are the examples of the latest guides from our team.</p>
                    <ul class="reviews__list">
                        @foreach ($latestGuides as $post)
                            <li>
                                <div class="reviews-item">
                                    <a href="{{route('posts.show', $post)}}" class="image reviews-item__image">
                                        <img src="{{$post->thumbnail->url}}" class="lazyload" alt="">
                                    </a>
                                    <div class="reviews-item__date">{{$post->created_at->format('M d, Y')}}</div>
                                    <h3 class="reviews-item__title">
                                        <a href="{{route('posts.show', $post)}}">{{$post->title}}</a>
                                    </h3>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="reviews__inner">
                    <h2><span>Ranked Lists</span></h2>
                    <p>Our team compares games in different categories to choose the best of them. Based on our
                        comparisons, we make ranked lists from games to make it easier for you to decide what to
                        play.</p>
                    <p>
                        Moreover, we make ranked lists with different characters, weapons, armor, or other
                        in-game items. Below you can check the examples of our latest ranked lists. Moreover,
                        you can find more on the video games lists page.
                    </p>
                    <ul class="reviews__list">
                        @foreach ($latestNews as $post)
                            <li>
                                <div class="reviews-item">
                                    <a href="{{route('posts.show', $post)}}" class="image reviews-item__image">
                                        <img src="{{$post->thumbnail->url}}" class="lazyload" alt="">
                                    </a>
                                    <div class="reviews-item__date">{{$post->created_at->format('M d, Y')}}</div>
                                    <h3 class="reviews-item__title">
                                        <a href="{{route('posts.show', $post)}}">{{$post->title}}</a>
                                    </h3>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </section>

        <section class="section reasons">
            <h2><span>Reasons to Trust Us</span></h2>
            <p>Neognosis Games was created by true gamers with one reason – to help other players find the
                required information and answers to any questions. We hope our expert reviews, guides, and game
                tips will help you make decisions and find answers.</p>
            <p>We have organized and structured the processes of game testing, reviewing, and quality control.
                We only write about games that we have played and know well. Moreover, all of our authors really
                love what they do.</p>
            <p>We try not to use any AI tools and write all the information by ourselves. We believe this will
                help make the information more accurate, useful, and complete.</p>
            <ul class="type-list reasons__list">
                <li class="type-item">
                    <div class="type-item__image">
                        <img src="{{asset('images/reasons1.svg')}}" alt="">
                    </div>
                    <div class="type-item__title">Players Oriented</div>
                    <p class="type-item__text ">We use all available tools and knowledge to provide the most
                        accurate and understandable information for players.</p>
                </li>
                <li class="type-item">
                    <div class="type-item__image">
                        <img src="{{asset('images/reasons2.svg')}}" alt="">
                    </div>
                    <div class="type-item__title">Clear Review Process</div>
                    <p class="type-item__text">We use our rating system and a 10-point rating scale to be as
                        objective as possible and not to mislead players.</p>
                </li>
                <li class="type-item">
                    <div class="type-item__image">
                        <img src="{{asset('images/reasons3.svg')}}" alt="">
                    </div>
                    <div class="type-item__title">Expert Writers</div>
                    <p class="type-item__text">We work only with experienced writers to provide high-quality
                        content. Read our guides to find recommendations from experts.</p>
                </li>
            </ul>
        </section>

        <section class="section about">
            <h2><span>About Our Team</span></h2>
            <p>Neognosis Games is a relatively new website about video games. Although our team is not big, we
                work hard to bring the most interesting content about video games. Moreover, we are constantly
                growing and believe that one day we will be one of the leading online resources in the industry.
                You can find more on the About Us page.</p>
            <p>As for the team, we are proud to have the best writers with a huge experience. You are guaranteed
                to get an expert’s advice on any of your searches regarding video games. So, meet our team:</p>
            <ul class="about__list">
                @foreach ($authors as $author)
                    <li>
                        <div class="about-item">
                            <a href="{{route('authors.show', $author)}}" class="about-item__image">
                                <img src="{{$author->avatar}}" class="lazyload" alt="">
                            </a>
                            <div class="about-item__desc">
                                <a href="{{route('authors.show', $author)}}" class="about-item__name">
                                    {{$author->name}}
                                </a>
                                <p class="about-item__text">{{$author->title}}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="section howto">
            <h2><span>How to Contact Us?</span></h2>
            <p>We value our readers and are always happy to communicate with our community. You can contact us
                directly using our message form on the Contact Us page. If you prefer to write an email, you can
                use the email of the Neognosis Games founder yarikmoklyak2010@gmail.com.</p>
            <p>We usually respond to all emails within several days (1 or 2). Sometimes it may take some more
                time, due to several reasons.</p>
        </section>
        <div class="back-top">
            <a href="#header" class="anchor-link back-top__button">
                <img src="{{asset('images/icons/back-top.svg')}}" alt="">
                Back to Top
            </a>
        </div>
    </div>
    <div class="page-bg">
        <img src="{{asset('images/pag-figure.svg')}}" alt="">
    </div>
@endsection