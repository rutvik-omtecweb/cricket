@extends('layouts.app')
@section('links')
    <style>
        #myImg:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 110px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: #181818e3;
            background-color: #181818e3;
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 45%;
            //max-width: 75%;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content,
        #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        .out {
            animation-name: zoom-out;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(1)
            }

            to {
                -webkit-transform: scale(2)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0.4)
            }

            to {
                transform: scale(1)
            }
        }

        @keyframes zoom-out {
            from {
                transform: scale(1)
            }

            to {
                transform: scale(0)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        .modal-title {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 24px;
        }

        
        div#myModal img{
            max-height:499px;
        }

    </style>
@endsection
@section('content')
    {{-- banner section :start --}}
    @if (count($banners) > 0)
        <section class="main-carousel">
            <div id="carouselExampleCaptions" class="carousel slide">
                <div class="carousel-indicators">
                    @foreach ($banners as $key => $banner)
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}"
                            @if ($key === 0) class="active" @endif
                            aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner ">
                    @foreach ($banners as $key => $banner)
                        <div class="carousel-item @if ($key == 0) active @endif">
                            <img src="{{ $banner->image }}" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInDown">
                                <h1></h1>
                                <h2> {{ $banner->title }}</h2>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
    @endif
    {{-- banner section :end --}}

    <main>
        @if (!empty($home_page_content))
            <section class=" about">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-sm-12 col-md-6 mb-2">
                            @if (@$home_page_content->image)
                                <img src="{{ $home_page_content->image }}" alt="" class="img-fluid w-100">
                            @else
                                <img src="{{ URL::asset('storage/admin/default/img1.jpg') }}" alt=""
                                    class="img-fluid w-100">
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">{!! $home_page_content->description !!}</div>
                    </div>
                </div>
            </section>
        @endif

        <section class="latest-news shadow">
            <div class="container">
                <h2 class="mainhead">Latest News <span>News</span></h2>
                @if (count($news_list) > 0)
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-8 mb-3">
                            <div class="hover hover-1 text-white rounded rounded-5"><img
                                    @if (@$news_list[0]->image) src="{{ @$news_list[0]->image }}" @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                    class="img-fluid" alt=""
                                    style="
                                    width: 850px;
                                    height: 665px;
                                ">
                                <div class="hover-overlay"></div>
                                <div class="hover-1-content px-5 py-4">
                                    <h3 class="hover-1-title text-uppercase font-weight-bold mb-0"><a
                                            href="{{ route('news.detail', @$news_list[0]->id) }}">
                                            <span class="font-weight-light">{{ @$news_list[0]->news_name }}
                                            </span></a></h3>
                                    {{-- <p class="hover-1-description font-weight-light mb-0">{{ @$news_list[0]->description }}. --}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            @if (isset($news_list[1]))
                                <div>
                                    <div class="hover hover-1 text-white rounded rounded-5"><img
                                            @if (@$news_list[1]->image) src="{{ @$news_list[1]->image }}" @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                            class="img-fluid" alt="" style="width: 415px;height: 290px;">
                                        <div class="hover-overlay"></div>
                                        <div class="hover-1-content px-5 py-4">
                                            <h4 class="hover-1-title text-uppercase font-weight-bold mb-0"><a
                                                    href="{{ route('news.detail', @$news_list[1]->id) }}">
                                                    <span class="font-weight-light">{{ @$news_list[1]->news_name }}
                                                    </span></a></h4>
                                            {{-- <p class="hover-1-description font-weight-light mb-0">
                                                {{ @$news_list[1]->description }}</p> --}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (isset($news_list[2]))
                                <div class="mt-3">
                                    <div class="hover hover-1 text-white rounded rounded-5"><img
                                            @if (@$news_list[2]->image) src="{{ @$news_list[2]->image }}" @else src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                            class="img-fluid" alt="" style="width: 415px;height: 290px;">
                                        <div class="hover-overlay"></div>
                                        <div class="hover-1-content px-5 py-4">
                                            <h4 class="hover-1-title text-uppercase font-weight-bold mb-0"><a
                                                    href="{{ route('news.detail', @$news_list[2]->id) }}">
                                                    <span class="font-weight-light">{{ @$news_list[2]->news_name }}
                                                    </span> </a></h4>
                                            {{-- <p class="hover-1-description font-weight-light mb-0">
                                                {{ @$news_list[2]->description }}</p> --}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <h3 class="text-center">Latest News Not Found!!</h3>
                @endif
            </div>
        </section>

        <section class="past-tournament">
            <h2 class="mainhead">Past Tournaments <span>Tournaments</span></h2>
            @if (count($past_tournaments) > 0)
                <div class="container text-center my-3">
                    <div class="row mx-auto my-auto justify-content-center">
                        <div id="tournamentCarousel" class="carousel slide tournamentslide" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                @foreach ($past_tournaments as $p_key => $p_tournament)
                                    <div class="carousel-item @if ($p_key == 0) active @endif">
                                        <div class="col-md-3 p-2">
                                            <div class="card rounded-4">
                                                <div class="card-img ">
                                                    <img src="{{ $p_tournament->image }}"
                                                        class="img-fluid rounded-4 myImg">
                                                </div>
                                                <div class="card-img-overlay mytitle">{{ $p_tournament->title }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev w-aut rounded-3 p-2" href="#tournamentCarousel" role="button"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next w-aut rounded-3 p-2" href="#tournamentCarousel" role="button"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <h3 class="text-center">Past Tournaments Not Found!!</h3>
            @endif
            <div id="myModal" class="modal">
                <div class="modal-header">
                    <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <img class="modal-content" id="img01">
                <p id="title" class="modal-title"></p>
            </div>
        </section>


        <section class="sponsors">
            <h2 class="mainhead">Our Sponsors <span>Sponsors</span></h2>
            @if (count($sponsors) > 0)
                <div class="container">
                    <div class="row">
                        <div class="d-flex flex-wrap justify-content-evenly">
                            @foreach ($sponsors as $s_key => $sponsor)
                                <div class="d-flex justify-content-center"><img src="{{ $sponsor->image }}"
                                        alt="" class="img-fluid"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <h3 class="text-center">Sponsors Not Found!!</h3>
            @endif
        </section>
    </main>
@endsection
@section('scripts')
    <script>
        $('#close').click(function() {
            modal.style.display = "none";
        });
     
        // JavaScript
        var images = document.getElementsByClassName('myImg');
        var titles = document.getElementsByClassName('mytitle');
        var modal = document.getElementById('myModal');
        var modalImg = document.getElementById("img01");
        var modalTitle = document.getElementById("title");

        // Loop through all images and attach click event
        for (var i = 0; i < images.length; i++) {
            images[i].onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.src;
                var index = Array.prototype.indexOf.call(images, this); // Get index of clicked image
                modalTitle.textContent = titles[index].textContent; // Set title text
            }
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endsection
