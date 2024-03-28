@extends('layouts.app')
@section('title', 'Events')
@section('links')
    <style>
        .event-image {
            width: 300px;
            height: 200px;
        }
    </style>
@endsection
@section('content')

    <section class="breadcrumbs" style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>Events<br> CRICKET ASSOCIATION</h2>
        </div>
    </section>

    <section class="event-listing">
        <div class="container">
            <div class="row">
                @if (count($events) > 0)
                    @foreach ($events as $event)
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="card">
                                <img @if ($event->image) src="{{ $event->image }}" @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                    alt="" class="event-image">
                                <div class="description">
                                    <h2 class="mb-4">{{ $event->title }}</h2>
                                    {{-- <p>{{ $event->description }}</p> --}}
                                    <a href="{{ route('event.detail', $event->id) }}" class="event-link">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div>
                        <div class="text-center mt-5">
                            <h4 style="font-weight: bolder;">Event Not Found !!</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
