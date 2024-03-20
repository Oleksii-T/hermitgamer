@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        [$author->name]
    ];
@endphp

@section('title', $author->meta_title)

@section('description', $author->meta_description)

@section('content')
    <main class="main">
        <div class="main__wrapper">
            <div class="content">
                <section class="section author">
                    <div class="author__head">
                        <div class="image author__image">
                            <img src="{{$author->avatar->url}}" class="lazyload" alt="{{$author->avatar->alt}}" />
                        </div>
                        <div class="author__info">
                            <div class="author__inner">
                                <h1 class="author__name">
                                    {{$author->name}}
                                </h1>
                                <p class="author__desc">
                                    {{$author->title}}
                                </p>
                                <a href="mailto:{{$author->email}}" class="author__mail">
                                    {{$author->email}}
                                </a>
                            </div>
                            <ul class="socials author__socials">
                                @if ($author->instagram)
                                    <li>
                                        <a href="{{$author->instagram}}" target="_blank">
                                            <img src="{{asset('images/icons/instagram.svg')}}" alt="Instagram" title="instagram"/>
                                        </a>
                                    </li>
                                @endif
                                @if ($author->facebook)
                                    <li>
                                        <a href="{{$author->facebook}}" target="_blank">
                                            <img src="{{asset('images/icons/facebook.svg')}}" alt="Facebook" title="facebook"/>
                                        </a>
                                    </li>
                                @endif
                                @if ($author->twitter)
                                    <li>
                                        <a href="{{$author->twitter}}" target="_blank">
                                            <img src="{{asset('images/icons/twitter.svg')}}" alt="X (twitter)" title="X (twitter)"/>
                                        </a>
                                    </li>
                                @endif
                                @if ($author->linkedin)
                                    <li>
                                        <a href="{{$author->linkedin}}" target="_blank">
                                            <img src="{{asset('images/icons/linkedin.svg')}}" alt="linkedin" title="linkedin"/>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="author__text">
                        {!!$author->description!!}
                    </div>
                </section>
                @foreach ($author->paragraphs as $paragraph)
                    <section class="section article">
                        <h2><span>{{$paragraph->title}}</span></h2>
                        {!!$paragraph->text!!}
                    </section>
                @endforeach
                <section class="section category">
                    <h2><span>Latest Articles by Yaroslav</span></h2>
                    <x-post-cards :posts="$posts" />
                    <a
                        href="#"
                        class="button button-dark category__button show-more-posts"
                        >Show More</a
                    >
                </section>
            </div>
            <div class="sidebar">
                <x-side-search-block />
                <x-side-links-block />
            </div>
        </div>

        <x-go-to-top />
    </main>

    <x-page-bg />
@endsection

@section('scripts')
    
@endsection