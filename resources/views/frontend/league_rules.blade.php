@extends('layouts.app')
@section('title', 'League Rules')
@section('content')
    <section class="inner-header aboutus">
        <img src="{{ asset('storage/frontend/assets/dist/images/contact-header.jpg') }}" alt=""
            class="img-fluid w-100 ">
        <div class="innerheader-text">
            <h2>LEAGUE RULES</h2>
        </div>
    </section>
    <main>
        <section class=" about">
            <div class="container">
                {{-- <h2 class="text-center" style="color: #0A2D7C;">Cricket Association By-Laws</h2> --}}
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @if (!empty($cms))
                            <p> {!! @$cms->body !!}</p>
                        @else
                            <h5 class="text-center">League Rules not found!!</h5>
                        @endif
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

