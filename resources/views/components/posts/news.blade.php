@foreach ($news as $post)
    <article class="article-item preveiw">
        <a href="{{route('posts.show', $post->getLocalizedRouteKey())}}">
            <div class="article-item__img">
                <img src="{{$post->thumbnail->url}}" alt="">
            </div>
            <h3 class="article-item__title">{{$post->title}}</h3>
            <span class="article-item__date">{{$post->created_at->format('M d, Y')}}</span>
        </a>
    </article>
@endforeach
