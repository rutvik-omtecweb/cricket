@extends('layouts.app')
@section('title', 'Players')
@section('links')
    <style>
        .player-member button {
            background-color: #0A2D7C;
        }
    </style>
@endsection
@section('content')
    <section class="breadcrumbs"
        style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>Player List</h2>
        </div>
    </section>

    <div class="container">
        <div class="row">
            @if (empty($existing_player))
                <div class="col-12 text-left btn-div">
                    @auth
                        <button class="btn btn-primary default-btn extra-btn"
                            onclick="JoinPlayer('{{ @$user_id }}', '{{ @$player_payment->amount }}')">Join Now - $
                            {{ @$player_payment->amount }}</button>
                    @else
                        <p>Membership required to become a player. Join our community to get started on your way!</p>
                    @endauth
                </div>
            @endif
            @if (count($players) > 0)
                @foreach ($players as $player)
                    <div class="col-lg-3 col-12 col-sm-6 member-list-main">
                        <div class="member-box">
                            <div class="member-image">
                                <img
                                    @if (@$player->user->image) src="{{ @$player->user->image }}"
                                @else
                                    src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif>
                            </div>
                            <div class="member-details">
                                <p>{{ $player->user->first_name }} {{ $player->user->last_name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center mt-5">
                    <h4 style="font-weight: bolder;">Player Not Found !!</h4>
                </div>
            @endif
        </div>
    </div>

    {{-- <section class="news-listng">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center player-member">
                    <h2 class="mainhead">Become Player <span>Become Player</span></h2>
                    @auth
                        <button class="btn btn-primary"
                            onclick="JoinPlayer('{{ @$user_id }}', '{{ @$player_payment->amount }}')">Join Now - $
                            {{ @$player_payment->amount }}</button>
                    @else
                        <p>Membership required to become a player. Join our community to get started on your way!</p>
                    @endauth
                </div>
            </div>
        </div>
    </section> --}}
@endsection
@section('scripts')
    <script>
        function JoinPlayer(userID, amount) {
            $.ajax({
                url: "{{ route('join.player') }}",
                type: "POST",
                data: {
                    'user_id': userID,
                    'amount': amount
                },
                success: function(response) {
                    // Handle successful response
                    console.log("response", response);
                    if (response.url) {
                        window.location.href = response.url;
                    } else {
                        console.log("here");
                        if (response.status == false) {
                            console.log("here333");
                            toastr.error(response.message);
                        }
                        console.error('Missing "url" property in the response.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error("xhr.responseText");
                    console.log("error", error);
                }
            });
        }
    </script>
@endsection
