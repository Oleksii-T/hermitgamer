@extends('layouts.app')

@php
    $pageClass = 'article-page';
    $bcs = [
        ['Home', route('index')],
        [$category->name, route('categories.show', $category)],
        [$post->title]
    ];
@endphp

@section('content')
    <span data-sendview="{{route('posts.view', $post)}}"></span>
    <div class="page__wrapper">
        <section class="links">
            <button class="links__button-toggle">
                Useful Links
                <img src="{{asset('images/icons/links-arrow-white.svg')}}" alt="" />
            </button>
            <div class="links__wrapper">
                <div class="links__menu">
                    <div class="links__desc">
                        <button class="links__button-close"><img src="{{asset('images/icons/close.svg')}}" alt="" /></button>
                        <div class="links__desc-caption">USEFUL LINKS</div>
                        <p class="links__desc-text">Find more useful information and about <a href="{{route('games.show', $game)}}">{{$game->name}}</a> on HermitGamer.</p>
                    </div>
                    <ul class="links__list links__menu-list">
                        @foreach ($sameGamePosts as $sameGamePost)
                            <li>
                                @if ($sameGamePost->childs->isEmpty())
                                    <a href="{{route('posts.show', $sameGamePost)}}">
                                        {{$sameGamePost->title}}
                                    </a>
                                @else
                                    <a class="links__menu-button" data-target="{{$sameGamePost->slug}}">
                                        {{$sameGamePost->title}}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="links__submenu">
                    @foreach ($sameGamePosts as $sameGamePost)
                        @if ($sameGamePost->childs->isEmpty())
                            @continue
                        @endif
                        <div class="links__submenu-item" id="{{$sameGamePost->slug}}">
                            <div class="links__submenu-button">{{$sameGamePost->title}}</div>
                            <ul class="links__list links__submenu-list">
                                <li>
                                    <a href="{{route('posts.show', $sameGamePost)}}">{{$sameGamePost->title}}</a>
                                </li>
                                @foreach ($sameGamePost->childs as $sameGameP)
                                    <li>
                                        <a href="{{route('posts.show', $sameGameP)}}">{{$sameGameP->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <main class="main">
            <section class="hero">
                <h1 class="hero__title">{{$post->title}}</h1>
                <ul class="hero__desc">
                    <li>by <a href="{{route('authors.show', $author)}}">{{$author->name}}</a></li>
                    <li>UPDATED: {{$post->updated_at->format('M d, Y')}}</li>
                </ul>
                <div class="image hero__image">
                    <img src="{{$post->thumbnail->url}}" class="lazyload" alt="{{$post->thumbnail->alt}}" />
                </div>
            </section>

            @foreach ($blockGroups as $i => $blocks)
                <div class="main__wrapper">
                    <div class="content">
                        @if (!$i)
                            <section class="section article">
                                {!! $post->intro !!}
                            </section>
                        @endif
                        @foreach ($blocks as $block)
                            @php
                                $items = $block->items->sortBy('order');
                            @endphp
                            <section class="section {{$items->where('type', \App\Enums\BlockItemType::IMAGE_GALLERY)->count() ? 'screens' : 'article'}}" id="{{$block->ident}}">{{-- screens --}}
                                @foreach ($items as $item)
                                    @switch($item->type->value)
                                        @case(\App\Enums\BlockItemType::TITLE_H2->value)
                                            <h2>{{$item->value_simple}}</h2>
                                            @break
                                        @case(\App\Enums\BlockItemType::TITLE_H3->value)
                                            <h3>{{$item->value_simple}}</h3>
                                            @break
                                        @case(\App\Enums\BlockItemType::TITLE_H4->value)
                                            <h4>{{$item->value_simple}}</h4>
                                            @break
                                        @case(\App\Enums\BlockItemType::TEXT->value)
                                            {!!$item->value_simple!!}
                                            @break
                                        @case(\App\Enums\BlockItemType::IMAGE->value)
                                            <div class="image article__image">
                                                <img src="{{$item->file()->url}}" alt="{{$item->file()->alt}}" title="{{$item->file()->title}}" class="lazyload" />
                                            </div>
                                            @break
                                        @case('youtube')
                                            {!!$item->value_simple!!}
                                            @break
                                        @case(\App\Enums\BlockItemType::IMAGE_GALLERY->value)
                                            <div class="screens-slider">
                                                @foreach ($item->value_simple as $image)
                                                    <div class="screens-slider__item">
                                                        {{-- <a href="{{$image['url']}}" data-fancybox='postsgallery'> --}}
                                                            <img src="{{$image['url']}}" alt="">
                                                        {{-- </a> --}}
                                                    </div>
                                                @endforeach
                                            </div>
                                            @break
                                    @endswitch
                                @endforeach
                            </section>
                        @endforeach
                        @if ($loop->last)
                            <section class="section article">
                                <blockquote>
                                    <h2>Conclusion</h2>
                                    {!!$post->conclusion!!}
                                </blockquote>
                            </section>
                            @if ($post->faqs->isNotEmpty())
                                <section class="section faq" id="10">
                                    <h2 class="title faq__title"><span>FAQ</span></h2>
                                    <ul class="faq__list" itemscope itemtype="https://schema.org/FAQPage">
                                        @foreach ($post->faqs as $faq)
                                            <li class="faq__item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                                                <h3 class="faq-item__title js-button-expander" itemprop="name">{{$faq->question}}</h3>
                                                <div class="faq-item__desc js-expand-content" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                                    <div class="wrap" itemprop="text">
                                                        {!!$faq->answer!!}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <p class="faq__additional">Interested in some additional guides or help? Check out our <a href="{{route('games.show', $game)}}">{{$game->name}}</a> page for more useful tips and guides.</p>
                                </section>
                            @endif
                            <section class="section editor">
                                <div class="editor__head">
                                    <div class="editor__info">
                                        <div class="editor__image">
                                            <img src="{{$author->avatar->url}}" class="lazyload" alt="{{$author->avatar->alt}}" />
                                        </div>
                                        <div>
                                            <a href="{{route('authors.show', $author)}}" class="editor__name">{{$author->name}}</a>
                                            <p class="editor__desc">{{$author->title}}</p>
                                        </div>
                                    </div>
                                    <ul class="socials editor__socials">
                                        @if ($author->instagram)
                                            <li>
                                                <a href="{{$author->instagram}}" target="_blank">
                                                    <img src="{{asset('images/icons/instagram.svg')}}" alt="Instagram" title="instagram"/>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($author->facebook)
                                            <li>
                                                <a href="{{$author->facebook}}" target="_blank">
                                                    <img src="{{asset('images/icons/facebook.svg')}}" alt="Facebook" title="facebook"/>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($author->twitter)
                                            <li>
                                                <a href="{{$author->twitter}}" target="_blank">
                                                    <img src="{{asset('images/icons/twitter.svg')}}" alt="X (twitter)" title="X (twitter)"/>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($author->linkedin)
                                            <li>
                                                <a href="{{$author->linkedin}}" target="_blank">
                                                    <img src="{{asset('images/icons/linkedin.svg')}}" alt="linkedin" title="linkedin"/>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                {!!$author->description_small!!}
                            </section>
                            @if ($relatedPosts->isNotEmpty())
                                <section class="section related">
                                    <h2 class="title related__title"><span>Related Articles</span></h2>
                                    <ul class="related__list">
                                        @foreach ($relatedPosts as $relPost)
                                            <li>
                                                <div class="related-item">
                                                    <a href="{{route('posts.show', $relPost)}}" class="image related-item__image">
                                                        <img src="{{$relPost->thumbnail->url}}" class="lazyload" alt="" />
                                                    </a>
                                                    <div class="related-item__desc">
                                                        <a href="{{route('games.show', $relPost->game)}}" class="related-item__subtitle">{{$relPost->game->name}}</a>
                                                        <h3 class="relted-item__title">
                                                            <a href="{{route('posts.show', $relPost)}}">
                                                                {{$relPost->title}}
                                                            </a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </section>
                            @endif
                        @endif
                    </div>
                    <div class="sidebar">
                        @if (!$i)
                            <div class="sidebar__nav">
                                <div class="sidebar__nav-button">
                                    Table of contents
                                    <img src="images/icons/sidebar-nav-arrow.svg" alt="" />
                                </div>
                                <ul class="sidebar__nav-list">
                                    @foreach ($post->blocks as $block)
                                        <li>
                                            <a href="#{{$block->ident}}" class="anchor-link">{{$block->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="sidebar__banner">
                            <img src="/images/sidebar-banner1.webp" class="lazyload" alt="" />
                        </div>
                    </div>
                </div>
            @endforeach

            <x-go-to-top />
        </main>
        <x-page-bg />
    </div>
@endsection

@push('scripts')
    <script>
        $(".prod-photo").on("init", function(event, slick){
            $(".prod-top .prod-current").text(parseInt(slick.currentSlide + 1));
            $(".prod-top .prod-all").text(parseInt(slick.slideCount));
        });
        $(".prod-photo").on("afterChange", function(event, slick, currentSlide){
            $(".prod-top .prod-current").text(parseInt(slick.currentSlide + 1));
            $(".prod-top .prod-all").text(parseInt(slick.slideCount));
        });
        $('.prod-photo').slick({
            dots: false,
            arrows: true,
            autoplay: false,
            prevArrow: $('.prod-top .prod-prev'),
            nextArrow: $('.prod-top .prod-next'),
            speed: 1000,
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: false
        });
        Fancybox.bind("[data-fancybox='postsgallery']", {
            // Your custom options
        });
    </script>
@endpush
