@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        ['Privacy Policy']
    ];
@endphp

@section('content')
    <main class="main">
        <div class="main__wrapper">
            <div class="content">
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