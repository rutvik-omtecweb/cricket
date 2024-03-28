@extends('layouts.app')
@section('title', 'League Rules')
@section('content')
    <section class="breadcrumbs" style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
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

