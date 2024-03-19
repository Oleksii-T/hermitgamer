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
                            <li>
                                <a href="#">
                                    <img src="{{asset('images/icons/instagram.svg')}}" alt="Instagram" title="instagram"/>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{asset('images/icons/facebook.svg')}}" alt="Facebook" title="facebook"/>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{asset('images/icons/twitter.svg')}}" alt="X (twitter)" title="X (twitter)"/>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{asset('images/icons/linkedin.svg')}}" alt="linkedin" title="linkedin"/>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="author__text">
                    {!!$author->description!!}
                </div>
            </section>
            <section class="section article">
                <h2><span>Yaroslav's Favorite Games</span></h2>
                <p>
                    It’s hard to name a specific genre of games that
                    I like. Mostly I appreciate games for their
                    story, well-developed characters, or general
                    atmosphere.
                </p>
                <p>
                    I really like action-adventure games such as
                    Skyrim, Horizon Zero Dawn, Far Cry series, God
                    of War, and some other titles.
                </p>
                <p>
                    It’s hard to name a specific genre of games that
                    I like. Mostly I appreciate games for their
                    story, well-developed characters, or general
                    atmosphere.
                </p>
                <p>
                    I really like action-adventure games such as
                    Skyrim, Horizon Zero Dawn, Far Cry series, God
                    of War, and some other titles.
                </p>
            </section>
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
@endsection

@section('scripts')
    
@endsection
