@extends('layouts.app')

@push('css')
    <style>
        .container {
            background-color: rgb(5,3,15);
            color: white;
            /* line-height: 12px; */
        }
        .container a{
            color: #6842FE;
        }
        .ws-pl {
            white-space: pre-line;
        }
        .section-title {
            color: white;
            font-size: 250%;
        }
        .post-menu {
            background-color: rgb(16,14,23);
            padding: 10px 15px;
            margin-bottom: 30px;
        }
        .post-menu p {
            color: rgb(112,106,133)
        }
        .post-menu a {
            color: white;
            text-decoration: none;
        }
        .post-menu a:hover {
            color: rgb(237,52,252);
        }
        .post-intro {
            white-space: pre-line;
        }
        .post-block {
            margin-bottom: 60px;
        }
        h2{
            font-size: 200%;
            color: white;
        }
        h3{
            font-size: 150%;
            color: white;
        }
        .post-block p{
            white-space: pre-line;
        }
        table{
        }
        table * {
            color: white;
            border-width: 0 0px !important;
        }
        table tr:first-child {
            background-color: rgb(15,15,23);
        }
        table tr:first-child td{
            color: #6E6B86;
        }
        .post-game-ad, .post-author, .post-conclusion, .post-faqs {
            margin-bottom: 60px;
        }
        .post-conclusion{
            border: 1.5px solid #6842FE;
            border-radius: 10px;
            padding: 22px 28px;
            box-shadow: 0 0 15px 0.1px #6842FE;
        }
        .post-conclusion p{
            white-space: pre-line;
        }
        .post-game-ad {
            color: #5F5D74;
        }
        .post-faq {
            background-color: rgb(15,15,23);
            border-radius: 10px;
            padding: 22px 28px;
            margin-bottom: 10px;
        }
        .faq-answer {
            color: #6E6B86;
            font-size: 90%;
        }
        .rel-post-img-wraper{
            display: block;
            overflow: hidden;
            border-radius: 10px;
            padding: 0px !important;
        }
        .rel-post-game{
            color: #E442FE !important;
            text-decoration: none;
            padding-bottom: 10px;
            display: block;
            font-size: 90%;
        }
        .rel-post-title{
            color: white !important;
            text-decoration: none;
            display: block;
        }
    </style>
@endpush

@section('content')
    <div class="wrapper_main pt-74">
        <main class="content">
            <section class="post-page">
                <div class="container post-page__container card">
                    <div class="post-page__body card-body">
                        <span class="post-page__data">
                            {{ $post->created_at->format('M d, Y') }}
                            <br>
                            Category: {{ $post->category->name }}
                            <br>
                            Game: {{ $post->game->name }}
                            <br>
                            Tags: {{ $post->tags->pluck('name')->implode(',') }}
                        </span>
                        <h2 class="section-title">
                            {{ $post->title }}
                        </h2>
                        <div class="post-page__img">
                            <img src="{{ $post->thumbnail->url }}" alt="{{ $post->thumbnail->alt }}" title="{{ $post->thumbnail->title }}">
                        </div>
                        <div class="post-menu">
                            <p>
                                Table of contents:
                            </p>
                            @foreach ($post->blocks as $block)
                                <a href="#{{$block->ident}}">{{$block->name}}</a>
                                <br>
                            @endforeach
                        </div>
                        <div class="post-intro">
                            {!!$post->intro!!}
                        </div>
                        <div class="post-content">
                            @foreach ($post->blocks->sortBy('order') as $block)
                                <div class="post-block" id="{{$block->ident}}">
                                    @foreach ($block->items->sortBy('order') as $item)
                                        @switch($item->type->value)
                                            @case(\App\Enums\BlockItemType::TITLE_H2->value)
                                                <h2>{{$item->value_simple}}</h2>
                                                @break
                                            @case(\App\Enums\BlockItemType::TITLE_H3->value)
                                                <h3>{{$item->value_simple}}</h3>
                                                @break
                                            @case(\App\Enums\BlockItemType::TITLE_H4->value)
                                                <h4>{{$item->value_simple}}</h4>
                                                @break
                                            @case(\App\Enums\BlockItemType::TEXT->value)
                                                <p>{!!$item->value_simple!!}</p>
                                                @break
                                            @case(\App\Enums\BlockItemType::IMAGE->value)
                                                <img src="{{$item->file()->url}}" alt="{{$item->file()->alt}}" title="{{$item->file()->title}}">
                                                @break
                                            @case('youtube')
                                                
                                                @break
                                            @case('slider')
                                                TODO
                                                @break
                                        @endswitch
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="post-conclusion">
                            <h3>Conclusion</h3>
                            <p>{!!$post->conclusion!!}</p>
                        </div>
                        <div class="post-faqs">
                            <h3>FAQ</h3>
                            @foreach ($post->faqs->sortBy('order') as $faq)
                                <div class="post-faq">
                                    <p>{{$faq->question}}</p>
                                    <div class="faq-answer">
                                        {!!$faq->answer!!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="post-game-ad">
                            Interested in some additional guides or help? Check out our <a href="{{route('games.show', $post->game)}}">{{$post->game->name}}</a> page for more useful tips and guides.
                        </div>
                        <div class="post-author">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{$post->author->avatar}}" alt="">
                                </div>
                                <div class="col-10">
                                    <p>
                                        {{$post->author->name}}
                                        <br>
                                        {{$post->author->title}}
                                    </p>
                                    <p>{{$post->author->description}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="post-related">
                            <h3>Related Articaled</h3>
                            <div class="row">
                                @foreach ($post->getRelatedPosts() as $relPost)
                                    <div class="col-6">
                                        <div class="row" style="align-items: center">
                                            <a href="{{route('posts.show', $relPost)}}" class="col-5 rel-post-img-wraper">
                                                <img src="{{$relPost->thumbnail->url}}" alt="">
                                            </a>
                                            <div class="col-7">
                                                <a href="{{route('games.show', $relPost->game)}}" class="rel-post-game">{{$relPost->game->name}}</a>
                                                <a href="{{route('posts.show', $relPost)}}" class="rel-post-title">{{$relPost->title}}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <x-footer />
    </div>
@endsection

