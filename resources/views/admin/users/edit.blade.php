@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content_header')
    <x-admin.title
        text="Edit User"
        :bcRoute="['admin.users.edit', $user]"
    />
@stop

@section('content')
    <form action="{{route('admin.users.update', $user)}}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card card-info card-outline">
            <div class="card-header">
                <h5 class="m-0">Basic Info</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4 user-image-block">
                    <label class="uploader mr-3 show-uploaded-file-preview">
                        <input type="file" name="avatar" class="sr-only" id="avatar">
                        <img src="{{$user->avatar ? $user->avatar : asset('img/empty-avatar.jpeg')}}" class="custom-file-preview" alt="" style="width: 30px">
                    </label>
                    <button type="button" class="btn btn-default" data-trigger="#avatar">Change Photo</button>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input name="first_name" type="text" class="form-control" placeholder="First Name..." value="{{$user->first_name}}">
                            <span data-input="first_name" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input name="last_name" type="text" class="form-control" placeholder="Last Name..." value="{{$user->last_name}}">
                            <span data-input="last_name" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Email Address..." value="{{$user->email}}">
                            <span data-input="email" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" placeholder="Phone Number..." value="{{$user->phone_number}}">
                            <span data-input="phone_number" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>User Role</label>
                            <select class="form-control" name="role">
                                @foreach (\App\Models\User::ROLES as $role => $name)
                                    <option value="{{$role}}" @selected($user->role==$role)>{{$name}}</option>
                                @endforeach
                            </select>
                            <span data-input="role" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-info card-outline">
            <div class="card-header">
                <h5 class="m-0">Set Password</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control" placeholder="Password...">
                            <span data-input="password" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input name="password_confirm" type="password" class="form-control" placeholder="Confirm Password...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection
