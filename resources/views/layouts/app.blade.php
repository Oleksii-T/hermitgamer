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
            <title>Gamer news</title>
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
        <link media="all" rel="stylesheet" type="text/css" href="{{asset('css/slick.css')}}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
        <script src="https://kit.fontawesome.com/b4fffd0b24.js" crossorigin="anonymous"></script>
        @stack('css')
    </head>
    <body>
        <x-header />

        @yield('content')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
            window.Laravel = {!!$LaravelDataForJS!!};
            console.log(`window.Laravel`, window.Laravel); //! LOG
        </script>
        <script src="{{asset('js/slick.min.js')}}"></script>
        <script src="{{asset('js/main-alpha.js')}}"></script>
        <script src="{{asset('js/main-bravo.js')}}"></script>
        <script src="{{asset('js/main-charlie.js')}}"></script>
        <script src="{{asset('js/custom.js')}}"></script>
        @stack('scripts')
    </body>
</html>





