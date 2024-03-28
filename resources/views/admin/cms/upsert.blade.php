@extends('layouts.admin')
@section('links')
    <style>
        .note-editor.note-frame.card button {
            color: #000;
        }

        .note-editable.card-block {
            max-height: 300px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid ">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="page-header-title">
                            @if (@$cms_page)
                                Update
                            @else
                                Create
                            @endif Cms Page
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('admin.cms.index') }}">Cms Page</a></li>
                            @if (@$cms_page)
                                <li class="breadcrumb-item active">Update Cms Page </li>
                            @else
                                <li class="breadcrumb-item active">Create Cms Page </li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <form
            action="@if (@$cms_page->id) {{ route('admin.cms.update', @$cms_page->id) }} @else {{ route('admin.cms.store') }} @endif "
            method="post" enctype="multipart/form-data" id="cmspageform">
            @csrf
            @if (@$cms_page->id)
                @method('PUT')
            @endif
            <div class="card col-6">

                <div class="card-body">
                    <input type="text" name="id" value="{{ @$cms_page->id }}" hidden="">
                    <div class="row">
                        <div class="" id="here">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cms_page_name">Name <span class="validation">*</span></label>
                                        <input type="text" name="cms_page_name" class="form-control" id="cms_page_name"
                                            maxlength="30" placeholder="Name"
                                            value="{{ old('cms_page_name', @$cms_page->cms_page_name) }}">
                                        @error('cms_page_name')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Url <span class="validation">*</span></label>
                                        <input type="text" id="url" class="form-control" name="url"
                                            placeholder="Url" value="{{ old('url', @$cms_page->url) }}">
                                        @error('url')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Title <span class="validation">*</span></label>
                                        <input type="text" id="meta_title" class="form-control" name="meta_title"
                                            maxlength="60" placeholder="Meta title"
                                            value="{{ old('meta_title', @$cms_page->meta_title) }}">
                                        @error('meta_title')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Tag <span class="validation">*</span></label>
                                        <input type="type" id="meta_tag" class="form-control" name="meta_tag"
                                            maxlength="160" placeholder="Meta tag"
                                            value="{{ old('meta_tag', @$cms_page->meta_tag) }}">
                                        @error('meta_tag')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Tag Keyword <span
                                                class="validation">*</span></label>
                                        <input type="text" id="meta_tag_keyword" class="form-control"
                                            name="meta_tag_keyword" maxlength="160" placeholder="Meta tag keyword"
                                            value="{{ old('meta_tag_keyword', @$cms_page->meta_tag_keyword) }}">
                                        @error('meta_tag_keyword')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Description <span
                                                class="validation">*</span></label>
                                        <input type="meta_description" id="meta_description" class="form-control"
                                            name="meta_description" maxlength="160" placeholder="Meta description"
                                            value="{{ old('meta_description', @$cms_page->meta_description) }}">
                                        @error('meta_description')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="body">Content <span class="validation">*</span></label>
                                        <textarea id="body" class="form-control" name="body" placeholder="Body">
@if (!empty(@$cms_page->body))
{{ @$cms_page->body }}
@elseif(old('body'))
{{ old('body') }}
@endif
</textarea>
                                        <span id="content_error"></span>
                                        @error('body')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">
                                @if (@$cms_page->id)
                                    Update
                                @else
                                    Submit
                                @endif
                            </button>
                            <a href="{{ route('admin.cms.index') }}" class="btn btn-warning float-right mr-2">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var t = $('#body').summernote({
                height: 350,
                focus: true
            });
            $("#btn").click(function() {
                $('div.note-editable').height(150);
            });
        });

        //for body editor
        $(function() {
            $('#body').summernote()
        })

        jQuery.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "Space are not allowed");

        //validation
        $("#cmspageform").validate({
            ignore: [],
            normalizer: function(value) {
                return $.trim(value);
            },
            rules: {
                cms_page_name: {
                    required: true,
                },
                body: {
                    required: true,
                },
                url: {
                    required: true,
                    noSpace: true,
                },
                meta_title: {
                    required: true,
                },
                meta_tag: {
                    required: true,
                },
                meta_tag_keyword: {
                    required: true,
                },
                meta_description: {
                    required: true,
                },

            },
            errorPlacement: function(error, element) {
                if (element.is('textarea')) {
                    error.appendTo('#content_error');
                } else {
                    error.insertAfter(element);
                }
            }
        })
    </script>
@endsection
