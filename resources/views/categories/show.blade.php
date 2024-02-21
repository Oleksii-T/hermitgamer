@extends('layouts.app')

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="blog-news first-section-padding">
                <div class="container blog-news__container">
                    <div class="blog-news__body">
                        <h2 class="section-title">{{$category->name}}</h2>
                        <div class="custom-row blog-news__row mb-20">
                            @foreach ($posts as $post)
                                <article class="article-item preveiw">
                                    <a href="{{route('posts.show', $post)}}">
                                        <div class="article-item__img">
                                            <img src="{{$post->thumbnail->url}}" alt="">
                                        </div>
                                        <h3 class="article-item__title">{{$post->title}}</h3>
                                        <span class="article-item__date">{{$post->created_at->format('M d, Y')}}</span>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                        <div class="align-center">
                            <button class="btn btn-sm btn-blue more-posts" data-category="news" data-page="1">Show more</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <x-footer />
    </div>
@endsection
