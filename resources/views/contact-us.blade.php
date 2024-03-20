@extends('layouts.app')

@php
    $bcs = [
        ['Home', route('index')],
        ['Contact Us']
    ];
@endphp

@section('content')
    <main class="main">
        <div class="main__wrapper">
            <div class="content">
                <section class="section section-head">
                    <h1>{{$page->show('top:title')}}</h1>
                    {!!$page->show('top:text')!!}
                    <form action="{{route('feedbacks.store')}}" method="post" class="form form-contacts feedback-form">
                        @csrf
                        <div class="form-field d-none">
                            <label for="topic" class="form-label">Topic <sup>*</sup></label>
                            <input type="text" name="topic" class="form-input" id="topic" placeholder="Type your topic..." />
                        </div>
                        <div class="form-field">
                            <label for="name" class="form-label">Name <sup>*</sup></label>
                            <input type="text" name="name" class="form-input" id="name" placeholder="Type your name..." required />
                            <span class="form-error" data-input="name"></span>
                        </div>
                        <div class="form-field">
                            <label for="email" class="form-label">Email <sup>*</sup></label>
                            <input type="text" name="email" class="form-input" id="email" placeholder="Type your email..." required />
                            <span class="form-error" data-input="email"></span>
                        </div>
                        <div class="form-field">
                            <label for="subject" class="form-label">Subject <sup>*</sup></label>
                            <input type="text" name="subject" class="form-input" id="subject" placeholder="Type your Subject..." required />
                            <span class="form-error" data-input="subject"></span>
                        </div>
                        <div class="form-field">
                            <label for="text" class="form-label">Comment <sup>*</sup></label>
                            <textarea name="text" class="form-input" id="text" placeholder="Type your comment here..." required></textarea>
                            <span class="form-error" data-input="text"></span>
                        </div>
                        <button type="submit" class="button form-button">Send</button>
                    </form>
                </section>
                <section class="section article">
                    <h2><span>{{$page->show('we-offer:title')}}</span></h2>
                    {!!$page->show('we-offer:text')!!}
                    <ul class="type-list contacts__list">
                        <li class="type-item">
                            <div class="type-item__image">
                                <img src="{{asset('images/reasons8.svg')}}" alt="" />
                            </div>
                            <div class="type-item__title">{{$page->show('we-offer:block-1-title')}}</div>
                            <p class="type-item__text">{{$page->show('we-offer:block-1-text')}}</p>
                        </li>
                        <li class="type-item">
                            <div class="type-item__image">
                                <img src="{{asset('images/reasons9.svg')}}" alt="" />
                            </div>
                            <div class="type-item__title">{{$page->show('we-offer:block-2-title')}}</div>
                            <p class="type-item__text">{{$page->show('we-offer:block-2-text')}}</p>
                        </li>
                        <li class="type-item">
                            <div class="type-item__image">
                                <img src="{{asset('images/reasons10.svg')}}" alt="" />
                            </div>
                            <div class="type-item__title">{{$page->show('we-offer:block-3-title')}}</div>
                            <p class="type-item__text">{{$page->show('we-offer:block-3-text')}}</p>
                        </li>
                        <li class="type-item">
                            <div class="type-item__image">
                                <img src="{{asset('images/reasons11.svg')}}" alt="" />
                            </div>
                            <div class="type-item__title">{{$page->show('we-offer:block-4-title')}}</div>
                            <p class="type-item__text">{{$page->show('we-offer:block-4-text')}}</p>
                        </li>
                    </ul>
                </section>
                <section class="section article">
                    <h2><span>{{$page->show('asnwers:title')}}</span></h2>
                    {!!$page->show('asnwers:text')!!}
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