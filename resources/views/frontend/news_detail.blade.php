@extends('layouts.app')
@section('title', 'Photo’s')
@section('links')
    <style>
        .card-header {
            padding: 15px;
            border-bottom: none;
            background-color: floralwhite;
            /* Remove the border */
        }

        .card-header h5 {
            margin: 0;
            font-size: 18px;
            color: #333333;
        }

        .card-header h6 {
            margin: 0;
            font-size: 18px;
            color: #333333;
        }

        .card-header small {
            color: #933a3a;
        }

        .card-header h5 {
            margin: 0;
            font-size: 29px;
            color: #333333;
            font-weight: bold;
        }

        .news-item img {
            border-radius: 8px;
        }

        .news-item h6 {
            color: #333333;
            font-weight: bold;
        }

        .news-item a:hover {
            text-decoration: none;
        }

        .news-image {
            width: 340px !important;
            height: 236px !important;
            border-radius: 15px !important;
        }
    </style>
@endsection
@section('content')
    <main>
        <section class="inner-header aboutus" style="margin-top: 170px;">
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ @$news->news_name }}</h5>
                                    <br>
                                    <small>{{ \Carbon\Carbon::parse($news->created_at)->format('d-M-Y, g:i A') }}</small>
                                </div>
                                <div class="card-body">
                                    <img src="{{ @$news->image }}" alt="{{ $news->news_name }}"
                                        class="img-fluid rounded " style="margin-top: 30px;width: 100%;height: auto;">
                                    <p class="mt-3">{!! @$news->description !!}</p>
                                </div>
                            </div>
                        </div>
                        @if (count($news_list) > 0)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Latest News</h6>
                                    </div>
                                    <div class="card-body" style="text-align: center;">
                                        @foreach ($news_list as $key => $n_list)
                                            <div class="news-item">
                                                <a href="{{ route('news.detail', $n_list->id) }}"
                                                    class="text-decoration-none">
                                                    <img src="{{ @$n_list->image }}" alt="{{ $n_list->news_name }}"
                                                        class="img-fluid rounded news-image" style="margin-top: 30px">
                                                    <h6 class="mt-3">{{ $n_list->news_name }}</h6>
                                                </a>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
@endsection
