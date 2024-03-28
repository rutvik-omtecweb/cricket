@extends('layouts.admin')
@section('style')
    <style>
        @media screen and (min-width: 576px) {
            .statistics--title {
                max-width: calc(100% - 215px);
            }

            .pr-sm-3,
            .px-sm-3 {
                padding-inline-end: 1rem !important;
            }
        }

        .statistics--title {
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            flex-wrap: wrap;
            width: 100%;
        }

        .resturant-card.dashboard--card {
            min-height: 135px;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .bg--2 {
            background: #a0cfa0 !important;
        }

        .bg--3 {
            background: #ebb7bc !important;
        }

        .bg--4 {
            background: #dbd7cb !important;
        }

        .bg--5 {
            background: #f1e2e9 !important;
        }

        .resturant-card {
            padding: 30px 55px 25px 30px;
        }

        .resturant-card {
            position: relative;
            border-radius: 10px;
            padding: 21px 50px 21px 28px;
        }

        .resturant-card.bg--2 .title {
            color: #008958;
        }

        .resturant-card .title {
            font-size: 1.375rem;
            font-weight: 700;
            margin: 0;
            margin-bottom: 5px;
        }

        .resturant-card .subtitle {
            margin: 0;
            font-weight: 600;
            font-size: 14px;
            line-height: 19px;
        }

        .resturant-card .resturant-icon {
            inset-inline-end: 20px;
            top: 25px;
        }

        .resturant-card .resturant-icon {
            position: absolute;
            inset-inline-end: 15px;
            top: 15px;
            max-width: 45px;
            height: 50px;
            -o-object-fit: contain;
            object-fit: contain;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        .order--card {
            background: #eef1f3;
            border-radius: 10px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            padding: 18px 15px 15px 20px;
            min-height: 65px;
        }

        .order--card .card-subtitle img {
            width: 22px;
            height: 22px;
            -o-object-fit: contain;
            object-fit: contain;
            margin-inline-end: 10px;
        }

        .top--resturant-item {
            border: none !important;
            background: #fff;
            -webkit-box-shadow: 0 4px 4px rgba(51, 66, 87, .05) !important;
            box-shadow: 0 4px 4px rgba(51, 66, 87, .05) !important;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            padding: 10px 9px;
        }

        .top--resturant-item img {
            width: 65px;
            height: 65px;
            -o-object-fit: cover;
            object-fit: cover;
            border-radius: 50%;
            border: 1px solid rgba(240, 111, 0, .3);
        }

        .top--rated-food {
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            padding: 10px;
            border: none !important;
            background: #fff;
            -webkit-box-shadow: 0 4px 4px rgba(51, 66, 87, .05) !important;
            box-shadow: 0 4px 4px rgba(51, 66, 87, .05) !important;
            border-radius: 5px;
            height: 100%;
            min-height: 140px;
        }

        .initial-42 {
            border-radius: 5px;
            width: 65px;
            height: 65px;
        }

        .top--rated-food img {
            border: 1px solid rgba(240, 111, 0, .3);
        }

        .top--rated-food .name {
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: medium;
        }

        .initial-41 {
            border-radius: 47px;
            width: 100px;
            height: 100px;
        }

        .products-list .product-img img {
            border-radius: 8px;
        }
    </style>
@endsection
@section('content')
    <section class="content">
        <div class="content container-fluid">
            <div class="card">
                <div class="card-body">
                    <div id="order_stats_top">
                        <div class="d-flex flex-wrap justify-content-between statistics--title-area">
                            <div class="statistics--title pr-sm-3">
                                <h4 class="m-0 mr-1"> Admin Dashboard </h4>
                            </div>
                        </div>
                        <div class="row g-2 mt-3">
                            <div class="col-xl-3 col-sm-6 mb-1">
                                <div class="resturant-card dashboard--card bg--2 cursor-pointer redirect-url">

                                    <h4 class="title">{{ @$teams ?? 0 }}</h4>
                                    <span class="subtitle">Total Team</span>
                                    <img class="resturant-icon" src="{{ asset('storage/dashbord/team.png') }}"
                                        alt="dashboard">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-1">
                                <div class="resturant-card dashboard--card bg--3 cursor-pointer redirect-url">

                                    <h4 class="title">{{ @$members ?? 0 }}</h4>
                                    <span class="subtitle">Total Members</span>
                                    <img class="resturant-icon" src="{{ asset('storage/dashbord/member.jpg') }}"
                                        alt="dashboard">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-1">
                                <div class="resturant-card dashboard--card bg--4 cursor-pointer redirect-url">

                                    <h4 class="title">{{ @$players ?? 0 }}</h4>
                                    <span class="subtitle">Total Player</span>
                                    <img class="resturant-icon" src="{{ asset('storage/dashbord/player.jpg') }}"
                                        alt="dashboard">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-1">
                                <div class="resturant-card dashboard--card bg--5 cursor-pointer redirect-url">

                                    <h4 class="title">{{ @$totalRegistrationsLastWeek ?? 0 }}</h4>
                                    <span class="subtitle">Total Registrations from Last Week</span>
                                    <img class="resturant-icon" src="{{ asset('storage/dashbord/last_week.jpg') }}"
                                        alt="dashboard">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header align-items-center">
                            <h5 class="card-title">
                                <span>Approve Member List</span>
                            </h5>
                            <div class="card-body">
                                @if (count($approve_member) > 0)
                                    <ul class="products-list product-list-in-card pl-2 pr-2">
                                        @foreach ($approve_member as $a_member)
                                            <li class="item mt-3">
                                                <div class="product-img">
                                                    @if (@$a_member->image)
                                                        <img src="{{ @$a_member->image }}" alt="Product Image"
                                                            class="img-size-50">
                                                    @else
                                                        <img src="{{ asset('storage/admin/default/img1.jpg') }}"
                                                            alt="product-image" class="img-size-50">
                                                    @endif
                                                </div>
                                                <div class="product-info">
                                                    <a href="{{ route('admin.members.show', $a_member->id) }}">{{ $a_member->first_name }}
                                                        {{ $a_member->last_name }}</a>
                                                    @if (@$a_member->payment_collect)
                                                        <span class="badge badge-warning float-right">Expired Date -
                                                            {{ $a_member->payment_collect->expired_date }}</span>
                                                    @endif

                                                </div>
                                            </li>
                                            <!-- /.item -->
                                        @endforeach
                                    </ul>
                                @else
                                    <div>
                                        <h3 class="text-center mt-5">Members Not Found!</h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header align-items-center">
                            <h5 class="card-title">
                                <span> Registrations from Last Week Members List</span>
                            </h5>
                            <div class="card-body">
                                @if (count($membersLastWeek) > 0)
                                    <ul class="products-list product-list-in-card pl-2 pr-2">
                                        @foreach ($membersLastWeek as $v_member)
                                            <li class="item mt-3">
                                                <div class="product-img">
                                                    @if (@$v_member->image)
                                                        <img src="{{ @$v_member->image }}" alt="Product Image"
                                                            class="img-size-50">
                                                    @else
                                                        <img src="{{ asset('storage/admin/default/img1.jpg') }}"
                                                            alt="product-image" class="img-size-50">
                                                    @endif
                                                </div>
                                                <div class="product-info">
                                                    <a href="{{ route('admin.members.show', $v_member->id) }}">{{ $v_member->first_name }}
                                                        {{ $v_member->last_name }}</a>
                                                    @if (@$v_member->payment_collect)
                                                        <span class="badge badge-warning float-right">Expired Date -
                                                            {{ $v_member->payment_collect->expired_date }}</span>
                                                    @endif
                                                </div>
                                            </li>
                                            <!-- /.item -->
                                        @endforeach
                                    </ul>
                                @else
                                    <div>
                                        <h3 class="text-center mt-5">Members Not Found!</h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
