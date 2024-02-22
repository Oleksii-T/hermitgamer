<div class="float-left pl-3">
    <a href="{{$active == 'general' ? '#' : route('admin.posts.edit', $post)}}" class="btn {{$active == 'general' ? 'btn-default' : 'btn-primary'}}">General</a>
</div>
<div class="float-left pl-3">
    <a href="{{$active == 'blocks' ? '#' : route('admin.posts.blocks', $post)}}" class="btn {{$active == 'blocks' ? 'btn-default' : 'btn-primary'}}">Blocks</a>
</div>
<div class="float-left pl-3">
    <a href="{{$active == 'faqs' ? '#' : route('admin.posts.faqs', $post)}}" class="btn {{$active == 'faqs' ? 'btn-default' : 'btn-primary'}}">FAQs</a>
</div>
<div class="float-left pl-3">
    <a href="{{$active == 'assets' ? '#' : route('admin.posts.assets', $post)}}" class="btn {{$active == 'assets' ? 'btn-default' : 'btn-primary'}}">Assets</a>
</div>
<div class="float-left pl-3">
    <a href="{{$active == 'related' ? '#' : route('admin.posts.related', $post)}}" class="btn {{$active == 'related' ? 'btn-default' : 'btn-primary'}}">Related</a>
</div>