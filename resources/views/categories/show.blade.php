@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        [$category->name]
    ];
@endphp

@section('title', $category->meta_title)

@section('description', $category->meta_description)

@section('content')
    <div class="main__wrapper">
        <div class="content">
            <section class="section section-head">
                <h1>{{$category->name}}</h1>
                <p>{{$category->description}}</p>
            </section>

            <x-mobile-search-block />

            <section class="section category">
                <x-post-cards :posts="$posts" />
                <a
                    href="#"
                    class="button button-dark category__button show-more-categories"
                >
                    Show More
                </a>
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
@endsection
