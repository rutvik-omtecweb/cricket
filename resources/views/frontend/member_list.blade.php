@extends('layouts.app')
@section('title', 'Member List')
@section('links')

@endsection
@section('content')

    <section class="breadcrumbs"
        style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>Member List</h2>
        </div>
    </section>

    <div class="container">
        <div class="row">
            @if (empty($is_member) && $is_member == null)
                <div class="col-12 text-left btn-div">
                    <a href="{{ route('register') }}" class="btn btn-primary default-btn extra-btn">Become a Member</a>
                </div>
            @endif
            @if (count($members) > 0)
                @foreach ($members as $member)
                    <div class="col-lg-3 col-12 col-sm-6 member-list-main">
                        <div class="member-box">
                            <div class="member-image">
                                <img
                                    @if (@$member->image) src="{{ @$member->image }}"
                                @else
                                    src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif>
                            </div>
                            <div class="member-details">
                                <p>{{ $member->first_name }} {{ $member->last_name }}</p>
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

@endsection
