@extends('layouts.app')
@section('title', 'Member List')
@section('links')

@endsection
@section('content')
    <section class="inner-header aboutus">
        <img src="{{ asset('storage/frontend/assets/dist/images/about-header.jpg') }}" alt="" class="img-fluid w-100 ">
        <div class="innerheader-text">
            <h2>Member List</h2>
        </div>
    </section>

    <div class="container">
        <div class="row">
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
