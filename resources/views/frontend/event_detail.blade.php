@extends('layouts.app')
@section('title', 'Events')
@section('links')
    <style>
        .payment-box {
            height: 323px;
        }

        .payment-link-disable {
            font-size: 1em;
            padding: 0.5em 1em;
            color: #fff;
            background-color: #8B9BC1;
            border: none;
            border-radius: 6px;
        }
    </style>
@endsection
@section('content')

    <section class="inner-header aboutus">
        <img src="{{ asset('storage/frontend/assets/dist/images/about-header.jpg') }}" alt="" class="img-fluid w-100 ">
        <div class="innerheader-text">
            <h2>Event Detail<br> CRICKET ASSOCIATION</h2>
        </div>
    </section>

    <section class="event-details">
        <div class="container">
            <div class="event-title">
                <p class="mainhead">{{ @$event->title }}</p>
            </div>
            @php
                $startDate = \Illuminate\Support\Carbon::parse($event->start_date);
                $endDate = \Illuminate\Support\Carbon::parse($event->end_date);
            @endphp
            <div class="row info-box">
                <div class="col-md-4">
                    <div class="addition-information">

                        <h3>Event Start Date</h3>
                        <p>{{ $startDate->format('d M') }} <br><span class="box-span">{{ $startDate->format('Y') }}</span>
                        </p>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="addition-information">
                        <h3>Event End Date</h3>
                        <p>{{ $endDate->format('d M') }} <br><span class="box-span">{{ $endDate->format('Y') }}</span></p>
                    </div>
                </div>
                @auth
                    <div class="col-md-4">
                        <div class="addition-information">
                            <h3>Total Numbers Of Team</h3>
                            <p>{{ @$event->number_of_team }} <br><span class="box-span">Team</span></p>
                        </div>
                    </div>
                @endauth
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="event-details">
                        <h5 style="color: #0A2D7C;"> <strong>Location :</strong> </h5>
                        <p>
                            {{ @$event->description }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="event-image">
                        @if (@$event->image)
                            <img src="{{ @$event->image }}" width="100%">
                        @else
                            <img src="{{ URL::asset('storage/admin/default/img1.jpg') }}"
                                style="height: 320px !important; width: 600px !important;">
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="event-details">
                        <p>
                            {{ @$event->description }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row other-info text-center">
                <div class="col-12">
                    <p class="mainhead">Join Us</p>
                </div>
                <div class="col-md-4">
                    <div class="payment-box">
                        @if ($event->limit_number_of_team > 0)
                            @auth
                                <h6 class="text-end mb-0"
                                    style="color: #0A2D7C;font-weight: 700;position: relative;z-index: 1;">
                                    Remaining Team: {{ $event->limit_number_of_team }}</h6>
                            @endauth
                        @endif
                        <h3>Purchase Team</h3>
                        <p class="price">{{ number_format($event->team_price, 0, '.', '') }}$</p>
                        @if ($event->limit_number_of_team > 0)
                            @auth
                                <button class="payment-link" onclick="purchaseTeam('{{ $event->id }}')">Procee With
                                    Payment</button>
                            @else
                                <button class="payment-link-disable" disabled>Procee With Payment</button>
                            @endauth
                        @endif
                    </div>
                </div>
                @auth
                    @if (!empty($ch_player))
                        <div class="col-md-4">
                            <div class="payment-box">
                                <h3>Join as a Participant </h3>
                                <p class="price">{{ number_format($event->participant_price, 0, '.', '') }}$</p>
                                @auth
                                    <button class="payment-link" onclick="joinParticipant('{{ $event->id }}')">Procee With
                                        Payment</button>
                                @else
                                    <button class="payment-link-disable" disabled>Procee With Payment</button>
                                @endauth
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        function purchaseTeam(id) {
            $.ajax({
                type: "post",
                url: "{{ route('purchase.team') }}",
                data: {
                    'event_id': id
                },
                success: function(response) {
                    if (response.url) {
                        window.location.href = response.url;
                    } else {
                        if (response.status == false) {
                            toastr.error(response.message);
                        }
                        console.error('Missing "url" property in the response.');
                    }
                },
                error: function(response) {
                    if (response.status == 401) {
                        toastr.error("Please login to purchase team")
                    }
                }
            });
        }

        function joinParticipant(id) {
            $.ajax({
                type: "post",
                url: "{{ route('join.participant') }}",
                data: {
                    'event_id': id
                },
                success: function(response) {
                    if (response.url) {
                        window.location.href = response.url;
                    } else {
                        if (response.status == false) {
                            toastr.error(response.message);
                        }
                        console.error('Missing "url" property in the response.');
                    }
                },
                error: function(response) {
                    if (response.status == 401) {
                        toastr.error("Please login to Participant")
                    }
                }
            });
        }
    </script>
@endsection
