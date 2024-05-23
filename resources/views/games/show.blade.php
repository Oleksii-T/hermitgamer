@extends('layouts.app')

@section('title', $game->meta_title)
@section('description', $game->meta_description)
@section('meta-image', $game->thumbnail()->url)

@php
    $pageClass = 'article-page';
    $bcs = [
        ['Home', route('index')],
        [$game->name]
    ];
@endphp

@section('content')
    <main class="main">
        <section class="game">
            <div class="image game__image game__image--desc" >
                <img src="{{$game->thumbnail()->url}}" class="lazyload" alt="{{$game->thumbnail()->alt}}" title="{{$game->thumbnail()->title}}" />
            </div>
            <div class="game__info">
                <h1 class="game__title">{{$game->name}}</h1>
                <p class="game__text">
                    {{$game->description}}
                </p>
                <div class="image game__image game__image--mob">
                    <img src="{{$game->thumbnail()->url}}" class="lazyload" alt="{{$game->thumbnail()->alt}}" title="{{$game->thumbnail()->title}}" />
                </div>
                <div class="game__desc">
                    <ul class="game__requirements">
                        <li>
                            <strong>Release Date:</strong>
                            <span>{{$game->release_date->format('M d, Y')}}</span>
                        </li>
                        <li>
                            <strong>Developer:</strong>
                            <span>{{$game->developer}}</span>
                        </li>
                        <li>
                            <strong>Platforms:</strong>
                            <span>{{$game->platforms}}</span>
                        </li>
                    </ul>
                    <ul class="game__rating">
                        <li>
                            <div class="game__rating-head">
                                <img src="/images/game-rating1.svg" alt="Rating icon" title="Rating icon" />
                                <span>{{$game->rating}}/5</span>
                            </div>
                            <p class="game__rating-text">
                                HermitGamer <br />
                                Rating
                            </p>
                        </li>
                        <li>
                            <div class="game__rating-head">
                                <img src="/images/game-rating2.svg" alt="Rating icon" title="Rating icon" />
                                <span>{{$game->metacritic ?? '-'}}</span>
                                <span>100</span>
                            </div>
                            <p class="game__rating-text">
                                Metacritic <br />
                                Rating
                            </p>
                        </li>
                        <li>
                            <div class="game__rating-head">
                                <img src="/images/game-rating3.svg" alt="Rating icon" title="Rating icon" />
                                <span>{{$game->users_score ?? '-'}}</span>
                                <span>10</span>
                            </div>
                            <p class="game__rating-text">
                                Users <br />
                                Score
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="game__statistic">
                    <div class="game__statistic-title">How Long to Beat</div>
                    <ul class="game__statistic-list">
                        <li>
                            <p>Main Story</p>
                            <strong>{{$game->hours['main']}} Hours</strong>
                        </li>
                        <li>
                            <p>Main + Sides</p>
                            <strong>{{$game->hours['main_sides']}} Hours</strong>
                        </li>
                        <li>
                            <p>Completionist</p>
                            <strong>{{$game->hours['completionist']}} Hours</strong>
                        </li>
                        <li>
                            <p>All Styles</p>
                            <strong>{{$game->hours['all']}} Hours</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <div class="main__wrapper">
            <div class="content">
                @if ($game->screenshots->isNotEmpty())
                    <section class="section screens">
                        <h2><span>{{$game->name}} Screenshots</span></h2>
                        <div class="screens-slider">
                            @foreach ($game->screenshots as $screenshot)
                                <div class="screens-slider__item">
                                    <a href="{{$screenshot->url}}" data-fancybox='postsgallery'>
                                        <img data-lazy="{{$screenshot->url}}" alt="{{$screenshot->alt}}" title="{{$screenshot->title}}" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
                @if ($review)
                    <section class="section article review">
                        <h2><span>{{$game->name}} Review</span></h2>
                        <div class="review__inner">
                            <div>
                                <div class="review__author">
                                    Reviewed by:
                                    <a href="{{route('authors.show', $review->author)}}">
                                        {{$review->author->name}}
                                    </a>
                                </div>
                                {!!$review->conclusion!!}
                                <a href="{{route('posts.show', $review)}}" class="button button-dark review__button">Full Review</a>
                            </div>
                            <div class="review__rating article-rating__item">
                                <div class="article-rating__wrap" itemscope itemtype="https://schema.org/Game">
                                    <span itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating" class="article-rating__numbers">
                                        <span itemprop="ratingValue">{{$review->info->rating ?? 0}}</span>/<span itemprop="bestRating">5</span> <meta itemprop="reviewCount" content="5" />
                                    </span>
                                    <meta itemprop="name" content="https://hermitgamer.com" />
                                    <p>rating</p>
                                </div>
                                <a href="{{route('rate')}}" class="article-rating__link">Review Policy</a>
                            </div>
                        </div>
                    </section>
                @endif
                @if ($guides->isNotEmpty())
                    <section class="section guides">
                        <h2><span>{{$game->name}} Guides</span></h2>
                        <ul class="guides__list">
                            <x-post-cards-small :posts="$guides" />
                        </ul>
                        @if ($hasMoreGuides)
                            <a href="#" class="button button-dark guides__button show-more-posts" data-type="guides">Show More</a>
                        @endif
                    </section>
                @endif
                @if ($topLists->isNotEmpty())
                    <section class="section guides">
                        <h2><span>{{$game->name}} Lists</span></h2>
                        <ul class="guides__list">
                            <x-post-cards-small :posts="$topLists" />
                        </ul>
                        @if ($hasMoreTopLists)
                            <a href="#" class="button button-dark guides__button show-more-posts" data-type="top_lists">Show More</a>
                        @endif
                    </section>
                @endif
                <section class="section summary">
                    <h2>Summary</h2>
                    <div class="summary__wrap">
                        <div class="summary__text">
                            {!!$game->summary!!}
                            <div class="summary__text-desc">
                                <img src="{{$game->esbr_image()->url}}" alt="{{$game->esbr_image()->alt}}" title="{{$game->esbr_image()->title}}" />
                                <p>
                                    <strong>ESRB Rating:</strong>
                                    {{$game->esbr}}
                                </p>
                            </div>
                        </div>
                        <ul class="summary__list">
                            <li>
                                <strong>Developer:</strong>
                                {{$game->developer}}
                            </li>
                            <li>
                                <strong>Platforms:</strong>
                                {{$game->platforms}}
                            </li>
                            <li>
                                <strong>Publisher:</strong>
                                {{$game->publisher}}
                            </li>
                            <li>
                                <strong>Genres:</strong>
                                {{$game->ganres}}
                            </li>
                            <li>
                                <strong>Release Date:</strong>
                                {{$game->release_date->format('M d, Y')}}
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
            <div class="sidebar">
                <div class="sidebar__banner">
                    <x-ad-vertical />
                </div>
            </div>
        </div>
        <x-go-to-top />
    </main>
    <x-page-bg />
@endsection
