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
                                        <li class="breadcrumb-item ">Teams List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                    {{-- <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>&nbsp;Add</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body table-responsive">
                    <table id="teamTable" class="table table-borderless table-thead-bordered table-align-middle"
                        style="border: 1px solid #dee2e6;border-radius: 4px;">
                        <thead class="thead-light">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Captain Name</th>
                                <th>Captain Email</th>
                                <th>Members</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var teamTable
        $(document).ready(function() {
            teamTable = $('#teamTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: "{{ route('admin.get.teams') }}",
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
                        width: "40%",
                        data: 'team_name',
                    },
                    {
                        data: 'buyer_name',
                        render: function(data, type, row) {
                            if (row.user) {
                                return row.user.first_name + ' ' + row.user.last_name;
                            } else {
                                return " ";
                            }
                        }
                    },
                    {
                        data: 'email',
                        render: function(data, type, row) {
                            if (row.user) {
                                return row.user.email;
                            } else {
                                return " ";
                            }
                        }
                    },
                    {
                        data: 'team_member_count',
                    },
                    // {
                    //     data: 'description',
                    // },
                    {
                        data: 'is_active',
                        render: function(data, type, row) {
                            var id = row.id;
                            var is_active = row.is_active;
                            var classname = is_active === 1 ? 'checked' : '';
                            var title = is_active === '1' ? 'Active' : 'In-Active';
                            return "<label class='switch' onclick='toggleTeam(\"" + row.id +
                                "\", " + is_active + ")'><input type='checkbox' " + classname +
                                " ><span class='slider round'></span></label>";
                        }
                    },
                    {
                        width: "10%",
                        data: 'action',
                        render: function(data, type, row) {
                            let html = "";
                            html += "<a class='delete' href='" + BASE_URL + "/admin/teams/" +
                                row.id +
                                "/edit'><i class='fa fa-edit'></i></a>"

                            html +=
                                "<button type='submit' class='delete' style='border:0px;' onclick='deleteTeam(\"" +
                                row.id +
                                "\")'><i class='fa fa-trash' style='color:red'></i></button>";
                            return html;
                        }
                    },
                ],
            });

            // $.validator.addMethod('filesize', function(value, element, param) {
            //     return this.optional(element) || (element.files[0].size <= param * 1000000)
            // }, 'File size must be less than {0} MB');

            $("#news_form").validate({
                rules: {
                    description: {
                        required: true,
                    },
                    image: {
                        required: function() {
                            var image = $('#old_image').val();
                            return image == null || image == "" || image == undefined;
                        },
                        extension: "jpg|jpeg|png",
                        // filesize: 2
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
        });

        function deleteTeam(id) {
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
                    var userURL = BASE_URL + "/admin/teams/" + id;

                    $.ajax({
                        url: userURL,
                        type: "DELETE",
                        dataType: "json",
                        url: userURL,
                        success: function(response) {
                            toastr.success(response.message)
                            teamTable.draw();
                        }
                    });
                }
            })
        }

        function toggleTeam(id, status) {
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
                    var userURL = BASE_URL + "/admin/toggle-teams/" + id;
                    $.ajax({
                        url: userURL,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            toastr.success(response.message)
                            teamTable.draw();
                        }
                    });
                } else {
                    teamTable.draw()
                }
            })
        }
    </script>
@endsection
