@extends('layouts.app_old')

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="blog-news first-section-padding">
                <div class="container blog-news__container">
                    <div class="blog-news__body">
                        <h2 class="section-title">Latest News</h2>
                        <div class="custom-row blog-news__row">
                            <x-posts.news :news="$latestNews[0]" />
                        </div>
                    </div>
                    <hr class="main-delimeter">
                    <div class="blog-news__body">
                        <h2 class="section-title">Latest Reviews</h2>
                        <div class="custom-row blog-news__row">
                            @foreach ($latestReviews as $post)
                                <article class="article-item preveiw">
                                    <a href="{{route('posts.show', $post)}}">
                                        <div class="article-item__img">
                                            <img src="{{$post->thumbnail->url}}" alt="{{ $post->thumbnail->alt }}" title="{{ $post->thumbnail->title }}">
                                        </div>
                                        <h3 class="article-item__title">{{$post->title}}</h3>
                                        <span class="article-item__date">{{$post->created_at->format('M d, Y')}}</span>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                    <hr class="main-delimeter">
                    <div class="blog-news__body">
                        <h2 class="section-title">More News</h2>
                        <div class="custom-row blog-news__row">
                            <x-posts.news :news="$latestNews[1]" />
                        </div>
                    </div>
                    <hr class="main-delimeter">
                    <div class="blog-news__body">
                        <h2 class="section-title">Latest Guides</h2>
                        <div class="custom-row blog-news__row">
                            @foreach ($latestGuides as $post)
                                <article class="article-item preveiw">
                                    <a href="{{route('posts.show', $post)}}">
                                        <div class="article-item__img">
                                            <img src="{{$post->thumbnail->url}}"  alt="{{ $post->thumbnail->alt }}" title="{{ $post->thumbnail->title }}">
                                        </div>
                                        <h3 class="article-item__title">{{$post->title}}</h3>
                                        <span class="article-item__date">{{$post->created_at->format('M d, Y')}}</span>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                    <hr class="main-delimeter">
                    <div class="blog-news__body">
                        <h2 class="section-title">More News</h2>
                        <div class="custom-row blog-news__row mb-20">
                            <x-posts.news :news="$latestNews[2]" />
                        </div>
                        <div class="align-center">
                            <button class="btn btn-sm btn-blue more-posts" data-category="news" data-page="3">Show more</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <x-footer />
    </div>
@endsection
