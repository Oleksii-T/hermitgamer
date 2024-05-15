@php
    $bcs = [
        ['Home', route('index')],
        ['Not Found']
    ];
    $page = null;
@endphp

@extends('layouts.app')

@section('title', 'Not found')
@section('description', 'Not found')

@section('content')
    <main class="main">
        <div class="main__wrapper">
            <div class="content">
                <section class="section section-head">
                    <h1>404 PAGE NOT FOUND</h1>
                    Oops! Seem like we can not find the resource you are looking for...
                    <br>
                    <a href="{{route("index")}}" class="button">Go Back Home</a>
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