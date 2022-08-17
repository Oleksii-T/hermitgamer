@extends('layouts.app')

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="post-page">
                <div class="container post-page__container">
                    <div class="post-page__body">
                        <span class="post-page__data">
                            {{$post->created_at->format('M d, Y')}}
                            <br>
                            Category: {{$post->category->name}}
                            <br>
                            Game: {{$post->game->name}}
                            <br>
                            Tags: {{$post->tags->pluck('name')->implode(',')}}
                        </span>
                        <h2 class="section-title">
                            {{$post->title}}
                        </h2>
                        <div class="post-page__img">
                            <img src="{{$post->thumbnail->url}}" alt="">
                        </div>
                        <div class="text">
                            <p>{!!$post->content!!}<br></p>
                        </div>

                        Images:
                        <div class="slider">
                            @foreach ($post->images as $image)
                                <img src="{{$image->url}}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <x-footer />
    </div>
@endsection
