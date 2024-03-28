@extends('layouts.app')
@section('title', 'Photo’s')
@section('links')
    <style>
        .images {
            margin-top: 10px;
            border-radius: 15px;
            width: 425px;
            height: 265px;
        }

        #myImg:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 200px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 45%;
            //max-width: 75%;
        }

        .photo-title {
            color: #0A2D7C;
            font-size: 20px;
            font-weight: 700;
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

            .images {
                margin-top: 10px !important;
            }

        }
    </style>
@endsection
@section('content')
    <section class="inner-header aboutus">
        <img src="{{ asset('storage/frontend/assets/dist/images/photo.png') }}" alt="" class="img-fluid w-100 ">
        <div class="innerheader-text">
            <h2>PHOTO’S</h2>
        </div>
    </section>
    <main>
        <section class="about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($photos as $key => $photo)
                                <div class="col-md-4 text-center">
                                    <img src="{{ $photo->image }}" class="img-fluid images myImg"
                                        @if (($key + 1) % 3 == 2) style="margin-top: 40px;" @endif>
                                    <p class="text-center photo-title">{{ $photo->title }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div id="myModal" class="modal">
            <img class="modal-content" id="img01">
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        // Get the modal
        var images = document.getElementsByClassName('myImg');
        var modal = document.getElementById('myModal');
        var modalImg = document.getElementById("img01");

        // Loop through all images and attach click event
        for (var i = 0; i < images.length; i++) {
            images[i].onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.src;
                modalImg.alt = this.alt;
                captionText.innerHTML = this.alt;
            }
        }

        // When the user clicks on <span> (x), close the modal
        modal.onclick = function() {
            img01.className += " out";
            setTimeout(function() {
                modal.style.display = "none";
                img01.className = "modal-content";
            }, 400);
        }
    </script>
@endsection
