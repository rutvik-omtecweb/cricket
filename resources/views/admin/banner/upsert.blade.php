@extends('layouts.admin')

@section('content')
    <div class="container-fluid ">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="page-header-title">
                            @if (@$banner)
                                Update
                            @else
                                Create
                            @endif Banner
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('admin.banners.index') }}">Banner List</a>
                            </li>
                            @if (@$banner)
                                <li class="breadcrumb-item active">Update Banner</li>
                            @else
                                <li class="breadcrumb-item active">Create Banner</li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <form
            action="@if (@$banner->id) {{ route('admin.banners.update', ['banner' => @$banner->id]) }} @else {{ route('admin.banners.store') }} @endif "
            method="post" enctype="multipart/form-data" id="banner_form" name="banner_form">
            @csrf
            @if (@$banner->id)
                @method('PUT')
            @endif

            <div class="card col-md-6">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">Title <span class="validation">*</span></label>
                                <input type="text" name="title" class="form-control" id="title" maxlength="50"
                                    placeholder="Title" value="{{ @$banner->title }}">
                                @error('title')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 order-banner">
                            <div class="form-group">
                                <label for="order">Order <span class="validation">*</span></label>
                                <input type="number" name="order" class="form-control" id="order" placeholder="Order"
                                    min="0" value="{{ @$banner->order }}">
                                </div>
                                @error('order')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputFile">Image <span class="validation">*</span></label>
                                <div class="">
                                    <input type="file" name="image" class="form-control" id="imgInp"
                                        accept="image/*" data-rule-required="true"
                                        data-msg-accept="Please upload file in these format only (jpg, jpeg, png)." />
                                    <input type="hidden" name="oldimage" class="form-control" id="image"
                                        placeholder="showphotos" value="{{ @$banner->image }}">
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
                        <div class="col-md-8">
                            <div class="fom-group">
                                <label for="exampleInputFile">Description </label>
                                <textarea name="description" id="content" placeholder="Description" cols="20" rows="10" maxlength="250"
                                    class="form-control">{{ @$banner->description }}</textarea>
                                <span id="description_error" class="error"></span>

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
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary float-right">
                            Submit
                        </button>
                        <a href="{{ URL::previous() }}" class="btn btn-warning float-right mr-2">Back</a>
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
            $('#content').summernote({
                height: 300 // Set the height to 300 pixels
            });
        });


        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');

        $("#banner_form").validate({
            ignore: [],
            rules: {
                title: {
                    required: true,
                },
                order: {
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
            },
            messages: {
                image: {
                    extension: "Please image upload in jpg, jpeg and png",
                },
            },
        })
    </script>
@endsection
