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
    <form action="{{route('admin.posts.update-content', $post)}}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="item-inputs d-none">
            <div class="title">
                <x-admin.multi-lang-input name="value" />
            </div>
            <div class="text">
                <x-admin.multi-lang-input name="value" editor="1" />
            </div>
            <div class="image">
                <div class="show-uploaded-file-name show-uploaded-file-preview">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input">
                        <label class="custom-file-label">Choose file</label>
                    </div>
                    <img src="" alt="" class="custom-file-preview">
                </div>
            </div>
            <div class="video">
                <div class="show-uploaded-file-name">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input">
                        <label class="custom-file-label">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="slider">
                todo
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <h5 class="m-0 col">Content</h5>
                <div class="col">
                    <button type="button" class="btn btn-success d-block float-right add-block">Add Block</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row post-block-wrapper">
                    <div class="card card-outline card-dark w-100 post-block d-none clone">
                        <div class="card-header row">
                            <div class="col">
                                <h5 class="m-0 d-inline">id=</h5>
                                "<input type="text" class="form-control d-inline w-auto" name="blocks[0][id]">"
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-warning d-block float-right remove-block">Remove</button>
                                <button type="button" class="btn btn-success d-block mr-2 float-right add-item">Add Item</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row block-item-wrapper">
                                <div class="col-md-12 block-item d-none clone">
                                    <div class="form-group">
                                        <div class="mb-2">
                                            <select name="blocks[0][items][0][type]" class="form-control w-auto d-inline item-type-select">
                                                @foreach ($itemTypes as $item)
                                                    <option value="{{$item}}">{{readable($item)}}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-warning remove-item float-right">Remove</button>
                                        </div>
                                        <div class="item-input">
                                            <input type="text" name="blocks[0][items][0][value]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
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

@endpush
