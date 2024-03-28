@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="cards card-defaults">
            <div class="card">
                <section class="content-header">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>About Us </h5>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <form action="{{ route('admin.about.us.store') }}" method="post" id="about_us_form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ @$about_us->id }}">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="president">President <span class="validation">*</span></label>
                                            <input type="text" name="president" class="form-control" id="president"
                                                placeholder="President" value="{{ @$about_us->president }}" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vice_president">Vice President <span
                                                    class="validation">*</span></label>
                                            <input type="text" name="vice_president" class="form-control"
                                                id="vice_president" placeholder="Vice President"
                                                value="{{ @$about_us->vice_president }}" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="treasurer">Treasurer <span class="validation">*</span></label>
                                            <input type="text" name="treasurer" class="form-control" id="treasurer"
                                                placeholder="Treasurer" value="{{ @$about_us->treasurer }}" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="general_secretary">General Secretary <span
                                                    class="validation">*</span></label>
                                            <input type="text" name="general_secretary" class="form-control"
                                                id="general_secretary" placeholder="General Secretary"
                                                value="{{ @$about_us->general_secretary }}" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="league_manager">League Manager<span
                                                    class="validation">*</span></label>
                                            <input type="text" name="league_manager" class="form-control"
                                                id="league_manager" placeholder="League Manager"
                                                value="{{ @$about_us->league_manager }}" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="latitude">Latitude<span class="validation">*</span></label>
                                            <input type="text" name="latitude" class="form-control" id="latitude"
                                                placeholder="Latitude" value="{{ @$about_us->latitude }}" maxlength="70">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="longitude">Longitude<span class="validation">*</span></label>
                                            <input type="text" name="longitude" class="form-control" id="longitude"
                                                placeholder="Longitude" value="{{ @$about_us->longitude }}" maxlength="70">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="longitude">Image<span class="validation">*</span></label>
                                            <input type="file" name="image" class="form-control" id="imgInp"
                                                accept="image/*" data-rule-required="true"
                                                data-msg-accept="Please upload file in these format only (jpg, jpeg, png)." />
                                            <input type="hidden" name="oldimage" class="form-control" id="old_image"
                                                placeholder="showphotos" value="{{ @$about_us->image }}">
                                            <span id="image_error" class="error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="body">Content<span class="validation">*</span></label>
                                            <textarea name="body" id="body" placeholder="body" cols="20" rows="10" class="form-control">{{ @$about_us->body }}</textarea>
                                            <span id="description_error" class="error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <img id="blah"
                                            style="border: 1px solid #adb5bd !important; border-radius: 13px !important;"
                                            @if (@$about_us->image) src="{{ @$about_us->image }}"
                                            @else
                                                src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                            onerror="this.src='{{ URL::asset('storage/default/img1.jpg') }}'"
                                            alt="Your Slider Image" width="200px" height="150px" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary float-right">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('#body').summernote({
                height: 600 // Set the height to 300 pixels
            });
        });

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }

        var homePageTable
        $(document).ready(function() {

            jQuery.validator.addMethod("requiredSummernote", function() {
                return !($("#body").summernote('isEmpty'));
            }, 'This field is required');

            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1000000)
            }, 'File size must be less than {0} MB');


            $("#about_us_form").validate({
                ignore: [],
                rules: {
                    body: {
                        requiredSummernote: true
                    },
                    president: {
                        required: true
                    },
                    vice_president: {
                        required: true
                    },
                    treasurer: {
                        required: true
                    },
                    general_secretary: {
                        required: true
                    },
                    league_manager: {
                        required: true
                    },
                    latitude: {
                        required: true
                    },
                    longitude: {
                        required: true
                    },
                    image: {
                        required: function() {
                            var image = $('#old_image').val();
                            return image == null || image == "" || image == undefined;
                        },
                        extension: "jpg|jpeg|png",
                        filesize: 2
                    },
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "body") {
                        error.appendTo('#description_error');
                    } else if (element.attr("name") == "image") {
                        error.appendTo('#image_error');
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });

        function deleteHome(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var userURL = BASE_URL + "/admin/home-content/" + id;

                    $.ajax({
                        url: userURL,
                        type: "DELETE",
                        dataType: "json",
                        url: userURL,
                        success: function(response) {
                            toastr.success(response.message)
                            homePageTable.draw();
                        }
                    });
                }
            })
        }

        function toggleHome(id, status) {
            var message = status ? 'inactive' : 'active';
            Swal.fire({
                title: 'Do you want to change status to ' + message + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var userURL = BASE_URL + "/admin/toggle-home-page-content/" + id;
                    $.ajax({
                        url: userURL,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            toastr.success(response.message)
                            homePageTable.draw();
                        }
                    });
                } else {
                    homePageTable.draw()
                }
            })
        }
    </script>
@endsection
