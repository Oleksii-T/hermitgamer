@extends('layouts.admin.app')

@section('title', 'Edit post Content')

@push('stles')
@endpush

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="float-left">
                <h1 class="m-0">Edit Post Content</h1>
            </div>
            <div class="float-left pl-3">
                <a href="{{route('admin.posts.edit', $post)}}" class="btn btn-primary">Edit General Info</a>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
    <div id="app">
        <post-content :dataprops="{{$appData}}"/></post-content>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/admin.js')
@endpush
