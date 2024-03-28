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
                                        <li class="breadcrumb-item active">Contact Us List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body">
                    <table id="contactUsTable" class="table table-borderless table-thead-bordered table-align-middle"
                        style="border: 1px solid #dee2e6;border-radius: 4px;">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
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
        var contactUsTable
        $(document).ready(function() {
            contactUsTable = $('#contactUsTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: "{{ route('admin.get.contact.us') }}",
                },

                columns: [{
                        data: 'full_name',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'subject',
                    },
                    {
                        data: 'message',
                    },
                    {
                        width: "20%",
                        data: 'action',
                        render: function(data, type, row) {
                            let html = "";
                            html +=
                                "<button type='submit' class='delete' style='border:0px;' onclick='contactUsDelete(\"" +
                                row.id +
                                "\")'><i class='fa fa-trash' style='color:red'></i></button>";
                            return html;
                        }
                    },
                ],
            });
        });


        function contactUsDelete(id) {
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
                    var userURL = BASE_URL + "/admin/contact-us/" + id;

                    $.ajax({
                        url: userURL,
                        type: "DELETE",
                        dataType: "json",
                        url: userURL,
                        success: function(response) {
                            toastr.success(response.message)
                            contactUsTable.draw();
                        }
                    });
                }
            })
        }

    </script>
@endsection
