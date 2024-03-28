<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Northren Alberta Cricket Association · Register</title>
    <link href="{{ asset('storage/frontend/assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('storage/frontend/assets/dist/css/animate.min.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/50dac43d5e.js" crossorigin="anonymous"></script>
    <link href="{{ asset('storage/frontend/assets/dist/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/frontend/assets/dist/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('storage/frontend/assets/dist/plugins/toastr/toastr.min.css') }}">

    <style>
        .step-content {
            display: none;
        }


        .step-content.active {
            display: block;
        }

        .step-indicator {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .step-indicator li {
            width: 100px;
            height: 35px;
            border: 2px solid #ccc;
            border-radius: 10px;
            margin: 0 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            font-weight: bold;
            color: #ccc;
        }

        .register-box {
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
            padding: 20px;
            margin-top: 36px;
        }

        .step-indicator li.active {
            border-color: #0A2D7C;
            color: #0A2D7C;
        }

        .image-preview {
            width: 53%;
            height: 80%;
            object-fit: cover;
            display: none;
        }

        .select2-container .select2-selection--single {
            width: 100% !important;
            height: 38Px !important;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
</head>

<body>
    <section class="login register">
        <div class="container">

            <div class="row vertical-center">
                <div class="position-relative">
                    <a href="{{ route('home') }}" class="btn-back d-block"><img
                            src="{{ asset('storage/frontend/assets/dist/images/btn-arrow-back.png') }}"
                            alt=""></a>
                    <h2 class="mainhead">Welcome <span>WELCOME</span></h2>
                    <p class="text-center" style="font-size: 22px;">Register</p>
                    <div class="row justify-content-center my-4">
                        <ul class="step-indicator">
                            <li class="active">Step 1</li>
                            <li>Step 2</li>
                        </ul>
                        <div class="col-12 col-sm-10 col-md-10 col-lg-10 register-box">
                            <form id="registerFrom" method="POST" action="{{ route('register.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="step-content active mt-3" id="step-1">
                                    <div class="form-group row g-3 pb-3">
                                        <div class="col-sm-4">
                                            <label for="user_name" class="form-label login-label">Username</label>
                                            <input type="text" name="user_name" class="form-control login-input"
                                                id="user_name" placeholder="Username" maxlength="25">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="first_name" class="form-label login-label">First name</label>
                                            <input type="text" name="first_name" class="form-control login-input"
                                                id="first_name" placeholder="First name" maxlength="35">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="last_name" class="form-label login-label">Last name</label>
                                            <input type="text" name="last_name" class="form-control login-input"
                                                id="last_name" placeholder="Last name" maxlength="35">
                                        </div>
                                    </div>
                                    <div class="form-group row g-3 pb-3">
                                        <div class="col-sm-4">
                                            <label for="gender" class="form-label login-label">Gender</label>
                                            <select class="form-select select2" name="gender" id="gender"
                                                aria-label="Default select example">
                                                <option value="">Select gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="dob" class="form-label login-label">Birth
                                                Date</label>
                                            <input type="date" name="dob" class="form-control login-input"
                                                id="dob" placeholder="Birth Date">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="phone" class="form-label login-label">Mobile Number</label>
                                            <input type="number" name="phone" class="form-control login-input"
                                                id="phone" placeholder="Mobile number">
                                        </div>
                                    </div>
                                    <div class="form-group row g-3 pb-3">

                                        <div class="col-sm-6">
                                            <label for="address" class="form-label login-label">Address</label>
                                            <input type="address" name="address"
                                                class="form-control login-input login-input" id="address"
                                                placeholder="Address">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="city" class="form-label login-label">City</label>
                                            <input type="text" name="city" class="form-control login-input"
                                                id="city" placeholder="City" value="Fort McMurray" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row g-3 pb-3">

                                        <div class="col-sm-6">
                                            <label for="state" class="form-label login-label">State</label>
                                            <input type="text" name="state" class="form-control login-input"
                                                id="state" placeholder="State" value="Alberta" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="postal_code" class="form-label login-label">Postal
                                                Code</label>
                                            <input type="text" name="postal_code" class="form-control login-input"
                                                id="postal_code" placeholder="Postal code">
                                        </div>

                                    </div>
                                    <div class="form-group row g-3 pb-3">
                                        <div class="col-sm-4">
                                            <label for="email" class="form-label login-label">E-mail
                                                Address</label>
                                            <input type="email" name="email" class="form-control login-input"
                                                id="email" placeholder="E-mail address">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="password" class="form-label login-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                id="password" placeholder="Password">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="c_password" class="form-label login-label">Confirm
                                                Password</label>
                                            <input type="password" name="c_password" class="form-control"
                                                id="c_password" placeholder="Confirm password">
                                        </div>
                                    </div>
                                    <div class="form-group text-end">
                                        <button type="button" class="btn btn-primary next-btn">Next</button>
                                    </div>
                                </div>
                                <div class="step-content" id="step-2">
                                    <div class="form-group row g-3 pb-3">
                                        <div class="col-sm-6">
                                            <label for="user_name" class="form-label login-label">Upload Health
                                                Card</label>
                                            <input type="file" class="form-control" name="verification_id_1"
                                                id="verification_id_1" accept="image/*" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="image-preview-box mt-2">
                                                <img src="#" alt="Health Image"
                                                    class="img-thumbnail image-preview" id="health_image_preview">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row g-3 pb-3">
                                        <div class="col-sm-6">
                                            <input type="file" class="form-control" name="verification_id_2"
                                                id="verification_id_2" accept="image/*" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="image-preview-box mt-2">
                                                <img src="#" alt="Card Image"
                                                    class="img-thumbnail image-preview" id="card_image_preview">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row g-3 pb-3">
                                        <div class="col-sm-6">
                                            <input type="file" class="form-control" name="verification_id_3"
                                                id="verification_id_3" accept="image/*" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="image-preview-box mt-2">
                                                <img src="#" alt="Medical Image"
                                                    class="img-thumbnail image-preview" id="medical_image_preview">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" name="living_rmwb_for_3_month"
                                            class="form-check-input" id="living_rmwb_for_3_month">
                                        <label class="form-check-label" for="living_rmwb_for_3_month">I am living in
                                            RMWB region
                                            for
                                            3 months or more.</label>
                                    </div>
                                    <span id="living_error"></span>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" name="not_member_of_cricket" class="form-check-input"
                                            id="not_member_of_cricket">
                                        <label class="form-check-label" for="not_member_of_cricket">I am not member of
                                            any
                                            other
                                            cricket league / association in Alberta</label>
                                    </div>
                                    <span id="not_member_error"></span>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" name="remember_token" class="form-check-input"
                                            id="remember_token">
                                        <label for="remember_token">Agree with the <button type="button"
                                                style="background-color: transparent; color: #859fff; border: none;"
                                                onclick="showModal()">NACA terms and conditions</button></label>
                                    </div>
                                    <span id="condition_error"></span>
                                    <div class="d-gridcol-6 text-end">
                                        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                                        <button type="submit" class="btn btn-primary">Payment</button>
                                    </div>
                                    <div class="mb-3 p-3 text-end">
                                        I have an account <a href="{{ route('login') }}"> Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- model :start --}}
        <div id="myModal" class="modal main-tearms" tabindex="-1" data-backdrop="static" role="dialog">
            <div class="modal-dialog" role="document" style="width: 800px; max-width:800px;">
                <div class="modal-content">
                    <div class="container">
                        <h2 class="heading_title text-center mt-2 " style="color: #0A2D7C;">Terms & Conditions</h2>
                    </div>
                    <hr class="text-primary">
                    <div class="container" id="main_content">

                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="hideModal()" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- model :end --}}

    </section>

    <script src="{{ asset('storage/frontend/assets/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src="{{ asset('storage/frontend/assets/dist/js/main.js') }}"></script>
    <script src="{{ asset('storage/frontend/assets/dist/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('storage/frontend/assets/dist/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('storage/frontend/assets/dist/plugins/toastr/toastr.min.js') }}"></script>


    <script>
        $(".select2").select2();
        $(document).ready(function() {
            $('.next-btn').click(function() {
                if (form.valid()) { // Check if the current step is valid before proceeding
                    $(this).closest('.step-content').removeClass('active').next().addClass('active');
                    updateStepIndicator();
                }
            });

            $('.prev-btn').click(function() {
                $(this).closest('.step-content').removeClass('active').prev().addClass('active');
                updateStepIndicator();
            });

            function updateStepIndicator() {
                // $('.step-indicator li').removeClass('active');
                // $('.step-content.active').prevAll().length++;
                // $('.step-indicator li').eq($('.step-content.active').prevAll().length).addClass('active');
                $('.step-indicator li').removeClass('active');
                var activeStepIndex = $('.step-content').index($('.step-content.active'));
                $('.step-indicator li').eq(activeStepIndex).addClass('active');
            }

            $('#verification_id_1').change(function() {
                readURL(this, '#health_image_preview');
            });

            $('#verification_id_2').change(function() {
                readURL(this, '#card_image_preview');
            });

            $('#verification_id_3').change(function() {
                readURL(this, '#medical_image_preview');
            });

            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1000000)
            }, 'File size must be less than {0} MB');


            var form = $('#registerFrom');
            form.validate({
                errorClass: 'text-danger',
                rules: {
                    user_name: 'required',
                    first_name: 'required',
                    last_name: 'required',
                    gender: 'required',
                    inputAddressLine1: 'required',
                    dob: 'required',
                    phone: 'required',
                    email: {
                        required: true,
                        email: true
                    },
                    address: 'required',
                    postal_code: 'required',
                    password: {
                        required: true,
                        minlength: 8
                    },
                    c_password: {
                        required: true,
                        equalTo: '#password' // Ensure that c_password matches the password field
                    },
                    verification_id_1: {
                        required: true,
                        filesize: 2 // Max file size in MB
                    },
                    verification_id_2: {
                        required: true,
                        filesize: 2 // Max file size in MB
                    },
                    verification_id_3: {
                        required: true,
                        filesize: 2 // Max file size in MB
                    },
                    living_rmwb_for_3_month: 'required',
                    not_member_of_cricket: 'required',
                    remember_token: 'required'
                },
                messages: {
                    c_password: {
                        equalTo: 'Passwords do not match'
                    },
                    verification_id_1: {
                        required: "Please select a file.",
                        filesize: "File size must be less than 2 MB."
                    },
                    verification_id_2: {
                        required: "Please select a file.",
                        filesize: "File size must be less than 2 MB."
                    },
                    verification_id_3: {
                        required: "Please select a file.",
                        filesize: "File size must be less than 2 MB."
                    },
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2') && element.next('.select2-container').length) {
                        error.insertAfter(element.next('.select2-container'));
                    } else if (element.hasClass('name_value')) {
                        error.insertAfter(element);
                    } else if (element.attr("name") == "living_rmwb_for_3_month") {
                        error.appendTo('#living_error');
                    } else if (element.attr("name") == "not_member_of_cricket") {
                        error.appendTo('#not_member_error');
                    } else if (element.attr("name") == "remember_token") {
                        error.appendTo('#condition_error');
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    // form.submit();
                    event.preventDefault();

                    // Get form data
                    // var formData = $(form).serialize();
                    var formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('register.store') }}",
                        type: "POST",
                        contentType: 'multipart/form-data',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            // Handle successful response
                            console.log("response", response);
                            if (response.url) {
                                window.location.href = response.url;
                            } else {
                                console.log("here");
                                if (response.status == false) {
                                    console.log("here333");
                                    toastr.error(response.message);
                                }
                                console.error('Missing "url" property in the response.');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error("xhr.responseText");
                            console.log("error", error);
                        }
                    });
                }
            });


        });

        //preview images
        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(previewId).attr('src', e.target.result);
                    $(previewId).show(); // Show the image preview
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        //open term and coditional model
        function showModal() {
            $('#myModal').modal('show');
            tearmsCondition();
        }

        //call for term & condition content
        function tearmsCondition() {
            $.ajax({
                type: "GET",
                url: "{{ route('member.terms.condition') }}",
                data: null,
                success: function(response) {
                    let data = response.cms;
                    let html = "";
                    data?.map((item) => {
                        html += '<div>' + item.body + '</div>';
                    })
                    $('#myModal #main_content').html(html)
                }
            });
        }

        //hide model
        function hideModal() {
            $('#myModal').modal('hide');
        }

        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif

        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
    </script>

</body>

</html>
