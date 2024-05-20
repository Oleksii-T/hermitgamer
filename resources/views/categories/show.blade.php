@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        [$category->name]
    ];
@endphp

@section('title', $category->meta_title)
@section('description', $category->meta_description)
@section('meta-image', $category->meta_thumbnail()?->url)

@section('content')
    <main class="main">
        <div class="main__wrapper">
            <div class="content">
                <section class="section section-head">
                    <h1>{{$category->name}}</h1>
                    {!!$category->description!!}
                </section>

                <x-mobile-search-block />

                <section class="section category">
                    <x-post-cards :posts="$posts" />
                    @if ($hasMore)
                        <a href="#" class="button button-dark category__button show-more-posts">
                            Show More
                        </a>
                    @endif
                </section>
            </div>
            <div class="sidebar">
                <x-side-search-block />
                <div class="sidebar__banner">
                    <img
                        src="images/sidebar-banner1.webp"
                        class="lazyload"
                        alt=""
                    />
                </div>
            </div>
        </div>

        <x-go-to-top />
    </main>

    <x-page-bg />
@endsection
