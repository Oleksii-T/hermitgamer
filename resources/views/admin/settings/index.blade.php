@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content_header')
    <x-admin.title
        text="Settings"
        bcRoute="admin.settings.index"
    />
@stop

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @foreach (\App\Models\Setting::EDATABLE_SETTINGS as $setting)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{snakeReadable($setting)}}</label>
                                <input name="s[{{$setting}}]" type="text" class="form-control" value="{{\App\Models\Setting::get($setting)}}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection
