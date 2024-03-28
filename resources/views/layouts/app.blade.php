<!doctype html>
<html lang="en">

<head>
    @php

        $general_setting = general_setting();
        $favicon = '';
        if (!empty($general_setting)) {
            $favicon = $general_setting->favicon;
        } else {
            $favicon = URL::asset('storage/frontend/assets/dist/assets/favicon.png');
        }
        $cms = cms();
        $live_score = live_score();
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{-- @if ($general_setting->site_name)
            {{ $general_setting->site_name }} · @yield('title')
        @else
            Northren Alberta Cricket Association · @yield('title')
        @endif --}}
        @if ($general_setting->site_name)
            {{ $general_setting->site_name }} @if (!Route::is('home'))
                · @yield('title')
            @endif
        @else
            Northren Alberta Cricket Association @if (!Route::is('home'))
                · @yield('title')
            @endif
        @endif
    </title>
    <link href="{{ asset('storage/frontend/assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/frontend/assets/dist/css/animate.min.css') }}" rel="stylesheet">
    <script src="{{ asset('storage/frontend/assets/dist/js/50dac43d5e.js') }}" crossorigin="anonymous"></script>

    <link href="{{ asset('storage/frontend/assets/dist/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/frontend/assets/dist/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/frontend/assets/dist/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('storage/frontend/assets/dist/plugins/toastr/toastr.min.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!--================= site favicon icon =================-->
    <link rel="shortcut icon" type="image/png" href="{{ @$favicon }}">

    @yield('links')
    <script>
        var BASE_URL = "{{ url('/') }}";
    </script>
    <style>
        .dropdown-menu {
            display: none;
        }

        .nav-item:hover .dropdown-menu {
            display: block;
        }

        #search-results {
            position: absolute;
            top: 55%;
            left: 1097px;
            z-index: 999;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        #search-results li {
            padding: 10px;
            list-style: none;
            border-bottom: 1px solid #ccc;
        }

        #search-results li:last-child {
            border-bottom: none;
        }

        #search-results li:hover {
            background-color: #f4f4f4;
            cursor: pointer;
        }

        /* .select2-container .select2-selection--single {
        width: 250px !important;
        height: 35Px !important;
    } */
    </style>

</head>

