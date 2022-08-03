<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="api_token" content="{{isset($currentUser) ? $currentUser->api_token : null}}">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @stack('meta')
        @if (isset($page) && $page)
            <meta name="title" content="{{$page->seo_title}}">
            <meta name="og:title" content="{{$page->seo_title}}">
            <meta name="description" content="{{$page->seo_description}}">
            <meta name="og:description" content="{{$page->seo_description}}">
            <title>{{$page->seo_title}}</title>
        @else
            <title>TradingSim</title>
        @endif
        <link rel="stylesheet" href="{{asset('fonts/stylesheet.css')}}">
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">
        <link rel="stylesheet" href="{{asset('css/global.css')}}">
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
        <link rel="stylesheet" href="{{asset('css/main-alpha.css')}}">
        <link rel="stylesheet" href="{{asset('css/main-bravo.css')}}">
        <link rel="stylesheet" href="{{asset('css/main-charlie.css')}}">
        <link rel="stylesheet" href="{{asset('css/main-delta.css')}}">
        <link rel="stylesheet" href="{{asset('css/media-alpha.css')}}">
        <link rel="stylesheet" href="{{asset('css/media-bravo.css')}}">
        <link rel="stylesheet" href="{{asset('css/media-charlie.css')}}">
        <link rel="stylesheet" href="{{asset('css/media-delta.css')}}">
        <link rel="stylesheet" href="{{asset('css/additional.css')}}">

        @stack('css')
    </head>
    <body>
        <x-header />

        @yield('content')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{asset('js/main-alpha.js')}}"></script>
        <script src="{{asset('js/main-bravo.js')}}"></script>
        <script src="{{asset('js/main-charlie.js')}}"></script>
        <script src="{{asset('js/auth.js')}}"></script>
        <script src="{{asset('js/profile.js')}}"></script>
        <script src="{{asset('js/pricing.js')}}"></script>
        @stack('scripts')
    </body>
</html>





