<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Northren Alberta Cricket Association · Resent Verification</title>
    <link href="{{ asset('storage/frontend/assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/frontend/assets/dist/css/animate.min.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/50dac43d5e.js" crossorigin="anonymous"></script>
    <link href="{{ asset('storage/frontend/assets/dist/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('storage/frontend/assets/dist/plugins/toastr/toastr.min.css') }}">
</head>

<body>
    <section class="login">
        <div class="container">
            <div class="row vertical-center">
                <div class="position-relative">
                    <h2 class="mainhead" <span>Resent Verification</span></h2>
                    <div class="row justify-content-center my-4">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <form action="{{ route('user.resent.verification.send') }}" method="post"
                                id="verificationForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="login-label form-label ">
                                        E-mail</label>
                                    <input type="text" class="form-control login-input" name="email"
                                        id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter E-mail">
                                    <div id="emailHelp" class="form-text">
                                    </div>
                                    @error('login')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-grid gap-2 pt-4">
                                    <input type="submit" class="btn btn-primary d-block default-btn" value="Submit">
                                </div>

                                <div class="mb-3 p-3 text-center">
                                    Already have an account? <a href="{{ route('login') }}"> Sign In</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    {{-- <script src="{{ asset('storage/frontend/assets/dist/js/jquery.validate.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script src="{{ asset('storage/frontend/assets/dist/js/main.js') }}"></script>
    <script src="{{ asset('storage/frontend/assets/dist/plugins/toastr/toastr.min.js') }}"></script>
    <script>
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
    <script>
        $("#verificationForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
            },
        })
    </script>
</body>


</html>
