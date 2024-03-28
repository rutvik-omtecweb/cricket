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
                    <h2 class="mainhead"> Player List <span> Player List</span></h2>
                </div>
            </div>
        </div>
    </section>
@endsection
