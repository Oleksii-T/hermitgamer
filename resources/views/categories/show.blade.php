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

                <section class="section category pagination-content">
                    <x-post-cards-with-pages :posts="$posts" />
                </section>
            </div>
            <div class="sidebar">
                <x-side-search-block />
                <div class="sidebar__banner">
                    <x-ad-vertical />
                </div>
            </div>
        </div>

        <x-go-to-top />
    </main>

    <x-page-bg />
@endsection
