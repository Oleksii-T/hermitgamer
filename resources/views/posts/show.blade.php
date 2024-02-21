@extends('layouts.app')

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
                            @foreach ($post->blocks as $block)
                                <a href="#{{$block->ident}}">{{$block->name}}</a>
                            @endforeach
                        </div>
                        <div class="post-content">
                            @foreach ($post->blocks as $block)
                                <div id="{{$block->ident}}">
                                    @foreach ($block->items as $item)
                                        @switch($item->type)
                                            @case('title')
                                                <h2>{{$item->title}}</h2>
                                                @break
                                            @case('text')
                                                <p>{!!$item->text!!}</p>
                                                @break
                                            @case('image')
                                                <img src="{{$item->file()->url}}" alt="{{$item->file()->alt}}" title="{{$item->file()->title}}">
                                                @break
                                            @case('video')
                                                <video src="{{$item->file()->url}}"></video>
                                                @break
                                            @case('slider')
                                                TODO
                                                @break
                                        @endswitch
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        {{-- <div class="text">
                            <p style="white-space: pre-line">{!! $post->content !!}<br></p>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <a>
                                    <i class="fas fa-thumbs-up text-primary"></i>
                                    <span class="likes-label">124</span>
                                </a>
                            </div>
                            <div>
                                <a class="text-muted"> 8 comments </a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between text-center border-top border-bottom mb-4">
                            <button type="button" class="btn btn-link btn-lg make-like" data-mdb-ripple-color="dark">
                                <i class="fas fa-thumbs-up me-2"></i>Like
                            </button>
                            <button type="button" class="btn btn-link btn-lg" data-mdb-ripple-color="dark">
                                <i class="fas fa-comment-alt me-2"></i>Comment
                            </button>
                            <button type="button" class="btn btn-link btn-lg" data-mdb-ripple-color="dark">
                                <i class="fas fa-share me-2"></i>Share
                            </button>
                        </div>

                        <div class="d-flex mb-3">
                            <a href="">
                                <img src="{{asset('img/avatar.jpeg')}}" class="border rounded-circle me-2"
                                    alt="Avatar" style="height: 40px" />
                            </a>
                            <div class="form-outline w-100">
                                <textarea class="form-control" id="textAreaExample" rows="2"></textarea>
                                <label class="form-label" for="textAreaExample">Write a comment</label>
                            </div>
                        </div>

                        @foreach ([1] as $comment)
                            <div class="d-flex mb-3">
                                <a href="">
                                    <img src="{{asset('img/avatar.jpeg')}}" class="border rounded-circle me-2"
                                        alt="Avatar" style="height: 40px" />
                                </a>
                                <div>
                                    <div class="bg-light rounded-3 px-3 py-1">
                                        <a href="" class="text-dark mb-0">
                                            <strong>Malcolm Dosh</strong>
                                        </a>
                                        <a href="" class="text-muted d-block">
                                            <small>Lorem ipsum dolor sit amet consectetur,
                                                adipisicing elit. Natus, aspernatur!</small>
                                        </a>
                                    </div>
                                    <a href="" class="text-muted small ms-3 me-2"><strong>Like</strong></a>
                                    <a href="" class="text-muted small me-2"><strong>Reply</strong></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>

        <x-footer />
    </div>
@endsection

