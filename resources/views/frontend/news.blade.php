@extends('layouts.app')
@section('title', 'News')
@section('links')

@endsection
@section('content')

    <section class="breadcrumbs"
        style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>News<br> CRICKET ASSOCIATION</h2>
        </div>
    </section>

    <section class="news-listng">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="mainhead mt-5">Inner News <span>Inner News</span></h2>
                </div>
            </div>
            <div class="wrapper">
                @if (count($news) > 0)
                    @foreach ($news as $ndata)
                        <div class="card">
                            <a href="{{ route('news.detail', ['id' => $ndata->id]) }}" target="_blank">
                                <div class="card-banner">
                                    <img class="banner-img"
                                        @if ($ndata->image) src='{{ $ndata->image }}'  @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                        alt=''>
                                </div>
                                <div class="card-body">
                                    {{-- <p class="blog-hashtag">#Food #Pizza</p> --}}
                                    <h2 class="blog-title">{{ $ndata->news_name }}</h2>
                                    <p class="blog-description">{!! $ndata->description !!}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="text-center mt-5">
                        <h4 style="font-weight: bolder;">Inner News Not Found !!</h4>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="mainhead mt-5">Outer News <span>Outer News</span></h2>
                </div>
            </div>

            <div class="wrapper">
                @if (count($rssItems) > 0)
                    @foreach ($rssItems as $rssItem)
                        <div class="card">
                            <a href="{{ $rssItem['link'] }}" target="_blank">
                                <div class="card-banner">
                                    <img class="banner-img"
                                        @if (isset($rssItem['image'])) src='{{ $rssItem['image'] }}' @else
                            src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                        alt=''>
                                </div>
                                <div class="card-body">
                                    <h2 class="blog-title">{{ $rssItem['title'] }}</h2>
                                    <p class="blog-description">{{ $rssItem['description'] }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="text-center mt-5">
                        <h4 style="font-weight: bolder;">Outer News Not Found !!</h4>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
