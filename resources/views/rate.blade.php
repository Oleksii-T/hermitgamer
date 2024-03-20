@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        ['Rate']
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
                    <h2><span>{{$page->show('goal:title')}}</span></h2>
                    {!!$page->show('goal:text')!!}
                </section>
                <section class="section article rate">
                    <h2><span>{{$page->show('how:title')}}</span></h2>
                    {!!$page->show('how:text')!!}
                    <ul class="rate__list">
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate5.svg')}}" alt="" />
                                5
                            </div>
                            <div class="rate__title">{{$page->show('how:block-5-title')}}</div>
                            <p class="rate__text">
                                {{$page->show('how:block-5-text')}}
                            </p>
                        </li>
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate4.svg')}}" alt="" />
                                4
                            </div>
                            <div class="rate__title">{{$page->show('how:block-4-title')}}</div>
                            <p class="rate__text">
                                {{$page->show('how:block-4-text')}}
                            </p>
                        </li>
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate3.svg')}}" alt="" />
                                3
                            </div>
                            <div class="rate__title">{{$page->show('how:block-3-title')}}</div>
                            <p class="rate__text">
                                {{$page->show('how:block-3-text')}}
                            </p>
                        </li>
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate2.svg')}}" alt="" />
                                2
                            </div>
                            <div class="rate__title">{{$page->show('how:block-2-title')}}</div>
                            <p class="rate__text">
                                {{$page->show('how:block-2-text')}}
                            </p>
                        </li>
                        <li>
                            <div class="rate__num">
                                <img src="{{asset('images/rate1.svg')}}" alt="" />
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