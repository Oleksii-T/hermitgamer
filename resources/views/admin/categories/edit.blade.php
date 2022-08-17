@extends('layouts.admin.app')

@section('title', 'Edit Category')

@section('content_header')
    <x-admin.title
        text="Edit Category"
    />
@stop

@section('content')
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>In Top Menu</label>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="in_menu" name="in_menu" @checked($category->in_menu)>
                                <label for="in_menu" class="custom-control-label">Yes</label>
                            </div>
                            <span data-input="in_menu" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Key</label>
                            <input type="text" class="form-control" value="{{$category->key}}" disabled>
                            <span data-input="order" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Order</label>
                            <input type="number" class="form-control" name="order" value="{{$category->order}}">
                            <span data-input="order" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <x-admin.multi-lang-input name="name" :model="$category" />
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <x-admin.multi-lang-input name="slug" :model="$category" />
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection
