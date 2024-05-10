@php
    if (!isset($page)) {
        $page = \App\Models\Page::get('about-us');
    }    
@endphp

<section class="section article">
    <h2><span>{{$page->show('mission:title')}}</span></h2>
    {!!$page->show('mission:text')!!}
    <ul class="type-list mission__list">
        <li class="type-item">
            <div class="type-item__image">
                <img src="{{asset('images/reasons4.svg')}}" alt="" />
            </div>
            <div class="type-item__title">{{$page->show('mission:block-1-title')}}</div>
            <p class="type-item__text">{{$page->show('mission:block-1-text')}}</p>
        </li>
        <li class="type-item">
            <div class="type-item__image">
                <img src="{{asset('images/reasons5.svg')}}" alt="" />
            </div>
            <div class="type-item__title">{{$page->show('mission:block-2-title')}}</div>
            <p class="type-item__text">{{$page->show('mission:block-2-text')}}</p>
        </li>
        <li class="type-item">
            <div class="type-item__image">
                <img src="{{asset('images/reasons6.svg')}}" alt="" />
            </div>
            <div class="type-item__title">{{$page->show('mission:block-3-title')}}</div>
            <p class="type-item__text">{{$page->show('mission:block-3-text')}}</p>
        </li>
        <li class="type-item">
            <div class="type-item__image">
                <img src="{{asset('images/reasons7.svg')}}" alt="" />
            </div>
            <div class="type-item__title">{{$page->show('mission:block-4-title')}}</div>
            <p class="type-item__text">{{$page->show('mission:block-4-text')}}</p>
        </li>
    </ul>
</section>