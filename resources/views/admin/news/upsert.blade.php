@extends('layouts.admin')

@section('content')
<div class="container-fluid ">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="page-header-title">
                        @if (@$news)
                        Update
                        @else
                        Create
                        @endif News
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('admin.news.index') }}">News List</a>
                        </li>
                        @if (@$news)
                        <li class="breadcrumb-item active">Update News</li>
                        @else
                        <li class="breadcrumb-item active">Create News</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <form action="@if (@$news->id) {{ route('admin.news.update', ['news' => @$news->id]) }} @else {{ route('admin.news.store') }} @endif " method="post" enctype="multipart/form-data" id="news_form" name="news_form">
        @csrf
        @if (@$news->id)
        @method('PUT')
        @endif

        <div class="card col-md-6">
            <div class="card-body">
                <div class="row ">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="news_name">Name <span class="validation">*</span></label>
                            <input type="text" name="news_name" class="form-control" id="news_name" maxlength="100" placeholder="Name" value="{{ @$news->news_name }}">
                            @error('news_name')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputFile">Image <span class="validation">*</span></label>
                            <div class="">
                                <input type="file" name="image" class="form-control" id="imgInp" accept="image/*" data-rule-required="true" data-msg-accept="Please upload file in these format only (jpg, jpeg, png)." />
                                <input type="hidden" name="oldimage" class="form-control" id="image" placeholder="showphotos" value="{{ @$news->image }}">
                            </div>
                            @error('image')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <img id="blah" style="border: 1px solid #adb5bd !important; border-radius: 13px !important;" @if (@$news->image) src="{{ @$news->image }}"
                        @else
                        src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                        onerror="this.src='{{ URL::asset('storage/default/img1.jpg') }}'" alt="Your Slider Image"
                        width="200px" height="150px" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="fom-group">
                            <label for="exampleInputFile">Description <span class="validation">*</span></label>
                            <textarea name="description" id="description" placeholder="Description" cols="20" rows="10" class="form-control">{{ @$news->description }}</textarea>
                            <span id="description_error" class="error"></span>

                            @error('description')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <span class="content_error" id="content_error"></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary float-right">
                        Submit
                    </button>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-warning float-right mr-2">Back</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }

    $(function() {
        $('#description').summernote({
            height: 350 // Set the height to 300 pixels
        });
    });


    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param * 1000000)
    }, 'File size must be less than {0} MB');

    jQuery.validator.addMethod("requiredSummernote", function() {
        return !($("#description").summernote('isEmpty'));
    }, 'This field is required');

    $("#news_form").validate({
        ignore: [],
        rules: {
            news_name: {
                required: true,
            },
            description: {
                requiredSummernote: true
            },
            image: {
                required: function() {
                    var image = $('#image').val();
                    return image == null || image == "" || image == undefined;
                },
                extension: "jpg|jpeg|png",
                filesize: 2
            },
        },
        messages: {
            image: {
                extension: "Please image upload in jpg, jpeg and png",
            },
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "description") {
                error.appendTo('#description_error');
            } else {
                error.insertAfter(element);
            }
        }
    })
</script>
@endsection