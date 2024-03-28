@extends('layouts.admin')

@section('content')
    <div class="container-fluid ">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="page-header-title">
                            @if (@$tournament)
                                Update
                            @else
                                Create
                            @endif Tournament
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('admin.tournaments.index') }}">Tournament
                                    List</a>
                            </li>
                            @if (@$tournament)
                                <li class="breadcrumb-item active">Update Tournament</li>
                            @else
                                <li class="breadcrumb-item active">Create Tournament</li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <form
            action="@if (@$tournament->id) {{ route('admin.tournaments.update', @$tournament->id) }} @else {{ route('admin.tournaments.store') }} @endif "
            method="post" enctype="multipart/form-data" id="tournament_form" name="tournament_form">
            @csrf
            @if (@$tournament->id)
                @method('PUT')
            @endif

            <div class="card col-md-8">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title">Title <span class="validation">*</span></label>
                                <input type="text" name="title" class="form-control" id="title" maxlength="35"
                                    placeholder="Title" value="{{ @$tournament->title }}">
                                @error('title')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputFile">Image <span class="validation">*</span></label>
                                <div class="">
                                    <input type="file" name="image" class="form-control" id="imgInp"
                                        accept="image/*" data-rule-required="true"
                                        data-msg-accept="Please upload file in these format only (jpg, jpeg, png)." />
                                    <input type="hidden" name="oldimage" class="form-control" id="image"
                                        placeholder="showphotos" value="{{ @$tournament->image }}">
                                </div>
                                @error('image')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <img id="blah"
                                style="border: 1px solid #adb5bd !important; border-radius: 13px !important;"
                                @if (@$tournament->image) src="{{ @$tournament->image }}"
                                    @else
                                        src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                onerror="this.src='{{ URL::asset('storage/default/img1.jpg') }}'" alt="Your Slider Image"
                                width="200px" height="150px" />
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title">Type <span class="validation">*</span></label>
                                <select name="type" id="type" class="form-control select2">
                                    <option value="">Select Type</option>
                                    <option value="0" selected >Past Tournament
                                    </option>
                                </select>
                            </div>
                            <span class="type_error" id="content_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="fom-group">
                                <label for="exampleInputFile">Description </label>
                                <textarea name="description" id="content" placeholder="Description" cols="20" rows="10" maxlength="250"
                                    class="form-control">{{ @$tournament->description }}</textarea>
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
                height: 500 // Set the height to 300 pixels
            });
        });

        $('select').prop('disabled', true);


        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');


        $("#tournament_form").validate({
            // ignore: [],
            rules: {
                title: {
                    required: true,
                },
                order: {
                    required: true,
                },
                type: {
                    required: true,
                },
                // description: {
                //     requiredSummernote: true,
                // },
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
                if (element.hasClass('select2') && element.next('.select2-container').length) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.hasClass('name_value')) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter(element);
                }
            }
        })
    </script>
@endsection
