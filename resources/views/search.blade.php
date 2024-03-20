@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        [$page->show('top:title') . request()->search]
    ];
@endphp

@section('content')
    <main class="main">
        <div class="main__wrapper">
            <div class="content">
                <section class="section section-head">
                    <h1>{{$page->show('top:title')}}{{request()->search}}</h1>
                    {!!$page->show('top:text')!!}
                </section>

                @if ($posts->isEmpty())
                    <section class="section">
                        {!!$page->show('empty:text')!!}
                    </section>
                @else
                    <section class="section category">
                        <x-post-cards :posts="$posts" />
                        @if ($hasMore)
                            <a href="#" class="button button-dark category__button show-more-posts">
                                Show More
                            </a>
                        @endif
                    </section>
                @endif

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