@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        [$page->show('top:bc')]
    ];
@endphp

@section('content')
    <main class="main">
        <div class="main__wrapper">
            <div class="content">
                <section class="section section-head" style="padding-bottom: 0px">
                    <h1>{{$page->show('top:title')}}</h1>
                </section>
                <x-content-blocks :blocks="$blocks" type="1" />
                <section class="section article rate">
                    <ul class="rate__list">
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate5.svg')}}" alt="Excellent Rating" title="Excellent Rating" />
                                5
                            </div>
                            <div class="rate__title">{{$page->show('how:block-5-title')}}</div>
                            <p class="rate__text">
                                {{$page->show('how:block-5-text')}}
                            </p>
                        </li>
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate4.svg')}}" alt="Good Rating" title="Good Rating" />
                                4
                            </div>
                            <div class="rate__title">{{$page->show('how:block-4-title')}}</div>
                            <p class="rate__text">
                                {{$page->show('how:block-4-text')}}
                            </p>
                        </li>
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate3.svg')}}" alt="Average Rating" title="Average Rating" />
                                3
                            </div>
                            <div class="rate__title">{{$page->show('how:block-3-title')}}</div>
                            <p class="rate__text">
                                {{$page->show('how:block-3-text')}}
                            </p>
                        </li>
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate2.svg')}}" alt="Bad Rating" title="Bad Rating" />
                                2
                            </div>
                            <div class="rate__title">{{$page->show('how:block-2-title')}}</div>
                            <p class="rate__text">
                                {{$page->show('how:block-2-text')}}
                            </p>
                        </li>
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate1.svg')}}" alt="Awful Rating" title="Awful Rating" />
                                1
                            </div>
                            <div class="rate__title">{{$page->show('how:block-1-title')}}</div>
                            <p class="rate__text">
                                {{$page->show('how:block-1-text')}}
                            </p>
                        </li>
                    </ul>
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
