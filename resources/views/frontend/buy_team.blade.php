@extends('layouts.app')
@section('content')
    <section class="breadcrumbs"
        style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
            <h2>Buy Team</h2>
        </div>
    </section>

    <section class="buy-team">
        <div class="container">
            <form id="buyTeam" method="POST" action="{{ route('store.team') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="box-form">
                            <div class="step-content active mt-3" id="step-1">
                                <div class="form-group row g-3 pb-3">
                                    <div class="col-sm-12">
                                        <label for="team_name" class="form-label login-label">Team Name <span
                                                class="validation">*</span></label>
                                        <input type="text" name="team_name" class="form-control login-input"
                                            id="team_name" placeholder="Team Name" maxlength="25">
                                        @error('team_name')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="description" class="form-label login-label">Description <span
                                                class="validation">*</span></label><br>
                                        <textarea name="description" class="form-control login-input" id="description" cols="45" rows="5"
                                            maxlength="250" placeholder="Description"></textarea>
                                        @error('description')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Image <span class="validation">*</span></label>
                                            <div class="">
                                                <input type="file" name="image" class="form-control" id="imgInp"
                                                    accept="image/*" data-rule-required="true"
                                                    data-msg-accept="Please upload file in these format only (jpg, jpeg, png)." />
                                                {{-- <input type="hidden" name="oldimage" class="form-control" id="image"
                                                    placeholder="showphotos" value="{{ @$user->image }}"> --}}
                                            </div>
                                            @error('image')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <img id="blah"
                                            style="border: 1px solid #adb5bd !important; border-radius: 13px !important;"
                                            @if (@$user->image) src=""
                                                @else
                                                    src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                            onerror="this.src='{{ URL::asset('storage/default/img1.jpg') }}'"
                                            alt="Your Slider Image" width="200px" height="150px" />
                                    </div>
                                    <button type="submit" class="btn btn-primary">Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-12">
                        <div class="player-list">
                            <h4>Player List</h4>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <span id="content_error" class="error"></span>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Genders</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @if (count(@$player) > 0)
                                            @foreach (@$player as $players)
                                                <tr>
                                                    <th><input class="form-check-input" name="member_id[]" type="checkbox"
                                                            value="{{ $players->id }}" id="flexCheckIndeterminate"></th>
                                                    <th>{{ $counter }}</th>
                                                    <td>{{ $players->user->first_name }} {{ $players->user->last_name }}
                                                    </td>
                                                    <td>{{ $players->user->phone }}</td>
                                                    <td>{{ $players->user->address ?? '-' }}</td>
                                                    <td>{{ $players->user->gender ?? '-' }}</td>
                                                </tr>
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">
                                                    <h5 class="text-center mt-2">Player Not Found!!</h5>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
        $(document).ready(function() {
            var form = $('#buyTeam');

            form.validate({
                errorClass: 'text-danger',
                rules: {
                    team_name: 'required',
                    description: 'required',
                    "member_id[]": {
                        required: true,
                        minlength: 1,
                        maxlength: 18
                    }
                },
                messages: {
                    "member_id[]": {
                        required: "Please select at least one player.",
                        minlength: "Please select at least one player.",
                        maxlength: "You can select maximum 18 players."
                    },
                },
                errorPlacement: function(error, element) {
                    if (element.attr("type") == "checkbox") {
                        error.appendTo('#content_error');
                    } else {
                        error.insertAfter(element);
                    }
                },

                submitHandler: function(form) {
                    // form.submit();
                    event.preventDefault();

                    // Get form data
                    // var formData = $(form).serialize();
                    var formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('store.team') }}",
                        type: "POST",
                        contentType: 'multipart/form-data',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            // Handle successful response
                            console.log("response", response);
                            if (response.url) {
                                window.location.href = response.url;
                            } else {
                                console.log("here");
                                if (response.status == false) {
                                    console.log("here333");
                                    toastr.error(response.message);
                                }
                                console.error('Missing "url" property in the response.');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error("xhr.responseText");
                            console.log("error", error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
