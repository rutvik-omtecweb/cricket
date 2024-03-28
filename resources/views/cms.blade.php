@extends('layouts.app')
@section('title', @$cms->cms_page_name)
@section('content')
    <section class="inner-header aboutus">
        <img src="{{ asset('storage/frontend/assets/dist/images/contact-header.jpg') }}" alt=""
            class="img-fluid w-100 ">
        <div class="innerheader-text">
            <h2>{{ @$cms->cms_page_name }}</h2>
        </div>
    </section>
    <main>
        <section class=" about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @if (!empty($cms))
                            <p> {!! @$cms->body !!}</p>
                        @else
                            <h5 class="text-center">{{ @$cms->cms_page_name }} not found!!</h5>
                        @endif
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
