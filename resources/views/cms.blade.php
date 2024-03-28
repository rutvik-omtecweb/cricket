@extends('layouts.app')
@section('title', @$cms->cms_page_name)
@section('content')

    <section class="breadcrumbs" style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
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
