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
                                   <h5>Home Page Content</h5>
                                </div>
                                <div class="col-md-6">
                                    {{-- <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item ">HomePageContent List</li>
                                    </ol> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body">
                    <form
                        action="@if (@$home_page_content->id) {{ route('admin.home-content.update', @$home_page_content->id) }} @else {{ route('admin.home-content.store') }} @endif"
                        method="post" id="home_form" enctype="multipart/form-data">
                        @csrf
                        @if (@$home_page_content->id)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Description <span class="validation">*</span></label>
                                    <textarea name="description" id="description" placeholder="Description" cols="20" rows="10"
                                        class="form-control">{{ @$home_page_content->description }}</textarea>
                                    <span id="description_error" class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Image <span class="validation">*</span></label>
                                    <input type="file" class="form-control" name="image" id="imgInp">
                                    <span id="image_error" class="error"></span>
                                    <input type="hidden" name="old_image" id="old_image"
                                        value="{{ @$home_page_content->image }}">
                                    <div class="mt-2">
                                        <img id="blah"
                                            style="border: 1px solid #adb5bd !important; border-radius: 13px !important;"
                                            @if (@$home_page_content->image) src="{{ @$home_page_content->image }}"
                                        @else
                                            src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                            onerror="this.src='{{ URL::asset('storage/default/img1.jpg') }}'"
                                            alt="Your Slider Image" width="200px" height="150px" />
                                    </div>
                                </div>
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
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('#description').summernote({
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
            homePageTable = $('#homePageTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: "{{ route('admin.get.home.content') }}",
                },

                columns: [{
                        width: "20%",
                        data: 'image',
                        render: function(data, type, row) {
                            return "<img src='" + row
                                .image + "' height='100' width='200'>";
                        }
                    },
                    {
                        data: 'description',
                    },
                    {
                        data: 'is_active',
                        render: function(data, type, row) {
                            var id = row.id;
                            var is_active = row.is_active;
                            var classname = is_active === 1 ? 'checked' : '';
                            var title = is_active === '1' ? 'Active' : 'In-Active';
                            return "<label class='switch' onclick='toggleHome(\"" + row.id +
                                "\", " + is_active + ")'><input type='checkbox' " + classname +
                                " ><span class='slider round'></span></label>";
                        }
                    },
                    {
                        width: "10%",
                        data: 'action',
                        render: function(data, type, row) {
                            let html = "";
                            html += "<a class='edit' onclick='editHome(\"" +
                                row.id + "\")'><i class='fa fa-edit'></i></a>"

                            html +=
                                "<button type='submit' class='delete' style='border:0px;' onclick='deleteHome(\"" +
                                row.id +
                                "\")'><i class='fa fa-trash' style='color:red'></i></button>";
                            return html;
                        }
                    },
                ],
            });

            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1000000)
            }, 'File size must be less than {0} MB');

            jQuery.validator.addMethod("requiredSummernote", function() {
                return !($("#description").summernote('isEmpty'));
            }, 'This field is required');

            $("#home_form").validate({
                ignore: [],
                rules: {
                    description: {
                        requiredSummernote: true
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
                    if (element.attr("name") == "description") {
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
