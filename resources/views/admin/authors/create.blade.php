@extends('layouts.admin.app')

@section('title', 'Create Author')

@section('content_header')
    <x-admin.title
        text="Create Author"
    />
@stop

@section('content')
    <form action="{{ route('admin.authors.store') }}" method="POST" class="general-ajax-submit">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email">
                            <span data-input="email" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input type="text" class="form-control" name="meta_title">
                            <span data-input="meta_title" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Description</label>
                            <input type="text" class="form-control" name="meta_description">
                            <span data-input="meta_description" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group show-uploaded-file-name show-uploaded-file-preview">
                            <label>Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="avatar" name="avatar">
                                <label class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                            <img src="" alt="" class="custom-file-preview">
                            <span data-input="avatar" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                            <span data-input="title" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control summernote" name="description"></textarea>
                            <span data-input="description" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description for Posts page</label>
                            <textarea class="form-control summernote" name="description_small"></textarea>
                            <span data-input="description_small" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.authors.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection
