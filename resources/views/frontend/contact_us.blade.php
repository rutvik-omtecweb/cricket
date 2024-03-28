@extends('layouts.app')
@section('title', 'Contact Us')
@section('links')
    <style>
        span.validation {
            color: red;
        }

        label.error {
            padding-top: 5px;
            color: red;
            font-weight: 300 !important;
            font-size: 14px;
        }

        .form-control {
            color: var(--bs-body-color) !important;
        }
    </style>
@endsection
@section('content')
    <section class="breadcrumbs" style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>Contact US</h2>
        </div>
    </section>
    <main>
        <section class="contact">
            <div class="container">
                <div class="row mb-5">
                    <h2 class="mainhead mt-5">Contact <span>Contact</span></h2>
                    <p class="fs-4 text-center">NACA is a recreational sports organization carrying the mission to promote
                        the game
                        of Cricket in Fort McMurray & Wood Buffalo area. If you are residing in Fort Mcmurray and would like
                        to play
                        Cricket
                        please contact us.</p>
                </div>

                <div class="row align-items-center">
                    <div class="col-12 col-sm-12 col-md-7">
                        <div class="card mb-3 contact-card rounded-5 border-4">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                        <div class="pe-2 col-1"><img
                                                src="{{ asset('storage/frontend/assets/dist/images/map.png') }}"
                                                alt=""></div>
                                        <div class="">{{ @$general_setting->address }}</div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                        <div class="pe-2 col-1"><img
                                                src="{{ asset('storage/frontend/assets/dist/images/phone.png') }}"
                                                alt=""></div>
                                        <div class="">{{ @$general_setting->phone }}</div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                        <div class="pe-2 col-1"><img
                                                src="{{ asset('storage/frontend/assets/dist/images/mail.png') }}"
                                                alt=""></div>
                                        <div class="">{{ @$general_setting->email }}</div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                        <div class="pe-2 col-1"><img
                                                src="{{ asset('storage/frontend/assets/dist/images/website.png') }}"
                                                alt=""></div>
                                        {{-- <div class="">www.cricketfortmcmurray.com</div> --}}
                                        <div class="">{{ url('/') }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card rounded-5 mb-4">
                            {{-- <div class="card-body">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2187.6646321492503!2d-111.48437502277011!3d56.74872481484543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x53b009a623a5d06b%3A0x685e0ccf2c6d0704!2s220%20Swanson%20Cres%20%231%2C%20Fort%20McMurray%2C%20AB%20T9K%202W5%2C%20Canada!5e0!3m2!1sen!2sin!4v1709101179287!5m2!1sen!2sin"
                                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade" class="rounded-5"></iframe>
                            </div> --}}
                            <div id="map"
                                style="height: 294px;cursor: pointer;position: relative;border-radius: 30px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-5 mb-2 login">
                        <form action="{{ route('contact.us.request') }}" method="POST" id="contactUsForm">
                            @csrf
                            <div class="mb-3">
                                <label for="subject" class="form-label">SUBJECT <span class="validation">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="subject" name="subject"
                                    aria-describedby="emailHelp" placeholder="Enter subject" maxlength="50">
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="full_name" class="form-label">NAME <span class="validation">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="full_name" name="full_name"
                                    placeholder="Enter name" maxlength="45">
                                @error('full_name')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="validation">*</span></label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email"
                                    placeholder="Enter email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message <span class="validation">*</span></label>
                                <textarea class="form-control" name="message" id="message" rows="5" placeholder="Enter your message"></textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                                <span id="content_error"></span>
                            </div>
                            <div class="d-grid gap-2 pt-4">
                                <input type="submit" class="btn btn-primary d-block default-btn" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>

    </main>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
        crossorigin=""></script>
    <script>
        $("#contactUsForm").validate({
            rules: {
                subject: {
                    required: true,
                },
                full_name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                message: {
                    required: true,
                },
            },
            errorPlacement: function(error, element) {
                if (element.is('textarea')) {
                    error.appendTo('#content_error');
                } else {
                    error.insertAfter(element);
                }
            }
        })

        var map;
        var popup;
        setMap();

        function setMap() {
            if (map && map.remove) {
                map.off();
                map.remove();
            }
            setTimeout(() => {

                map = L.map('map').setView([56.749780879750304, -111.48197166137271], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '<a href="javascript:void(0)" target="_blank">{{ @$data->site_name }}</a>',
                    gestureHandling: true,
                    zoomControl: true // Enable zoom control
                }).addTo(map);
                popup = L.popup();
                var lat = "56.749780879750304";
                var lon = "-111.48197166137271";
                if (lat && lon) {
                    // Reverse geocoding using Nominatim
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            let address = data.display_name; // Get the formatted address
                            popup.setLatLng({
                                lat: lat,
                                lng: lon
                            }).setContent(address).openOn(map); // Display the address in the popup
                        })
                        .catch(error => {
                            console.error('Error fetching address:', error);
                        });
                    L.marker([lat, lon]).addTo(map).openPopup();
                }
            }, 1000);
        }
    </script>
@endsection
