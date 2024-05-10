@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        [$page->show('top:title')]
    ];
@endphp

@section('content')
    <main class="main">
        <div class="main__wrapper">
            <div class="content">
                <section class="section section-head">
                    <h1>{{$page->show('top:title')}}</h1>
                    {!!$page->show('top:text')!!}
                </section>
                <section class="section article">
                    <h2><span>{{$page->show('team:title')}}</span></h2>
                    {!!$page->show('team:text')!!}
                </section>
                <x-our-mission :page="$page" />
                <section class="section principles">
                    <h2><span>{{$page->show('principles:title')}}</span></h2>
                    {!!$page->show('principles:text')!!}
                    <div class="principles__wrap">
                        <div class="principles__item">
                            {!!$page->show('principles:block-1-content')!!}
                        </div>
                        <div class="principles__item">
                            {!!$page->show('principles:block-2-content')!!}
                        </div>
                        <div class="principles__item">
                            {!!$page->show('principles:block-3-content')!!}
                        </div>
                        <div class="principles__item">
                            {!!$page->show('principles:block-4-content')!!}
                        </div>
                    </div>
                </section>
                <section class="section about">
                    <h2><span>{{$page->show('authors:title')}}</span></h2>
                    {!!$page->show('authors:text')!!}
                    <ul class="about__list">
                        @foreach ($authors as $author)
                            <li>
                                <div class="about-item">
                                    <a href="{{route('authors.show', $author)}}" class="about-item__image">
                                        <img src="{{$author->avatar->url}}" class="lazyload" alt="{{$author->avatar->alt}}">
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
                    <h2><span>{{$page->show('contact-us:title')}}</span></h2>
                    {!!$page->show('contact-us:text')!!}
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