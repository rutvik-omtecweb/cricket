@extends('layouts.admin')
@section('style')
    <style>
        .error {
            color: red
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-xl-8 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h4 class="card-title">Basic Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update') }}" id="profile_from" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="first_name">User Name <span
                                                class="text-red">*</span></label>
                                        <input type="text" id="user_name" class="form-control" name="user_name"
                                            placeholder="Enter user name" value="{{ $data['user_name'] }}" maxlength="30">
                                        @error('user_name')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="first_name">First Name <span
                                                class="text-red">*</span></label>
                                        <input type="text" id="first_name" class="form-control" name="first_name"
                                            placeholder="Enter first name" value="{{ $data['first_name'] }}" maxlength="30">
                                        @error('first_name')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="last_name">Last Name <span
                                                class="text-red">*</span></label>
                                        <input type="text" id="last_name" class="form-control" name="last_name"
                                            placeholder="Enter last name" value="{{ $data['last_name'] }}" maxlength="30">
                                        @error('last_name')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="text" id="email" class="form-control" readonly name="email"
                                            placeholder="Email address" value="{{ $data['email'] }}">
                                        @error('email')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="phone">Phone <span
                                                class="text-red">*</span></label>
                                        <input type="phone" id="phone" class="form-control" name="phone"
                                            min="0" placeholder="Enter phone number" value="{{ $data['phone'] }}">
                                        @error('phone')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="image">Profile Image</label>
                                        <input type="file" class="form-control" name="image" style="height: 42px"
                                            id="imgInp">
                                        <input type="hidden" name="oldimage" class="form-control" id="image"
                                            value="{{ $data['image'] }}">
                                        @error('image')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mt-2 text-right">
                                        <button type="submit" class="btn btn-primary">Update Profile </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- image preview :start --}}
            <div class="col-12 col-xl-4 col-lg-12 col-md-12 col-sm-12" id="imgPreview">
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">Admin Profile Perview</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex" style="justify-content: center">
                            <img id="blah"
                                @if (@$data['image']) src="{{ @$data['image'] }}"
                                            @else
                                                src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                onerror="this.src='{{ URL::asset('storage/admin/default/img1.jpg') }}'"
                                alt="Your Slider Image" width="150px" height="150px" />
                        </div>
                    </div>
                </div>
            </div>
            {{-- image preview :end --}}

        </div>
        <div class="row">
            <div class="col-12 col-xl-6 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h4 class="card-title">Change Your Password</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.password.update') }}" id="update_password_form" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="current_password">Current Password <span
                                                class="validation">*</span></label>
                                        <input type="password" name="current_password" class="form-control"
                                            id="current_password" placeholder="Current password"
                                            value="{{ old('current_password') }}">
                                        @error('current_password')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="password">New Password<span class="validation">*</span></label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="New password" value="{{ old('password') }}">
                                        @error('password')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm New Password <span
                                                class="validation">*</span></label>
                                        <input type="password" name="confirm_password" class="form-control"
                                            id="confirm_password" placeholder="Confirm new password"
                                            value="{{ old('confirm_password') }}">
                                        @error('confirm_password')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mt-2 text-right">
                                        <button type="submit" class="btn btn-primary">Update Password </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        // Image preview functionality: start
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
        // Image preview functionality: end


        $(document).ready(function() {

            //check for file size
            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1000000)
            }, 'File size must be less than {0} MB');

            $.validator.addMethod("checklower", function(value) {
                return /[a-z]/.test(value);
            });
            $.validator.addMethod("checkupper", function(value) {
                return /[A-Z]/.test(value);
            });

            // Profile form validation
            $("#profile_from").validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    user_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    email: {
                        required: true,
                    },
                    image: {
                        extension: "jpg|jpeg|png",
                        filesize: 3
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2') && element.next('.select2-container').length) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element)
                    }
                },
                messages: {
                    image: {
                        extension: "Please image upload in jpg, jpeg and png",
                    },
                }
            })

            //password validation
            $('#update_password_form').validate({
                rules: {
                    current_password: {
                        required: true,
                        // minlength: 8,
                        maxlength: 16
                    },
                    password: {
                        required: true,
                        // minlength: 8,
                        maxlength: 16,
                        checklower: true,
                        checkupper: true,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    confirm_password: {
                        equalTo: "Please enter the same password as new password"
                    },
                    password: {
                        checklower: "Need atleast 1 lowercase alphabet.",
                        checkupper: "Need atleast 1 uppercase alphabet.",
                    },
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2') && element.next('.select2-container').length) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element)
                    }
                },
            })

            $('#confirm_password').on('paste copy', function(e) {
                e.preventDefault();
            });
        });
    </script>
@endsection
