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
                                    <!-- Left side content -->
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item ">Sponsors List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                    <!-- Right side content -->
                                    <button type="button" class="btn btn-primary" onclick="showModal()">
                                        <i class="fa fa-plus"></i>&nbsp;Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body table-responsive">
                    <table id="sponsorTable" class="table table-borderless table-thead-bordered table-align-middle"
                        style="border: 1px solid #dee2e6;border-radius: 4px;">
                        <thead class="thead-light">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal" tabindex="-1" data-backdrop="static" role="dialog">
        <div class="modal-dialog" role="document" style="width: 600px;">
            <div class="modal-content">
                <form method="POST" id="sponsor_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add Sponsors</h5>
                        <input type="hidden" name="id" id="sponsor_id" />
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title"> Title <span class="validation">*</span></label>
                            <input type="text" name="title" class="form-control" id="title" maxlength="50" placeholder="Title">
                            <span id="title_error" class="error text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="title"> Order <span class="validation">*</span></label>
                            <input type="number" name="order" class="form-control" id="order" placeholder="Order">
                            <span id="order_error" class="error text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="rating">Image <span class="validation">*</span></label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="image" id="imgInp">
                                <input type="hidden" name="old_image" id="old_image">
                            </div>
                            <span id="image_error" class="error"></span>
                        </div>
                        <div class="form-group text-center">
                            <img id="blah"
                                style="border: 1px solid #adb5bd !important; border-radius: 13px !important;" width="200px"
                                height="150px" />
                        </div>
                        <div id="loader" class="overlay dark" style="display: none;">
                            <i class="fas fa-2x fa-sync-alt"></i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="addSponsor()" class="btn btn-primary" id="buttonSponsor">Save
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }

        var sponsorTable
        $(document).ready(function() {
            sponsorTable = $('#sponsorTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: "{{ route('admin.get.sponsors') }}",
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
                        data: 'title',
                    },
                    {
                        data: 'order',
                    },
                    {
                        data: 'is_active',
                        render: function(data, type, row) {
                            var id = row.id;
                            var is_active = row.is_active;
                            var classname = is_active === 1 ? 'checked' : '';
                            var title = is_active === '1' ? 'Active' : 'In-Active';
                            return "<label class='switch' onclick='toggleSponsor(\"" + row.id +
                                "\", " + is_active + ")'><input type='checkbox' " + classname +
                                " ><span class='slider round'></span></label>";
                        }
                    },
                    {
                        width: "10%",
                        data: 'action',
                        render: function(data, type, row) {
                            let html = "";
                            html += "<a class='edit' onclick='editSponsor(\"" +
                                row.id + "\")'><i class='fa fa-edit'></i></a>"

                            html +=
                                "<button type='submit' class='delete' style='border:0px;' onclick='deleteSponsor(\"" +
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

            $("#sponsor_form").validate({
                rules: {
                    title: {
                        required: true,
                    },
                    order: {
                        required: true,
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
                    if (element.attr("name") == "icon") {
                        error.appendTo('#rating_error');
                    } else if (element.attr("name") == "image") {
                        error.appendTo('#image_error');
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $('#myModal').on('hidden.bs.modal', function(e) {
                $('#description').val('');
                $('#home_id').val('');
                $('#old_image').val('');
                $('#title').val('');
                $('#order').val('');
                $('#imgInp').val('');
                $('.error').empty()
            })
        });

        function deleteSponsor(id) {
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
                    var userURL = BASE_URL + "/admin/sponsors/" + id;

                    $.ajax({
                        url: userURL,
                        type: "DELETE",
                        dataType: "json",
                        url: userURL,
                        success: function(response) {
                            toastr.success(response.message)
                            sponsorTable.draw();
                        }
                    });
                }
            })
        }

        function toggleSponsor(id, status) {
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
                    var userURL = BASE_URL + "/admin/toggle-sponsors/" + id;
                    $.ajax({
                        url: userURL,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            toastr.success(response.message)
                            sponsorTable.draw();
                        }
                    });
                } else {
                    sponsorTable.draw()
                }
            })
        }

        function showModal() {
            $("#modal_title").text("Create Sponsors");
            $("#buttonSponsor").text("save");
            $('#myModal').modal('show');
            $('#blah').attr('src', "{{ URL::asset('storage/admin/default/img1.jpg') }}");
        }

        function addSponsor() {
            if ($("#sponsor_form").valid()) {
                var form = $('#sponsor_form')[0];
                var formData = new FormData(form);
                $('#loader').show()

                var id = $('#sponsor_id').val()
                if (id)
                    var link = BASE_URL + "/admin/update-sponsors" + (id ? "/" + id : "");

                else
                    var link = BASE_URL + "/admin/sponsors";
                $.ajax({
                    type: id ? 'POST' : 'POST',
                    url: link,
                    data: formData,
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#loader').hide()
                        if (response?.success) {
                            $('#myModal').modal('hide');
                            sponsorTable.draw()
                            toastr.success(response.message)
                        }
                    },
                    error: function(e) {
                        if (e.responseJSON && e.responseJSON.errors) {
                            if (e.responseJSON.errors.order && e.responseJSON.errors.order.length > 0) {
                                $('#order_error').text(e.responseJSON.errors.order[0]);
                            }
                            if (e.responseJSON.errors.title && e.responseJSON.errors.title.length > 0) {
                                $('#title_error').text(e.responseJSON.errors.title[0]);
                            }
                            $('#loader').hide();
                        } else if (e.responseJSON && e.responseJSON.message) {
                            $('#name_error').text(e.responseJSON.message);
                            $('#loader').hide();
                        } else {
                            console.log("Unexpected error occurred:", e);
                            $('#loader').hide();
                        }


                    }
                })
            }
        }

        function editSponsor(id) {
            $.ajax({
                type: "Get",
                url: "{{ route('admin.sponsors.edit', ['sponsor' => ':id']) }}".replace(':id', id),
                success: function(response) {
                    $("#buttonSponsor").text("update");
                    $('#old_image').val(response.image);
                    $('#title').val(response.title)
                    $('#order').val(response.order)
                    if (response.image) {
                        $('#blah').attr('src', response.image);
                    } else {
                        // If no image URL is available, show a default image
                        $('#blah').attr('src', "{{ URL::asset('storage/admin/default/img1.jpg') }}");
                    }
                    $("#modal_title").text("Update Sponsors");
                    $('#sponsor_id').val(id);
                    $('#myModal').modal('show');
                }
            });
        }
    </script>
@endsection
