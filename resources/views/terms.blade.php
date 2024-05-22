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