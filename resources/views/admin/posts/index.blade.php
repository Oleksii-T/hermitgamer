@extends('layouts.admin.app')

@section('title', 'Posts')

@section('content_header')
    <x-admin.title
        text="Posts"
        :button="['+ Add Post', route('admin.posts.create')]"
    />
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2">
                            <select class="table-filter form-control" name="category">
                                <option value="">Category filter</option>
                                @foreach (\App\Models\Category::all() as $model)
                                    <option value="{{$model->id}}" @selected(request()->category == $model->id)>{{$model->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select class="table-filter form-control" name="game">
                                <option value="">Game filter</option>
                                @foreach (\App\Models\Game::all() as $model)
                                    <option value="{{$model->id}}" @selected(request()->game == $model->id)>{{$model->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select class="table-filter form-control" name="author">
                                <option value="">Author filter</option>
                                @foreach (\App\Models\Author::all() as $model)
                                    <option value="{{$model->id}}" @selected(request()->author == $model->id)>{{$model->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select class="table-filter form-control" name="status">
                                <option value="">Status filter</option>
                                @foreach (\App\Enums\PostStatus::all() as $key => $value)
                                    <option value="{{$key}}" @selected(request()->status == $key)>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4" style="text-align: right">
                            <label for="trashed">Show trashed</label>
                            <input type="checkbox" id="trashed" name="trashed" value="1" class="table-filter">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="posts-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="ids-column">ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Views Stats <small>total/real/unique-real/bots</small></th>
                                <th>Status</th>
                                <th>Created_at</th>
                                <th class="actions-column-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('/js/admin/posts.js')}}"></script>
@endpush
