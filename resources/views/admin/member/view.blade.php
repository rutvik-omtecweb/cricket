@extends('layouts.admin')
@section('style')
    <style>
        .member_image {
            border-radius: 23px;
            border-style: dotted;
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid ">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('admin.members.index') }}">Member List Page</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <div class="content container-fluid">
            <div class="row review--information-wrapper g-2 mb-3">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            Member Information
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-control">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <span style="padding-left: 10px;">
                                            {{ $user['first_name'] }} {{ $user['last_name'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-control">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <span style="padding-left: 10px;">
                                            {{ $user['email'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-control">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <span style="padding-left: 10px;">
                                            {{ $user['phone'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>


                            @if ($user['dob'])
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="fas fa-birthday-cake" aria-hidden="true"></i>
                                            <span style="padding-left: 10px;">
                                                {{ $user['dob'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($user['address'])
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control" style="height: 80px;">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span style="padding-left: 10px;">
                                                {{ $user['address'] }}
                                                @if ($user['city'])
                                                    , {{ $user['city'] }},
                                                @endif

                                                @if ($user['state'])
                                                    {{ $user['state'] }},
                                                @endif

                                                @if ($user['postal_code'])
                                                    {{ $user['postal_code'] }} .
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>


                    </div>

                    <div class="card">
                        <div class="card-header">
                            Member Payment Information
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center">
                            @if ($user->payment_collect)
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="far fa-calendar-times" aria-hidden="true"></i>
                                            <label>Start Date :- </label>
                                            <span style="padding-left: 10px;">
                                                {{ $user->payment_collect->created_at->format('Y-m-d') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="far fa-calendar-times" aria-hidden="true"></i>
                                            <label>Expiry Date :- </label>
                                            <span style="padding-left: 10px;">
                                                {{ $user->payment_collect->expired_date }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="far fa-credit-card" aria-hidden="true"></i>
                                            <label>Payment Type :- </label>
                                            <span style="padding-left: 10px; text-transform:capitalize;">
                                                {{ $user->payment_collect->payment_type }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="far fa-money-bill-alt"></i>
                                            <label>Amount :- </label>
                                            <span style="padding-left: 10px; text-transform:capitalize;">
                                                {{ $user->payment_collect->amount }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- @if ($user->payment_collect->transaction_id)
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-control">
                                        <i class="fas fa-money-check-alt"></i>
                                        <label>Transaction Id :- </label>
                                        <span style="padding-left: 10px; text-transform:capitalize;">
                                            {{ $user->payment_collect->transaction_id }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif --}}
                            @endif
                        </div>
                    </div>


                    @if (!empty($player))
                        <div class="card">
                            <div class="card-header">
                                Player Payment Detail
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center">
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="far fa-calendar-times" aria-hidden="true"></i>
                                            <label>Start Date :- </label>
                                            <span style="padding-left: 10px; text-transform:capitalize;">
                                                {{ \Carbon\Carbon::parse($player->created_at)->format('d-M-Y, g:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="far fa-calendar-times" aria-hidden="true"></i>
                                            <label>Start Date :- </label>
                                            <span style="padding-left: 10px; text-transform:capitalize;">
                                                {{ \Carbon\Carbon::parse($player->created_at)->format('d-M-Y, g:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="far fa-credit-card" aria-hidden="true"></i>
                                            <label>Payment Type :- </label>
                                            <span style="padding-left: 10px; text-transform:capitalize;">
                                                {{ $player->payment_type }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="far fa-money-bill-alt"></i>
                                            <label>Amount :- </label>
                                            <span style="padding-left: 10px; text-transform:capitalize;">
                                                {{ $player->amount }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-control">
                                            <i class="fas fa-stream"></i>
                                            <label>Status :- </label>
                                            <span style="padding-left: 10px; text-transform:capitalize;">
                                                {{ $player->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- @if (!empty($player))
                        <div class="card">
                            <div class="card-header">
                                Player Payment Detail
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p><strong>Date :
                                            </strong>
                                            {{ \Carbon\Carbon::parse($player->created_at)->format('d-M-Y, g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p><strong>Price: </strong> {{ $player->amount }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p><strong>Status: </strong> {{ $player->status }}</p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Payment Type: </strong> {{ $player->payment_type }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif --}}
                </div>
                <div class="col-lg-9">
                    <!-- Card -->
                    <div class="card h-100">
                        <!-- Body -->
                        <div class="card-header">
                            Identification Document
                        </div>
                        <div class="card-body">
                            <div class="row">

                                @if ($setting->health_card_document == 1)
                                    <div class="col-md-4 text-center">
                                        <img @if ($user->verification_id_1) src="{{ asset('storage/member/' . $user->verification_id_1) }}" @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                            width="350" height="300" class="member_image mr-3 mb-3">
                                        <p><strong>Health Card Document</strong></p>
                                    </div>
                                @endif
                                @if ($setting->licence_document == 1)
                                    <div class="col-md-4 text-center">

                                        <img @if ($user->verification_id_2) src="{{ asset('storage/member/' . $user->verification_id_2) }}" @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                            width="350" height="300" class="member_image mr-3 mb-3">
                                        <p><strong>Licence Document</strong></p>
                                    </div>
                                @endif

                                @if ($setting->other_document == 1)
                                    <div class="col-md-4 text-center">
                                        <img @if ($user->verification_id_3) src="{{ asset('storage/member/' . $user->verification_id_3) }}" @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                            width="350" height="300" class="member_image mr-3 mb-3">
                                        <p><strong>Other Document</strong></p>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
    @endsection
