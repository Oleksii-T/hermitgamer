@extends('layouts.admin.app')

@section('title', 'Comments')

@section('content_header')
    <x-admin.title
        text="TODO"
    />
@stop

@push('scripts')
    <script src="{{asset('/js/admin/comments.js')}}"></script>
@endpush
