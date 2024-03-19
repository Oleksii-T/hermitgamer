@foreach ($posts as $post)
    <div class="category-item">
        <a href="{{route('posts.show', $post)}}" class="image category-item__image">
            <img src="{{$post->thumbnail->url}}" class="lazyload" alt="{{$post->thumbnail->alt}}"/>
        </a>
        <div class="category-item__desc">
            <div class="category-item__date">{{$post->created_at->format('M d, Y')}}</div>
            <a href="#" class="category-item__title">{{$post->title}}</a>
            <p class="category-item__text">{{$post->intro}}</p>
        </div>
    </div>
@endforeach