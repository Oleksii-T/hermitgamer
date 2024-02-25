@extends('layouts.admin.app')

@section('title', 'Edit Post Conclustion')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-left">
                    <h1 class="m-0">Edit Post</h1>
                </div>
                <x-admin.post-nav active="reviews" :post="$post" />
            </div>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ route('admin.posts.update-reviewsFields', $post) }}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Rating</label>
                            <input type="text" class="form-control" name="info[rating]" value="{{$info->rating}}">
                            <span data-input="info.rating" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Publisher</label>
                            <input type="text" class="form-control" name="info[game_details][publisher]" value="{{$info->game_details['publisher']??''}}">
                            <span data-input="info.game_details.publisher" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Developer</label>
                            <input type="text" class="form-control" name="info[game_details][developer]" value="{{$info->game_details['developer']??''}}">
                            <span data-input="info.game_details.developer" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="text" class="form-control" name="info[game_details][release_date]" value="{{$info->game_details['release_date']??''}}">
                            <span data-input="info.release_date" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Available platforms</label>
                            <input type="text" class="form-control" name="info[game_details][available_platforms]" value="{{$info->game_details['available_platforms']??''}}">
                            <span data-input="info.game_details.available_platforms" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Advantages</label>
                            <textarea name="info[advantages]" class="form-control">{{implode("\r\n", $post->info->advantages??[])}}</textarea>
                            <span data-input="info.advantages" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Disadvantages</label>
                            <textarea name="info[disadvantages]" class="form-control">{{implode("\r\n", $post->info->disadvantages??[])}}</textarea>
                            <span data-input="info.disadvantages" class="input-error"></span>
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
