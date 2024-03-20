<div class="float-left pl-3">
    <a href="{{$active == 'general' ? '#' : route('admin.authors.edit', $author)}}" class="btn {{$active == 'general' ? 'btn-default' : 'btn-primary'}}">General</a>
</div>
<div class="float-left pl-3">
    <a href="{{$active == 'socials' ? '#' : route('admin.authors.socials', $author)}}" class="btn {{$active == 'socials' ? 'btn-default' : 'btn-primary'}}">Socials</a>
</div>
<div class="float-left pl-3">
    <a href="{{$active == 'paragraphs' ? '#' : route('admin.authors.paragraphs', $author)}}" class="btn {{$active == 'paragraphs' ? 'btn-default' : 'btn-primary'}}">Paragraphs</a>
</div>