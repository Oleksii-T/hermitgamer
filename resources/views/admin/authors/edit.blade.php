@extends('layouts.admin.app')

@section('title', 'Edit Author')

@section('content_header')
    <x-admin.title
        text="Edit Author"
    />
@stop

@section('content')
    <form action="{{ route('admin.authors.update', $author) }}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$author->name}}">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{$author->email}}">
                            <span data-input="email" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group show-uploaded-file-name show-uploaded-file-preview">
                            <label>Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="avatar" name="avatar">
                                <label class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                            <img src="{{$author->avatar}}" alt="" class="custom-file-preview">
                            <span data-input="avatar" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" value="{{$author->title}}">
                            <span data-input="title" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug" value="{{$author->slug}}">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description">{{$author->description}}</textarea>
                            <span data-input="description" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Facebook</label>
                            <input type="text" class="form-control" name="facebook" value="{{$author->facebook}}">
                            <span data-input="facebook" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Instagram</label>
                            <input type="text" class="form-control" name="instagram" value="{{$author->instagram}}">
                            <span data-input="instagram" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Youtube</label>
                            <input type="text" class="form-control" name="youtube" value="{{$author->youtube}}">
                            <span data-input="youtube" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Twitter</label>
                            <input type="text" class="form-control" name="twitter" value="{{$author->twitter}}">
                            <span data-input="twitter" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Steam</label>
                            <input type="text" class="form-control" name="steam" value="{{$author->steam}}">
                            <span data-input="steam" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.authors.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection
