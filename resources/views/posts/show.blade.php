@extends('layouts.app')

@section('title', $post->meta_title)
@section('description', $post->meta_description)
@section('meta-image', $post->thumbnail->url)
@section('meta-type', 'article')
@section('meta')
    {{-- 2022-08-25T01:46:13Z --}}
    <meta property="article:published_time" content="{{$post->published_at?->toIso8601ZuluString()}}"/> 
    <meta property="article:modified_time" content="{{$post->updated_at->toIso8601ZuluString()}}"/> 
    <meta property="article:section" content="{{$category->name}}"/> 
    <meta property="article:author" content="{{$author->name}}"/> 
@endsection


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
    @if ($post->status != \App\Enums\PostStatus::PUBLISHED)
        <p class="admin-only-post">The post is {{$post->status->readable()}}. Only admin can see it.</p>
    @endif
    <div class="page__wrapper {{$game ? '' : 'without-game'}}">
        @if ($game)
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
                            <p class="links__desc-text">Find more useful information about <a href="{{route('games.show', $game)}}">{{$game->name}}</a> on HermitGamer.</p>
                        </div>
                        <nav>
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
                        </nav>
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
        @endif
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
                        @if ($loop->first)
                            <section class="section article">
                                {!! $post->intro !!}
                            </section>

                            @if ($category->slug == 'reviews' && $post->info)
                                <section class="section article advantages">
                                    <div class="advantages-item">
                                        <h3 class="advantages-item__title">Advantage</h3>
                                        <ul>
                                            @foreach ($post->info->advantages??[] as $adv)
                                                <li>
                                                    <img src="{{asset('images/icons/advantages.svg')}}" alt="" />
                                                    {{$adv}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="advantages-item">
                                        <h3 class="advantages-item__title">Disadvantages</h3>
                                        <ul>
                                            @foreach ($post->info->disadvantages??[] as $disadv)
                                                <li>
                                                    <img src="{{asset('images/icons/disadvantages.svg')}}" alt="" />
                                                    {{$disadv}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </section>
                            @endif
                        @endif
                        
                        @if ($post->tc_style == \App\Enums\PostTCStyle::WIDE)
                            <section class="article">
                                <table>
                                    <tbody>    
                                        @foreach ($post->blocks->chunk(3) as $blocksChunk)
                                            <tr>
                                                @foreach ($blocksChunk as $block)
                                                    <td>
                                                        <a href="#{{$block->ident}}" class="anchor-link">{{$block->name}}</a>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </section>
                        @endif

                        <x-content-blocks :blocks="$blocks" />

                        @if ($loop->last)
                            @if ($category->slug == 'reviews' && $post->info)
                                <section class="section article article-rating" id="conclusion">
                                    <div class="article-rating__info">
                                        <h2>Conclusion</h2>
                                        <a href="{{route('rate')}}" class="article-rating__link">Review Policy</a>
                                        {!!$post->conclusion!!}
                                    </div>
                                    <div class="article-rating__item">
                                        <div class="article-rating__wrap">
                                            <span class="article-rating__numbers">
                                                <span>{{$post->info->rating}}</span>/<span>5</span>
                                            </span>
                                            <p>rating</p>
                                        </div>
                                        <a href="{{route('rate')}}" class="article-rating__link">Review Policy</a>
                                        <script type="application/ld+json">
                                            {
                                                "@context": "http://schema.org/",
                                                "@type": "Review",
                                                "mainEntityOfPage": {
                                                    "@type": "WebPage",
                                                    "@id": "https://www.neognosisgames.com/stardew-valley-review/"
                                                },
                                                "image": "https://www.neognosisgames.com/wp-content/uploads/2024/02/stardew-valley-review.webp",
                                                "url": "https://www.neognosisgames.com/stardew-valley-review/",
                                                "description": "Stardew Valley is the game you won’t understand until you try. It may capture your attention for hundreds of hours and doesn't get boring.",
                                                "itemReviewed": {
                                                    "@type": "Game",
                                                    "name": "{{$game->name}}"
                                                },
                                                "reviewRating": {
                                                    "@type": "Rating",
                                                    "ratingValue": "{{$post->info->rating}}",
                                                    "worstRating": "0",
                                                    "bestRating": "5"
                                                },
                                                "datePublished": "2024-02-06",
                                                "headline": "{{$game->name}} Review",
                                                "publisher": {
                                                    "@type": "Organization",
                                                    "name": "{{config('app.name')}}",
                                                    "logo": {
                                                    "@type": "ImageObject",
                                                    "url": "https://www.neognosisgames.com/wp-content/uploads/2024/02/neognosisgames.webp"
                                                    }
                                                },
                                                "author": {
                                                    "@type": "Person",
                                                    "name": "{{$author->name}}",
                                                    "url": "{{route('authors.show', $author)}}"
                                                },
                                                "dateModified": "2024-02-14"
                                            }
                                        </script>
                                    </div>
                                </section>
                            @elseif (strip_tags($post->conclusion))
                                <section class="section article" id="conclusion">
                                    <div class="blockquote">
                                        <h2>Conclusion</h2>
                                        {!!$post->conclusion!!}
                                    </div>
                                </section>
                            @endif
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
                                    @if ($game)
                                        <p class="faq__additional">Interested in some additional guides or help? Check out our <a href="{{route('games.show', $game)}}">{{$game->name}}</a> page for more useful tips and guides.</p>
                                    @endif
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
                                        @if ($author->steam)
                                            <li>
                                                <a href="{{$author->steam}}" target="_blank">
                                                    <img src="{{asset('images/icons/steam.svg')}}" alt="steam" title="steam"/>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($author->youtube)
                                            <li>
                                                <a href="{{$author->youtube}}" target="_blank">
                                                    <img src="{{asset('images/icons/youtube.svg')}}" alt="youtube" title="youtube"/>
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
                            @if ($category->slug == 'reviews')
                                <div class="sidebar__details">
                                    <div class="sidebar__details-button">
                                        Game Details
                                        <img src="{{asset('images/icons/sidebar-nav-arrow.svg')}}" alt="" />
                                    </div>
                                    <ul class="sidebar__details-list">
                                        <li>
                                            <p>Publisher:</p>
                                            <a href="#">{{$game->publisher}}</a>
                                        </li>
                                        <li>
                                            <p>Developer:</p>
                                            <a href="#">{{$game->developer}}</a>
                                        </li>
                                        <li>
                                            <p>Release Date:</p>
                                            <a href="#">{{$game->release_date->format('M d, Y')}}</a>
                                        </li>
                                        <li>
                                            <p>Available Platforms:</p>
                                            <a href="#">{{$game->platforms}}</a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                            @if ($post->tc_style == \App\Enums\PostTCStyle::R_SIDEBAR)
                                <div class="sidebar__nav">
                                    <div class="sidebar__nav-button">
                                        Table of contents
                                        <img src="images/icons/sidebar-nav-arrow.svg" alt="" />
                                    </div>
                                    <ul class="sidebar__nav-list">
                                        @foreach ($post->blocks->sortBy('order') as $block)
                                            <li>
                                                <a href="#{{$block->ident}}" class="anchor-link">{{$block->name}}</a>
                                            </li>
                                        @endforeach
                                        @if (strip_tags($post->conclusion))
                                            <li>
                                                <a href="#conclusion" class="anchor-link">Conclusion</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
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
