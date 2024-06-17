@extends('layouts.app')

@php
    $pageClass = 'home-page';
@endphp

@section('content')
    <main class="main">
        <section class="cover prime">
            <div class="background prime__background">
                <img src="{{asset('images/prime-bg.webp')}}" class="lazyload" alt="Main background" title="Main background">
            </div>
            <div class="prime__info">
                <h1 class="prime__title">
                    {{$page->show('header:title')}}
                </h1>
                <p class="prime__text">{!!$page->show('header:text')!!}</p>
                <p class="prime__desc">
                    {{$page->show('header:sub-text')}}
                </p>
            </div>
            <ul class="prime__nav">
                <li>
                    <a href="{{route('categories.show', 'reviews')}}" class="prime__nav-item">
                        <img src="{{asset('images/icons/prime-nav1.svg')}}" alt="Games Review icon" title="Games Review icon">
                        <span>Games Review</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('categories.show', 'guides')}}" class="prime__nav-item">
                        <img src="{{asset('images/icons/prime-nav2.svg')}}" alt="Games Guides icon" title="Games Guides icon">
                        <span>Games Guides</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('categories.show', 'lists')}}" class="prime__nav-item">
                        <img src="{{asset('images/icons/prime-nav3.svg')}}" alt="Top Lists icon" title="Top Lists icon">
                        <span>Top Lists</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('categories.show', 'mods')}}" class="prime__nav-item">
                        <img src="{{asset('images/icons/prime-nav4.svg')}}" alt="Video Games Mods icon" title="Video Games Mods icon">
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
                @if ($latestNews->isNotEmpty())
                    <h2><span>{{$page->show('news:title')}}</span></h2>
                    {!!$page->show('news:text')!!}
                    <ul class="reviews__list">
                        @foreach ($latestNews as $post)
                            <li>
                                <div class="reviews-item">
                                    <a href="{{route('posts.show', $post)}}" class="image reviews-item__image">
                                        <img src="{{$post->thumbnail()->url}}" class="lazyload" alt="{{$post->thumbnail()->alt}}" title="{{$post->thumbnail()->title}}">
                                    </a>
                                    <div class="reviews-item__date">{{$post->created_at->format('M d, Y')}}</div>
                                    <h3 class="reviews-item__title">
                                        <a href="{{route('posts.show', $post)}}">{{$post->title}}</a>
                                    </h3>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <h2><span>{{$page->show('reviews:title')}}</span></h2>
                {!!$page->show('reviews:text')!!}
                <ul class="reviews__list">
                    @foreach ($latestReviews as $post)
                        <li>
                            <div class="reviews-item">
                                <a href="{{route('posts.show', $post)}}" class="image reviews-item__image">
                                    <img src="{{$post->thumbnail()->url}}" class="lazyload" alt="{{$post->thumbnail()->alt}}" title="{{$post->thumbnail()->title}}">
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
                        <h2><span>{{$page->show('guides:title')}}</span></h2>
                        <div class="reviews__inner-text">
                            {!!$page->show('guides:text')!!}
                        </div>
                        <ul class="reviews__list">
                            @foreach ($latestGuides as $post)
                                <li>
                                    <div class="reviews-item">
                                        <a href="{{route('posts.show', $post)}}" class="image reviews-item__image">
                                            <img src="{{$post->thumbnail()->url}}" class="lazyload" alt="{{$post->thumbnail()->alt}}" title="{{$post->thumbnail()->title}}">
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
                        <h2><span>{{$page->show('top-lists:title')}}</span></h2>
                        <div class="reviews__inner-text">
                            {!!$page->show('top-lists:text')!!}
                        </div>
                        <ul class="reviews__list">
                            @foreach ($latestLists as $post)
                                <li>
                                    <div class="reviews-item">
                                        <a href="{{route('posts.show', $post)}}" class="image reviews-item__image">
                                            <img src="{{$post->thumbnail()->url}}" class="lazyload" alt="{{$post->thumbnail()->alt}}" title="{{$post->thumbnail()->title}}">
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
                <h2><span>{{$page->show('reasons:title')}}</span></h2>
                {!!$page->show('reasons:text')!!}
                <ul class="type-list reasons__list">
                    <li class="type-item">
                        <div class="type-item__image">
                            <img src="{{asset('images/reasons1.svg')}}" alt="People icon" title="People icon">
                        </div>
                        <div class="type-item__title">{{$page->show('reasons:block-1-title')}}</div>
                        <p class="type-item__text ">{{$page->show('reasons:block-1-text')}}</p>
                    </li>
                    <li class="type-item">
                        <div class="type-item__image">
                            <img src="{{asset('images/reasons2.svg')}}" alt="Community" title="Community">
                        </div>
                        <div class="type-item__title">{{$page->show('reasons:block-2-title')}}</div>
                        <p class="type-item__text ">{{$page->show('reasons:block-2-text')}}</p>
                    </li>
                    <li class="type-item">
                        <div class="type-item__image">
                            <img src="{{asset('images/reasons3.svg')}}" alt="Experienced Specialists" title="Experienced Specialists">
                        </div>
                        <div class="type-item__title">{{$page->show('reasons:block-3-title')}}</div>
                        <p class="type-item__text ">{{$page->show('reasons:block-3-text')}}</p>
                    </li>
                </ul>
            </section>

            <section class="section about">
                <h2><span>{{$page->show('team:title')}}</span></h2>
                {!!$page->show('team:text')!!}
                <ul class="about__list">
                    @foreach ($authors as $author)
                        <li>
                            <div class="about-item">
                                <a href="{{route('authors.show', $author)}}" class="about-item__image">
                                    <img src="{{$author->avatar()->url}}" class="lazyload" alt="{{$author->avatar()->alt}}" title="{{$author->avatar()->title}}">
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

            <section class="section howto pb-0">
                <h2><span>{{$page->show('contact-us:title')}}</span></h2>
                {!!$page->show('contact-us:text')!!}
            </section>

            <x-go-to-top />
        </div>

        <x-page-bg />
    </main>
@endsection
