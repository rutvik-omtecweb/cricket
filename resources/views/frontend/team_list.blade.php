@extends('layouts.app')
@section('title', 'Team List')
@section('links')
    <style>
        .about {
            background-image: url(../storage/frontend/assets/dist/images/background.png);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .main-team-listing {
            padding: 50px 0px;
        }

        .table {
            --bs-table-bg: transparent;
            margin-bottom: 0;
            padding: 20px;
            border-spacing: 0;
            border: 3px solid #ffffff;
            border-radius: 49px 49px 49px 49px;
            -moz-border-radius: 49px 49px 49px 49px;
            -webkit-border-radius: 49px 49px 49px 49px;
            box-shadow: 0 1px 1px #CCCCCC;
            border-collapse: separate !important;
            margin: 10px;
        }

        .table a{
            color: white !important;
        }

        th,
        td {
            color: white !important;
        }

        table th:first-child {
            -moz-border-radius: 6px 0 0 0;
        }

        table th {
            border-bottom: 1px solid #fff;
        }
    </style>
@endsection
@section('content')
    <section class="breadcrumbs" style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
             <h2>TEAM LIST</h2>
        </div>
    </section>
    <main>
        <section class="team">
            <div class="container main-team-listing">
                <div class="row align-items-center team-list">
                    <div class="col-12 text-left btn-div" style="margin-bottom:15px;">
                        <a href="{{route('buy.team')}}" class="btn btn-primary default-btn extra-btn">Buy a Team</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="team-details">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="mainhead mt-5">{{@$team->team_name}} <span>{{@$team->team_name}}</span></h2>
                    </div>
                </div>
                <div class="row team-info">
                    <div class="col-md-4 col-12">
                        <div class="team-logo">
                            <img src="{{@$team->image}}">
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="team-details">
                            <h3>{{@$team->team_name}}</h3>
                            <p>{!! @$team->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="mainhead mt-5">Team<span>Team</span></h2>
                    </div>
                </div>
                <div class="row">
                    @if (count($team_members) > 0)
                        @foreach ($team_members as $member)
                            <div class="col-lg-3 col-12 col-sm-6 member-list-main">
                                <div class="member-box">
                                    <div class="member-image">
                                        <img
                                            @if (@$member->user->image) src="{{ @$member->user->image }}"
                                        @else
                                            src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif>
                                    </div>
                                    <div class="member-details">
                                        <p>{{ $member->user->first_name }} {{ $member->user->last_name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center mt-5">
                            <h4 style="font-weight: bolder;">Members Not Found !!</h4>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </main>
@endsection
