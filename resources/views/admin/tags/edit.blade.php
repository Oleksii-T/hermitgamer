@extends('layouts.admin.app')

@section('title', 'Edit Tag')

@section('content_header')
    <x-admin.title
        text="Edit Tag"
    />
@stop

@section('content')
    <form action="{{ route('admin.tags.update', $tag) }}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$tag->name}}">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="name" value="{{$tag->slug}}">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection
