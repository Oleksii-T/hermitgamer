@extends('layouts.admin.app')

@section('title', 'Create Post')

@section('content_header')
    <x-admin.title
        text="Create Post"
    />
@stop

@section('content')
    <form action="{{ route('admin.posts.store') }}" method="POST" class="general-ajax-submit">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">General info</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" id="post-title">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug" data-autoslug="#post-title">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                @foreach (\App\Enums\PostStatus::all() as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <span data-input="status" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category_id">
                                @foreach (\App\Models\Category::all() as $model)
                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                @endforeach
                            </select>
                            <span data-input="category" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Game</label>
                            <select class="form-control select2" name="game_id">
                                @foreach (\App\Models\Game::all() as $model)
                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                @endforeach
                            </select>
                            <span data-input="game_id" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Author</label>
                            <select class="form-control" name="author_id">
                                @foreach (\App\Models\Author::all() as $model)
                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                @endforeach
                            </select>
                            <span data-input="author_id" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tags</label>
                            <select class="form-control select2" name="tags[]" multiple>
                                @foreach (\App\Models\Tag::all() as $model)
                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                @endforeach
                            </select>
                            <span data-input="tags" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Table of content style</label>
                            <select class="form-control" name="tc_style">
                                @foreach (\App\Enums\PostTCStyle::all() as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <span data-input="tc_style" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group show-uploaded-file-name show-uploaded-file-preview">
                            <label>Thumbnail</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                                <label class="custom-file-label" for="thumbnail">Choose file</label>
                            </div>
                            <img src="" alt="" class="custom-file-preview">
                            <span data-input="thumbnail" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Intro</label>
                            <textarea name="intro" class="form-control summernote"></textarea>
                            <span data-input="intro" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection

@push('scripts')
    <script src="{{asset('/js/admin/posts.js')}}"></script>
@endpush
