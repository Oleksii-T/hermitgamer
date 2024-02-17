@extends('layouts.admin.app')

@section('title', 'Create Game')

@section('content_header')
    <x-admin.title
        text="Create Game"
    />
@stop

@section('content')
    <form action="{{ route('admin.games.store') }}" method="POST" class="general-ajax-submit">
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
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                            <span data-input="description" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.games.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection
