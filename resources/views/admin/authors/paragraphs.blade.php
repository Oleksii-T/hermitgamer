@extends('layouts.admin.app')

@section('title', 'Create Author')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="float-left">
                    <h1 class="m-0">Edit Author</h1>
                </div>
                <x-admin.author-nav active="paragraphs" :author="$author" />
                <div class="float-left pl-3">
                    <a href="#" class="btn btn-success add-paragraph">+ Add Paragraph</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ route('admin.authors.update-paragraphs', $author) }}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card clone d-none">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Title</label>
                            <a href="#" class="btn btn-danger remove-parangraph" style="line-height: 0.4;padding:5px">X</a>
                            <input type="text" class="form-control" name="titles[]">
                            <span data-input="titles" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Group</label>
                            <select class="form-control" name="groups[]">
                                @foreach (\App\Enums\AuthorParagraphGroup::all() as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <span data-input="groups" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Paragraph</label>
                            <textarea name="texts[]" class="form-control"></textarea>
                            <span data-input="texts" class="input-error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="paragraph-wrapper">
            @foreach ($author->paragraphs as $p)
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Title</label>
                                    <a href="#" class="btn btn-danger remove-parangraph" style="line-height: 0.4;padding:5px">X</a>
                                    <input type="text" class="form-control" name="titles[]" value="{{$p->title}}">
                                    <span data-input="titles" class="input-error"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Group</label>
                                    <select class="form-control" name="groups[]">
                                        @foreach (\App\Enums\AuthorParagraphGroup::all() as $key => $value)
                                            <option value="{{$key}}" @selected($p->group == $key)>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <span data-input="groups" class="input-error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Paragraph</label>
                                    <textarea name="texts[]" class="form-control summernote">{!!$p->text!!}</textarea>
                                    <span data-input="texts" class="input-error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.authors.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.add-paragraph').click(function(e) {
                e.preventDefault();
                let wraper = $('.paragraph-wrapper');
                let clone = $('.clone')
                    .clone()
                    .removeClass('d-none')
                    .removeClass('clone')
                    .appendTo(wraper)
                    .find('textarea')
                    .summernote();
            });

            $(document).on('click', '.remove-parangraph', function (e) {
                e.preventDefault();
                $(this).closest('.card').remove();
            })
        });
    </script>
@endpush