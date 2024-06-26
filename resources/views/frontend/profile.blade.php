@extends('layouts.app')
@section('title', 'Profile')
@section('links')
    <link href="{{ asset('storage/frontend/assets/dist/css/style.css') }}" rel="stylesheet">
    <style>
        .tab-content.accordion {
            box-shadow: 0px 0px 14px 0px rgba(0, 0, 0, 0.25);
            padding: 20px;
            border-radius: 12px;
        }

        .table tbody td.status span.event.on-hold {
            background: #64645e;
        }

        span.validation {
            color: red;
        }

        label.error {
            padding-top: 5px;
            color: red;
            font-weight: 300 !important;
            font-size: 14px;
        }

        .form-control {
            color: var(--bs-body-color) !important;
        }
    </style>
@endsection
@section('content')

    <section class="breadcrumbs"
        style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>PROFILE<br> </h2>
        </div>
    </section>
    <main>
        <section class="myaccount checkout section-padding data-body">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-12">
                        <div class="tabbable-panel">
                            <div class="tabbable-line faq-accordion">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#tab_default_1" data-toggle="tab" class="active">Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="#tab_default_5" data-toggle="tab">Account Detail</a>
                                    </li>
                                    <li>
                                        <a href="#tab_default_3" data-toggle="tab"> Payment Detail</a>
                                    </li>
                                    {{-- <li>
                                        <a href="#tab_default_4" data-toggle="tab">Event Payment Detail</a>
                                    </li> --}}
                                </ul>
                                <div class="tab-content accordion">
                                    <div class="tab-pane accordion__panel active" id="tab_default_1">
                                        <p>Hello, {{ @$user->first_name }} {{ @$user->last_name }}</p>
                                        <p>From your account dashboard.</p>
                                    </div>

                                    <div class="tab-pane accordion__panel" id="tab_default_3">
                                        <h4 style="background-color: beige;">Member Register Payment Detail</h4>
                                        <div class="register-payment">
                                            <table id="cart" class="table table-hover table-condensed">
                                                <thead>
                                                    <tr>
                                                        {{-- <th style="width:15%"></th> --}}
                                                        <th style="width:15%">Date</th>
                                                        <th style="width:15%">Status</th>
                                                        <th style="width:10%">Price</th>
                                                        <th style="width:10%">Payment Type</th>
                                                        <th style="width:10%">Expiration Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($user_payment))
                                                        <tr>
                                                            <td data-th="date">
                                                                {{ \Carbon\Carbon::parse($user_payment->created_at)->format('d-M-Y, g:i A') }}
                                                            </td>
                                                            <td data-th="status" class="status">
                                                                <span
                                                                    @if ($user_payment->status == 'success') class="approved" @elseif ($user_payment->status == 'pending') class="on-hold" @else class="pending" @endif>
                                                                    {{ $user_payment->status }}</span>
                                                            </td>
                                                            <td data-th="Price" class="">${{ $user_payment->amount }}
                                                            </td>
                                                            <td data-th="Price" class=""
                                                                style="
                                                            text-transform: uppercase;
                                                        ">
                                                                {{ $user_payment->payment_type }}</td>
                                                            <td data-th="" class="">
                                                                {{ $user_payment->expired_date }}
                                                            </td>

                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="4">Payment Detail Not Found !!</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        @if (!empty($player_payment))
                                            <div class="register-payment mt-4">
                                                <h4 style="background-color: beige;">Player Payment Detail</h4>
                                                <table id="cart" class="table table-hover table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:15%">Date</th>
                                                            <th style="width:15%">Status</th>
                                                            <th style="width:10%">Price</th>
                                                            <th style="width:10%">Payment Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (isset($player_payment))
                                                            <tr>
                                                                {{-- <td data-th="number">1</td> --}}
                                                                <td data-th="date">
                                                                    {{ \Carbon\Carbon::parse($player_payment->created_at)->format('d-M-Y, g:i A') }}
                                                                </td>
                                                                <td data-th="status" class="status">
                                                                    <span
                                                                        @if ($player_payment->status == 'success') class="approved" @elseif ($player_payment->status == 'pending') class="on-hold" @else class="pending" @endif>
                                                                        {{ $player_payment->status }}</span>
                                                                </td>
                                                                <td data-th="Price" class="">
                                                                    ${{ $player_payment->amount }}
                                                                </td>
                                                                <td data-th="Price" class=""
                                                                    style="
                                                            text-transform: uppercase;
                                                        ">
                                                                    {{ $player_payment->payment_type }}</td>

                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td colspan="4">Payment Detail Not Found !!</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        @if (!empty($team_payment))
                                            <div class="register-payment mt-4">
                                                <h4 style="background-color: beige;">Team Payment Detail</h4>
                                                <table id="cart" class="table table-hover table-condensed">
                                                    <thead>
                                                        <tr>
                                                            {{-- <th style="width:15%">Team Name</th> --}}
                                                            <th style="width:15%">Date</th>
                                                            <th style="width:15%">Status</th>
                                                            <th style="width:10%">Price</th>
                                                            <th style="width:10%">Players</th>
                                                            <th style="width:10%">Payment Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (isset($team_payment))
                                                            <tr>
                                                                {{-- <td data-th="number">{{ $team_payment->team }}</td> --}}
                                                                <td data-th="date">
                                                                    {{ \Carbon\Carbon::parse($team_payment->created_at)->format('d-M-Y, g:i A') }}
                                                                </td>
                                                                <td data-th="status" class="status">
                                                                    <span
                                                                        @if ($team_payment->status == 'success') class="approved" @elseif ($team_payment->status == 'pending') class="on-hold" @else class="pending" @endif>
                                                                        {{ $team_payment->status }}</span>
                                                                </td>
                                                                <td data-th="Price" class="">
                                                                    ${{ $team_payment->amount }}
                                                                </td>
                                                                <td>{{ @$team_payment->team && @$team_payment->team->team_member ? $team_payment->team->team_member->count() : 0 }}
                                                                </td>

                                                                <td data-th="Price" class=""
                                                                    style=" text-transform: uppercase; ">
                                                                    {{ $team_payment->payment_type }}</td>

                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td colspan="4">Payment Detail Not Found !!</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tab-pane accordion__panel" id="tab_default_4">
                                        <div class="register-payment">
                                            <table id="cart" class="table table-hover table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%"></th>
                                                        <th style="width:15%">Date</th>
                                                        <th style="width:15%">Event</th>
                                                        <th style="width:10%">Price</th>
                                                        <th style="width:10%">Payment Type</th>
                                                        <th style="width:10%">Payment For</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($event_payments) > 0)
                                                        @foreach ($event_payments as $e_payment)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td data-th="date">
                                                                    {{ \Carbon\Carbon::parse($e_payment->created_at)->format('d-M-Y, g:i A') }}
                                                                </td>
                                                                <td>
                                                                    {{ @$e_payment->event->title }}
                                                                </td>
                                                                <td>
                                                                    {{ @$e_payment->amount }}
                                                                </td>
                                                                <td data-th="Price" style="text-transform: uppercase;">
                                                                    {{ $e_payment->payment_type }}</td>
                                                                <td data-th="status" class="status event">
                                                                    @if ($e_payment->payment_for == 'purchase_team')
                                                                        <span class="approved">Purchase Team</span>
                                                                    @else
                                                                        <span class="event on-hold">Participant</span>
                                                                    @endif

                                                            </tr>
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="4">Event Payment Detail Not Found !!</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- <div class="tab-pane accordion__panel" id="tab_default_4">
                                        <p class="mb-5 text-center">The following addresses will be used on the checkout
                                            page by default.</p>
                                        <div class="row">
                                            <div class="address-info col-md-6 col-12">
                                                <h5 class="section-title">Billing Address</h5>
                                                <ul>
                                                    <li><span>7000, WhiteField, Manchester Highway, London. 401203</span>
                                                    </li>
                                                    <li>Phone no: <a href="#">+91 1234567890</a></li>
                                                    <li>Email: <a href="#">youremail@domain.com</a></li>
                                                </ul>
                                            </div>
                                            <div class="address-info col-md-6 col-12">
                                                <h5 class="section-title">Billing Address</h5>
                                                <ul>
                                                    <li><span>7000, WhiteField, Manchester Highway, London. 401203</span>
                                                    </li>
                                                    <li>Phone no: <a href="#">+91 1234567890</a></li>
                                                    <li>Email: <a href="#">youremail@domain.com</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="tab-pane accordion__panel" id="tab_default_5">
                                        <form action="{{ route('profile-update') }}" name="user_form" method="post"
                                            id="user_form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-6 form-group">
                                                    <label>First Name <span class="validation">*</span></label>
                                                    <input type="text" name="first_name" id="first_name"
                                                        autocomplete="off" class="form-control"
                                                        value="{{ @$user->first_name }}">
                                                    @error('first_name')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-6 form-group">
                                                    <label>Last Name <span class="validation">*</span></label>
                                                    <input type="text" name="last_name" id="last_name"
                                                        autocomplete="off" class="form-control"
                                                        value="{{ @$user->last_name }}">
                                                    @error('last_name')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-6 form-group">
                                                    <label>Email <span class="validation">*</span></label>
                                                    <input type="email" name="email" id="email"
                                                        autocomplete="off" class="form-control"
                                                        value="{{ @$user->email }}" readonly>
                                                    @error('email')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-6 form-group">
                                                    <label>Phoneno <span class="validation">*</span></label>
                                                    <input type="number" name="phone" id="phone"
                                                        autocomplete="off" class="form-control"
                                                        value="{{ @$user->phone }}">
                                                    @error('phone')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-6 form-group">
                                                    <label>Image <span class="validation">*</span></label>
                                                    <input type="file" name="image" class="form-control"
                                                        id="imgInp" />
                                                    <input type="hidden" name="oldimage" class="form-control"
                                                        id="oldimage" placeholder="showphotos"
                                                        value="{{ @$user->image }}">
                                                    @error('image')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-6 form-group">
                                                    <img id="blah"
                                                        style="border: 1px solid #adb5bd !important; border-radius: 13px !important;"
                                                        @if (@$user->image) src="{{ @$user->image }}"
                                @else
                                    src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                                        onerror="this.src='{{ URL::asset('storage/admin/default/img1.jpg') }}'"
                                                        alt="Your Slider Image" width="100px" height="150px" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="tx-ctm-btn" type="submit">Update</button>
                                            </div>
                                        </form>
                                        <h5 style="margin-top: 30px; margin-bottom:20px;">
                                            Update Password
                                            ? </h5>
                                        <div class="card_details">
                                            <form method="POST" action="{{ route('update.password') }}"
                                                name="password_form" id="password_form">
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="current_password">Current Password
                                                            <span class="validation">*</span></label>
                                                        <input type="password" name="current_password"
                                                            class="form-control" id="current_password"
                                                            value="{{ old('current_password') }}">
                                                        @error('current_password')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col">
                                                        <label for="password">New Password <span
                                                                class="validation">*</span></label>
                                                        <input type="password" name="password" class="form-control"
                                                            id="password" value="{{ old('password') }}">
                                                        @error('password')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col">
                                                        <label for="confirm_password">Confirm New Password
                                                            <span class="validation">*</span></label>
                                                        <input type="password" name="confirm_password"
                                                            class="form-control" id="confirm_password"
                                                            value="{{ old('confirm_password') }}">
                                                        @error('confirm_password')
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group" style="margin-top: 10px;">
                                                    <button class="tx-ctm-btn">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="tab-pane accordion__panel" id="tab_default_6">
                                        <p> Account logout. </p>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }

        $(document).ready(function() {

            $('.phone').keypress(function(e) {

                var charCode = (e.which) ? e.which : event.keyCode

                if (String.fromCharCode(charCode).match(/[^0-9]/g))

                    return false;

            });

        });



        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');

        $("#user_form").validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                email: {
                    required: true
                },
                image: {
                    required: function() {
                        var image = $('#oldimage').val();
                        return image == null || image == "" || image == undefined;
                    },
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
            },
        })

        $('#password_form').validate({
            rules: {
                current_password: {
                    required: true,
                },
                password: {
                    required: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                confirm_password: {
                    equalTo: "Please enter the same password as new password"
                }
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2') && element.next('.select2-container').length) {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element)
                }
            }
        })
    </script>
@endsection
