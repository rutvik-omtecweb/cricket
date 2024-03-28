<!DOCTYPE html>
<html>
<head>

    <title>Admin Login</title>
    <meta name="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/png" href="#">
    <title>{{ @$sitenameto }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ @$favicon }}">
    <style>
        .login_body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .conter {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background: #ffffff;
            box-shadow: 0px 0px 14px 0px #00000040;
            padding: 40px;
            border-radius: 5px
        }

        .conter h1 {
            font-size: 26px;
            font-weight: 600;
            color: #181717;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .form-check {
            margin-top: 14px;
        }

        .conter form {
            padding: 0 40px;
            box-sizing: border-box;
        }

        form .txt_field {
            position: relative;
            margin: 6px 0 0px 0;
        }

        .txt_field input {
            padding: 10px;
            width: 300px;
            margin-top: 15px;
            margin-bottom: 7px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 400;
        }

        .txt_field label.error {
            color: red !important;
            ;
        }

        .txt_field span::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 0;
            width: 0%;
            height: 2px;
            background: #2691d9;
            transition: .5s;
        }

        .txt_field input:focus~label,
        .txt_field input:valid~label {
            top: -5px;
            color: #334257;
        }

        .txt_field input:focus~span::before,
        .txt_field input:valid~span::before {
            width: 100%;
        }

        .pass {
            margin: -5px 0 20px 5px;
            color: #a6a6a6;
            cursor: pointer;
        }

        .pass:hover {
            text-decoration: underline;
        }

        .submit {
            font-weight: 400;
            font-size: 14px;
            position: relative;
            line-height: normal;
            background: #f15f2a;
            text-transform: uppercase;
            padding: 10px 30px;
            color: #fff;
            transition: all 0.5s ease;
            -webkit-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            -ms-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            overflow: hidden;
            z-index: 1;
            letter-spacing: 1.12px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            margin-top: 10px;
        }

        .submit:hover {
            background: #000;
        }

        .btn.btn-primary.submit:hover {
            border-color: #2691d9 transparent 0.5s;
        }

        .signup_link {
            margin: 30px;
            text-align: center;
            font-size: 16px;
            color: #666666;
        }

        .signup_link a {
            color: #2691d9;
            text-decoration: none;
        }

        .signup_link a:hover {
            text-decoration: underline;
        }

        .invalid-feedback {
            color: red;
        }

        .btn-refresh {
            background-color: #2691d9;
            color: white;
            border: 1px solid;
            height: 25px;
            width: 34px;
            margin-left: 10px;
        }

        .captcha {
            margin-top: 20px;
        }

        .login-div {
            text-align: center;
        }

        .vendor-login {
            float: right;
            margin-top: 12px;
            text-decoration: none;
            color: #685ab1;
            font-weight: 600;
        }

        .vendor-login:hover {
            color: #000;
        }

        .icon {
            text-align: center;
        }

        .validate {
            color: red;
        }

        body.login_body.admin_body {
            background-image: url(../storage/admin/assets/dist/img/admin1.jpg)
        }

    </style>

</head>

<body class="login_body admin_body"
    style="background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="conter">
        <div class="icon">
            {{-- <a class="site-logo site-title" href="{{ route('customer.welcome') }}"><img src="{{ $logo }}" alt=""
                style="height: 108px;"></a> --}}
        </div>
        <h1>Admin Sign In</h1>
        <form method="POST" action="{{ route('admin.login') }}" id="loginform">
            @csrf
            <div class="txt_field">
                <label>Email <span class="validate">*</span></label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" autocomplete="email" autofocus>

            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="txt_field">
                <label>Password <span class="validate">*</span></label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" autofocus>

            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="form-control-error">
                @if (Session::has('message'))
                <p style="color: red; padding: 21px 10px 10px 3px; margin:0;">
                    {{ Session::get('message') }}</p>
                @endif
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p style="color: red; padding: 21px 10px 10px 3px; margin:0;">
                    {{ $error }}</p>
                @endforeach
                @endif
            </div>

            <button type="submit" class="btn btn-primary submit">
                {{ __('Login') }}
            </button>
        </form>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>

    <script>
        $(document).ready(function () {

            //validation
            $("#loginform").validate({
                ignore: [],
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    },
                },
            })
        });

    </script>
</body>

</html>
