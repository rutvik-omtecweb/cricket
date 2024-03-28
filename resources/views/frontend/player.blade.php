@extends('layouts.app')
@section('title', 'Become Player')
@section('links')
    <style>
        .player-member button {
            background-color: #0A2D7C;
        }
    </style>
@endsection
@section('content')
    <section class="inner-header aboutus">
        <img src="{{ asset('storage/frontend/assets/dist/images/about-header.jpg') }}" alt="" class="img-fluid w-100 ">
        <div class="innerheader-text">
            <h2>Become Player</h2>
        </div>
    </section>
    <section class="news-listng">
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
    </section>
@endsection
@section('scripts')
    <script>
        function JoinPlayer(userID, amount) {
            $.ajax({
                url: "{{ route('join.player') }}",
                type: "POST",
                data: {
                    'user_id': userID,
                    'amount' : amount
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
