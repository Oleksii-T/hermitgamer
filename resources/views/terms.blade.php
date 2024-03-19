@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        [$page->show('content:title')]
    ];
@endphp

@section('content')
    <div class="main__wrapper">
        <div class="content">
            <section class="section section-head">
                <h1>{{$page->show('content:title')}}</h1>
                {!!$page->show('content:text')!!}
            </section>
        </div>
        <div class="sidebar">
            <x-side-search-block />
            <x-side-links-block />
        </div>
    </div>
@endsection