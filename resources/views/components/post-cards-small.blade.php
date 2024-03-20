@foreach ($posts as $post)
    <li class="guides-item">
        <a href="{{route('posts.show', $post)}}" class="image guides-item__image">
            <img src="{{$post->thumbnail->url}}" class="lazyload" alt="{{$post->thumbnail->alt}}" />
        </a>
        <div class="guides-item__desc">
            <h3 class="guides-item__title">
                <a href="{{route('posts.show', $post)}}">
                    {{$post->title}}
                </a>
            </h3>
            <div class="guides-item__date">{{$post->published_at->format('M d, Y')}}</div>
        </div>
    </li>
@endforeach