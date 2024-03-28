@extends('layouts.admin')

@section('content')
    <div class="container-fluid ">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="page-header-title">
                            Create Banner
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('admin.banners.index') }}">Banner List</a>
                            </li>
                            <li class="breadcrumb-item active">Create Banner</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <form action="{{ route('admin.banners.store') }}" method="post" enctype="multipart/form-data" id="banner_form"
            name="banner_form">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">Title <span class="validation">*</span></label>
                                <input type="text" name="title" class="form-control" id="title" maxlength="35"
                                    placeholder="Title">
                                @error('title')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order">Order <span class="validation">*</span></label>
                                <input type="number" name="order" class="form-control" id="order" placeholder="Order"
                                    min="0">
                                @error('order')
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
                                    <input type="file" name="image" class="form-control" id="imgInp"
                                        accept="image/*" data-rule-required="true"
                                        data-msg-accept="Please upload file in these format only (jpg, jpeg, png)." />
                                </div>
                                @error('image')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="fom-group">
                                <label for="exampleInputFile">Description <span class="validation">*</span></label>
                                <textarea name="description" id="content" placeholder="Description" cols="20" rows="5" maxlength="250"
                                    class="form-control"></textarea>
                                @error('description')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="content_error" id="content_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <img id="blah"
                                style="border: 1px solid #adb5bd !important; border-radius: 13px !important;"
                                @if (@$banner->image) src="{{ @$banner->image }}"
                                    @else
                                        src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                onerror="this.src='{{ URL::asset('storage/default/img1.jpg') }}'" alt="Your Slider Image"
                                width="200px" height="150px" />
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary float-right">
                            Submit
                        </button>
                        <a href="{{ URL::previous() }}" class="btn btn-warning float-right mr-2">Back</a>
                    </div>
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
            $('#content').summernote()
        })

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');

        $("#banner_form").validate({
            ignore: [],
            rules: {
                banner_name: {
                    required: true,
                },
                link: {
                    required: true,
                    url: true
                },
                order: {
                    required: true,
                },
                title: {
                    required: true,
                },
                description: {
                    required: true,
                },
                image: {
                    required: function() {
                        var image = $('#image').val();
                        return image == null || image == "" || image == undefined;
                    },
                    extension: "jpg|jpeg|png",
                    filesize: 2
                },
                text: {
                    required: true,
                },
                description: {
                    required: true
                }
            },
            errorPlacement: function(error, element) {
                if (element.is('textarea')) {
                    error.appendTo('#content_error');
                } else {
                    error.insertAfter(element);
                }
            },
            messages: {
                image: {
                    extension: "Please image upload in jpg, jpeg and png",
                },
            },
        })
    </script>
@endsection
