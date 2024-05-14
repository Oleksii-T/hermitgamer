@extends('layouts.admin.app')

@section('title', 'Edit Page')

@section('content_header')
    <x-admin.title
        text="Edit Page #{{$page->id}}"
        :bcRoute="['admin.pages.edit', $page]"
    />
@stop

@section('content')
    <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="general-ajax-submit" style="padding-bottom:1.5rem">
        @csrf
        @method('PUT')
        <div class="card card-info card-outline">
            <div class="card-header">
                <h5 class="m-0">Info</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input name="title" type="text" class="form-control" value="{{$page->title}}">
                            <span data-input="title" class="input-error"></span>
                        </div>
                    </div>
                    @if (!$page->isStatic())
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    @foreach (\App\Enums\PageStatus::getEditables() as $key => $value)
                                        <option value="{{$key}}" @selected($page->status->value == $key)>{{$value}}</option>
                                    @endforeach
                                </select>
                                <span data-input="status" class="input-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>URL</label>
                                <input name="link" type="text" class="form-control" @disabled($page->isStatic()) value="{{$page->link}}">
                                <span data-input="link" class="input-error"></span>
                            </div>
                        </div>
                    @endif
                    @if ($page->status != \App\Enums\PageStatus::ENTITY)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Meta title</label>
                                <input name="meta_title" type="text" class="form-control" value="{{$page->meta_title}}">
                                <span data-input="meta_title" class="input-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Meta description</label>
                                <input name="meta_description" type="text" class="form-control" value="{{$page->meta_description}}">
                                <span data-input="title" class="input-error"></span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if (!$page->isStatic())
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="m-0">Content</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="content" class="form-control summernote">{!!$page->content!!}</textarea>
                                <span data-input="content" class="input-error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($page->isStatic())
            <a href="{{route('admin.pages.edit-blocks', $page)}}" class="btn btn-info min-w-100">Edit blocks</a>
        @endif
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection
