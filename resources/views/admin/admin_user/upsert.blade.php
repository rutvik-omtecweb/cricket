@extends('layouts.admin')

@section('content')
    <div class="container-fluid ">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="page-header-title">
                            @if (@$user)
                                Update
                            @else
                                Create
                            @endif Admin User
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('admin.admin-user.index') }}">Admin-User List</a>
                            </li>
                            @if (@$user)
                                <li class="breadcrumb-item active">Update Admin-User </li>
                            @else
                                <li class="breadcrumb-item active">Create Admin-User </li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <form
            action="@if (@$user->id) {{ route('admin.admin-user.update', @$user->id) }} @else {{ route('admin.admin-user.store') }} @endif "
            method="post" enctype="multipart/form-data" id="user_form" name="user_form">
            @csrf
            @if (@$user->id)
                @method('PUT')
            @endif

            <div class="card col-md-8">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="user_name">User Name <span class="validation">*</span></label>
                                <input type="text" name="user_name" class="form-control" id="user_name" maxlength="100"
                                    placeholder="User Name" value="{{ @$user->user_name }}">
                                @error('user_name')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="first_name">First Name <span class="validation">*</span></label>
                                <input type="text" name="first_name" class="form-control" id="first_name" maxlength="100"
                                    placeholder="First Name" value="{{ @$user->first_name }}">
                                @error('first_name')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="last_name">Last Name <span class="validation">*</span></label>
                                <input type="text" name="last_name" class="form-control" id="last_name" maxlength="100"
                                    placeholder="Last Name" value="{{ @$user->last_name }}">
                                @error('last_name')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="last_name">Email <span class="validation">*</span></label>
                                <input type="email" name="email" class="form-control" id="email" maxlength="100"
                                    placeholder="Email" value="{{ @$user->email }}">
                                @error('emails')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="last_name">Phone <span class="validation">*</span></label>
                                <input type="number" name="phone" class="form-control" id="phone" min="0"
                                    placeholder="Email" value="{{ @$user->phone }}">
                                @error('phone')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if(@$user->id) 
                            
                        @else 
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="password">Password <span class="validation">*</span></label>
                                    <input type="password" name="password" class="form-control" id="password" min="0"
                                        placeholder="Password" value="{{ @$user->password }}">
                                    @error('password')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputFile">Image <span class="validation">*</span></label>
                                <div class="">
                                    <input type="file" name="image" class="form-control" id="imgInp"
                                        accept="image/*" data-rule-required="true"
                                        data-msg-accept="Please upload file in these format only (jpg, jpeg, png)." />
                                    <input type="hidden" name="oldimage" class="form-control" id="image"
                                        placeholder="showphotos" value="{{ @$user->image }}">
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
                                @if (@$user->image) src="{{ @$user->image }}"
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
                        <a href="{{ route('admin.admin-user.index') }}" class="btn btn-warning float-right mr-2">Back</a>
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

       

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');

        jQuery.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "Space are not allowed");



        $("#user_form").validate({
            normalizer: function(value) {
                return $.trim(value);
            },
            rules: {
                user_name: {
                    required: true,
                    noSpace: true
                },
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                phone: {
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
