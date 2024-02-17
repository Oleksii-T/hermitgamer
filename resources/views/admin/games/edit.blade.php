@extends('layouts.admin.app')

@section('title', 'Edit Game')

@section('content_header')
    <x-admin.title
        text="Edit Game"
    />
@stop

@section('content')
    <form action="{{ route('admin.games.update', $game) }}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$game->name}}">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="name" value="{{$game->slug}}">
                            <span data-input="slug" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control">{{$game->description}}</textarea>
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