<body>
    <section class="main-header fixed-top">
        <div class="container">
            <header class="">
                <nav class="navbar navbar-expand-lg p-0 m-0">
                    <div class="container-fluid">
                        <a class="navbar-brand ms-5" href="{{ route('home') }}"><img
                                @if ($general_setting->logo) src="{{ $general_setting->logo }}" @else
                                src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                class="img-fluid" alt="" style="border-radius: 50%;width: 115px;"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse mb-4" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                {{-- <li class="nav-item">
                                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page"
                                        href="{{ route('home') }}">Home</a>
                                </li> --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::is('about-us') ? 'active' : '' }} "
                                        href="{{ route('about.us') }}">About</a>
                                    <ul class="dropdown-menu">
                                        <a class="dropdown-item  {{ Request::is('photo-gallery') ? 'active' : '' }} "
                                            href="{{ route('photo.gallery') }}">Photos</a>
                                        <li><a class="dropdown-item" href="{{ route('by.laws') }}">By Laws</a></li>
                                        <li><a class="dropdown-item {{ Request::is('league-rules') ? 'active' : '' }}"
                                                href="{{ route('league.rules') }}">League Rules</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link  {{ Request::is('news-list') ? 'active' : '' }} "
                                        href="{{ route('news.list') }}">News</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link  {{ Request::is('event-list') ? 'active' : '' }} "
                                        href="{{ route('event.list') }}">Events</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::is('team-list') ? 'active' : '' }} "
                                        href="{{ route('team.list') }}">Team</a>

                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('member.list') }}">Members</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('become.player') }}">Player</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="">Live Scores</a>

                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                @if (@$live_score->current_link) href="{{ @$live_score->current_link }}" @else href="#" @endif
                                                target="_blank">Current Scores</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                @if (@$live_score->past_link) href="{{ @$live_score->past_link }}" @else href="#" @endif
                                                target="_blank">Past Scores</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('contact-us') ? 'active' : '' }}"
                                        href="{{ route('contact.us') }}">Contact</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-user"></i>
                                    </a>

                                    <ul class="dropdown-menu">
                                        @auth
                                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                        @else
                                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                            @if (Route::has('register'))
                                                <li><a class="dropdown-item" href="{{ route('register') }}">Register</a>
                                                </li>
                                            @endif
                                        @endauth
                                    </ul>
                                </li>
                            </ul>
                            {{-- <form class="d-flex" role="search">
                                <div class="input-group">
                                    <input class="form-control border-end-0 border rounded-pill" type="search"
                                        id="example-search-input">
                                    <span class="input-group-append">
                                        <button
                                            class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5"
                                            type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form> --}}

                            {{-- <ul id="search-results"></ul> --}}
                        </div>
                    </div>
                </nav>

            </header>
        </div>
    </section>
    <div>
        @yield('content')
    </div>


    <footer>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-5 col-xs-12">
                        <div class="single_footer single_footer_address">
                            <h4>About</h4>
                            <div>
                                <p><img @if (@$general_setting->logo) src="{{ @$general_setting->logo }}" @else
                                    src="{{ asset('storage/frontend/assets/dist/images/logo.png') }}" @endif
                                        alt="" style="border-radius: 50%;height: 87px;width: 87px;"></p>Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.
                                Phasellus efficitur, lorem nec volutpat
                                blandit,
                            </div>
                        </div>
                        <div class="social_profile">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div><!--- END COL -->
                    <div class="col-md-8 col-sm-7 col-xs-12">
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-xs-12">
                                <div class="single_footer">
                                    <h4>Company</h4>
                                    <ul>
                                        <li><a href="{{ route('home') }}">Home</a></li>
                                        <li><a href="{{ route('about.us') }}">About</a></li>
                                        <li><a href="{{ route('photo.gallery') }}">Photos</a></li>
                                        <li><a href="{{ route('by.laws') }}">ByLaws</a></li>
                                        {{-- <li><a href="#">Account</a></li> --}}
                                        <li><a href="{{ route('contact.us') }}">Contact</a></li>
                                    </ul>
                                </div>
                            </div><!--- END COL -->
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="single_footer single_footer_address">
                                    <h4>By LAWS</h4>
                                    <ul>
                                        <li><a href="{{ route('member.list') }}">MEMBER LIST</a></li>
                                        <li><a href="{{ route('team.list') }}">TEAM LIST</a></li>
                                        <li><a href="{{ route('league.rules') }}">LEAGUE RULES</a></li>
                                    </ul>
                                </div>
                            </div><!--- END COL -->
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="single_footer single_footer_address">
                                    <h4>Safety</h4>
                                    <ul>
                                        @foreach ($cms as $cms_pages)
                                            <li><a
                                                    href="{{ route('cms.page', $cms_pages->id) }}">{{ $cms_pages->cms_page_name }}</a>
                                            </li>
                                        @endforeach
                                        {{-- <li><a href="{{ route('cms.privacy') }}">PRIVACY POLICY</a></li> --}}
                                    </ul>
                                </div>
                            </div><!--- END COL -->
                        </div>
                    </div>
                </div><!--- END ROW -->

            </div><!--- END CONTAINER -->
            <div class="footer-copyright">
                <div class="container">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <p class="copyright">© 2014 - 2024 Northern Alberta Cricket Association. All Rights Reserved,
                            Powered By <a href="http://viqsa.com/" target="blank">Viqsa</a>.</p>
                    </div>
                </div>
                <!--- END COL -->
            </div><!--- END ROW -->
        </div>
    </footer>

    <script src="{{ asset('storage/frontend/assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('storage/frontend/assets/dist/js/jquery.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"> --}}
    </script>
    <script src="{{ asset('storage/frontend/assets/dist/js/popper.min.js') }}"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="{{ asset('storage/frontend/assets/dist/plugins/bootstrap/bootstrap.min.js') }}"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script> --}}

    <script src="{{ asset('storage/frontend/assets/dist/js/main.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script> --}}
    <script src="{{ asset('storage/frontend/assets/dist/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('storage/frontend/assets/dist/js/additional-methods.js') }}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script> --}}
    <script src="{{ asset('storage/frontend/assets/dist/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('storage/frontend/assets/dist/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('storage/frontend/assets/dist/plugins/select2/select2.min.js') }}"></script>
    <script>
        $(".select2").select2();

        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif

        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }

        //search: start
        $('#example-search-input').on('keyup', function() {
            var keyword = $(this).val();
            if (keyword.length > 0) {
                search();
            } else {
                $('#search-results').empty(); // Clear the search results if the keyword is empty
            }
        });
        search();

        function search() {
            var keyword = $('#example-search-input').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (keyword) {

                var link = BASE_URL + "/search/" + keyword;

                $.ajax({
                    type: 'GET',
                    url: link,
                    success: function(response) {
                        $('#search-results').empty();

                        // Loop through the response data and append names to the result list
                        response.data.forEach(function(item) {
                            var route = "{{ route('news.detail', ['id' => ':id']) }}".replace(':id',
                                item.id);
                            $('#search-results').append('<li><a href="' + route + '">' + item
                                .news_name + '</a></li>');
                        });


                    }
                })
            }
        }
        //search : end
    </script>
    @yield('scripts')

</body>

</html>
