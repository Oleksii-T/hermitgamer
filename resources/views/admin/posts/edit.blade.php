@extends('layouts.admin.app')

@section('title', 'Edit post')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="float-left">
                    <h1 class="m-0">Edit Post General Info</h1>
                </div>
                <div class="float-left pl-3">
                    <a href="{{route('admin.posts.edit-content', $post)}}" class="btn btn-primary">Edit Content</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('admin.posts.update', $post)}}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">General info</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <x-admin.multi-lang-input name="title" :model="$post" />
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <x-admin.multi-lang-input name="slug" :model="$post" />
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group show-uploaded-file-name show-uploaded-file-preview">
                            <label>Thumbnail</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                                <label class="custom-file-label" for="thumbnail">{{$post->thumbnail?->original_name}}</label>
                            </div>
                            <img src="{{$post->thumbnail?->url}}" alt="" class="custom-file-preview">
                            <span data-input="thumbnail" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Is Active</label>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" value="1" @checked($post->is_active)>
                                <label for="is_active" class="custom-control-label">Yes</label>
                            </div>
                            <span data-input="is_active" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category_id">
                                @foreach (\App\Models\Category::all() as $model)
                                    <option value="{{$model->id}}" @selected($post->category_id==$model->id)>{{$model->name}}</option>
                                @endforeach
                            </select>
                            <span data-input="category" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Game</label>
                            <select class="form-control" name="game_id">
                                @foreach (\App\Models\Game::all() as $model)
                                    <option value="{{$model->id}}" @selected($post->game_id==$model->id)>{{$model->name}}</option>
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
                                    <option value="{{$model->id}}" @selected($post->author_id==$model->id)>{{$model->name}}</option>
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
                                    <option value="{{$model->id}}" @selected($post->tags->contains('id', $model->id))>{{$model->name}}</option>
                                @endforeach
                            </select>
                            <span data-input="tags" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">Custom css\js</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group show-uploaded-file-name">
                            <label>CSS</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="css" name="css">
                                <label class="custom-file-label" for="css">{{$post->css?->original_name ?? 'Choose File'}}</label>
                            </div>
                            <span data-input="css" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group show-uploaded-file-name">
                            <label>JS</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="js" name="js">
                                <label class="custom-file-label" for="js">{{$post->js?->original_name ?? 'Choose File'}}</label>
                            </div>
                            <span data-input="js" class="input-error"></span>
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
