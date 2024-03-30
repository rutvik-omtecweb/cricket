@extends('layouts.app')
@section('title', 'Profile')

@section('content')
    <section class="breadcrumbs"
        style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>TEAM DETAILS</h2>
        </div>
    </section>

    <section class="team-details">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="mainhead mt-5">{{ @$team->team_name }} <span>{{ @$team->team_name }}</span></h2>
                </div>
            </div>
            <div class="row team-info">
                <div class="col-md-4 col-12">
                    <div class="team-logo">
                        <img src="{{ @$team->image }}">
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="team-details">
                        <h3>{{ @$team->team_name }}</h3>
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
                @if (count(@$team_members) > 0)
                    @foreach (@$team_members as $member)
                        <div class="col-lg-3 col-12 col-sm-6 member-list-main">
                            <div class="member-box">
                                <div class="member-image">
                                    <img
                                        @if (@$member->player->user->image) src="{{ @$member->player->user->image }}"
                                @else
                                    src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif>
                                </div>
                                <div class="member-details">
                                    <p>{{ @$member->player->user->first_name }} {{ @$member->player->user->last_name }}</p>
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

@endsection
