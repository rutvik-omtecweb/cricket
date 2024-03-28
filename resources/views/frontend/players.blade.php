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
    <section class="breadcrumbs" style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
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
