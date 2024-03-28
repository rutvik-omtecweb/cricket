@extends('layouts.app')
@section('title', 'About')
@section('content')

    <section class="breadcrumbs" style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>ABOUT US</h2>
        </div>
    </section>
    <main>
        <section class=" about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-12 col-md-7">
                        <p> {!! @$about_us->body !!}</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-5 mb-2">
                        <p><img @if (@$about_us->image) src="{{ @$about_us->image }}"
                            @else
                                src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                alt="" class="img-fluid w-100"
                                style="
                                border-radius: 30px;
                            ">
                        </p>
                        <p>
                        <div id="map" style="height: 294px;cursor: pointer;position: relative;border-radius: 30px;">
                        </div>
                        </p>
                    </div>
                </div>
            </div>

            <div class="container my-5">
                <div class="card mb-3 about-card rounded-5 border-4" style="max-width: 33rem;">
                    <h5 class="card-header">Current NACA board until 2024.</h5>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-start text-primary-emphasis">
                                <div class="me-auto">President :</div>
                                <div class="ms-auto">{{ @$about_us->president }}</div>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-start text-primary-emphasis">
                                <div class="me-auto">Vice President :</div>
                                <div class="ms-auto">{{ @$about_us->vice_president }}</div>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-start text-primary-emphasis">
                                <div class="me-auto">Treasurer :</div>
                                <div class="ms-auto">{{ @$about_us->treasurer }}</div>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-start text-primary-emphasis">
                                <div class="me-auto">General Secretary :</div>
                                <div class="ms-auto">{{ @$about_us->general_secretary }}</div>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-start text-primary-emphasis">
                                <div class="me-auto">League Manager :</div>
                                <div class="ms-auto">{{ @$about_us->league_manager }}</div>
                            </li>
                        </ul>
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
        var map;
        var popup;
        setMap();

        function setMap() {
            if (map && map.remove) {
                map.off();
                map.remove();
            }
            setTimeout(() => {
                let lat = "{{ @$about_us->latitude }}";
                let lon = "{{ @$about_us->longitude }}";
                if (lat && lon) {
                    map = L.map('map').setView([lat, lon], 15);
                } else {
                    map = L.map('map').setView([56.75269252923149, -111.48132648411813], 15);
                }
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '<a href="javascript:void(0)" target="_blank">{{ @$data->site_name }}</a>',
                    gestureHandling: true,
                    zoomControl: true // Enable zoom control
                }).addTo(map);
                popup = L.popup();
                // if (lat && lon) {
                //     popup.setLatLng({
                //         lat: lat,
                //         lng: lon
                //     }).setContent(lat + "," + lon).openOn(map);
                //     L.marker([lat, lon]).addTo(map).openPopup();
                // }
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
