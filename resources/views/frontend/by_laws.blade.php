@extends('layouts.app')
@section('title', 'By-Laws')
@section('content')
    <section class="breadcrumbs" style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>BY-LAWS</h2>
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
                            <h5 class="text-center">By-Laws not found!!</h5>
                        @endif
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

