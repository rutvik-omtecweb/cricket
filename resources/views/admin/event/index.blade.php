@extends('layouts.admin')
@section('style')
    <style>
        i.fas.fa-user-plus {
            color: #a34253;
        }
    </style>
@endsection

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
                                        <li class="breadcrumb-item active">Event List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                    <!-- Right side content -->
                                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>&nbsp;Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body table-responsive">
                    <table id="eventTable" class="table table-borderless table-thead-bordered table-align-middle"
                        style="border: 1px solid #dee2e6;border-radius: 4px;">
                        <thead class="thead-light">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Number Of Team</th>
                                <th>Team Price</th>
                                <th>Participant Price</th>
                                <th>Payment Members</th>
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
        var eventTable
        $(document).ready(function() {
            eventTable = $('#eventTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: "{{ route('admin.get.events') }}",
                },

                columns: [{
                        width: "20%",
                        data: 'image',
                        render: function(data, type, row) {
                            if (row.image) {
                                return `<img src="${row.image}" class="dd" height="150" width="200">`;
                            } else {
                                return `<img src="{{ URL::asset('storage/admin/default/img1.jpg') }}" height="150" width="200">`;
                            }
                        }
                    },
                    {
                        data: 'title',
                    },
                    {
                        data: 'start_date',
                    },
                    {
                        data: 'end_date',
                    },
                    {
                        data: 'number_of_team',
                    },
                    {
                        data: 'team_price',
                    },
                    {
                        data: 'participant_price',
                    },
                    {
                        data: 'payment',
                        render: function(data, type, row) {
                            let html = "";
                            html += "<a class='delete' href='" + BASE_URL +
                                "/admin/purchase-team-view/" +
                                row.id +
                                "' Title='Purchase Team'><i class='fas fa-gift'></i></a> ";
                            html += "<a class='delete' href='" + BASE_URL +
                                "/admin/event-participant-payment-view/" +
                                row.id +
                                "' Title='Participant'><i class='fas fa-user-plus'></i></a>"
                            return html;
                        }
                    },
                    {
                        data: 'is_active',
                        render: function(data, type, row) {
                            var id = row.id;
                            var is_active = row.is_active;
                            var classname = is_active === 1 ? 'checked' : '';
                            var title = is_active === '1' ? 'Active' : 'In-Active';
                            return "<label class='switch' onclick='toggleEvent(\"" + row.id +
                                "\", " + is_active + ")'><input type='checkbox' " + classname +
                                " ><span class='slider round'></span></label>";
                        }
                    },
                    {
                        width: "10%",
                        data: 'action',
                        render: function(data, type, row) {
                            let html = "";
                            html += "<a class='delete' href='" + BASE_URL + "/admin/events/" +
                                row.id +
                                "/edit'><i class='fa fa-edit'></i></a>"
                            html +=
                                "<button type='submit' class='delete' style='border:0px;' onclick='deleteEvent(\"" +
                                row.id +
                                "\")'><i class='fa fa-trash' style='color:red'></i></button>";
                            return html;
                        }
                    },
                ],
            });
        });


        function deleteEvent(id) {
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
                    var userURL = BASE_URL + "/admin/events/" + id;

                    $.ajax({
                        url: userURL,
                        type: "DELETE",
                        dataType: "json",
                        url: userURL,
                        success: function(response) {
                            toastr.success(response.message)
                            eventTable.draw();
                        }
                    });
                }
            })
        }

        function toggleEvent(id, status) {
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
                    var userURL = BASE_URL + "/admin/toggle-event/" + id;
                    $.ajax({
                        url: userURL,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            toastr.success(response.message)
                            eventTable.draw();
                        }
                    });
                } else {
                    eventTable.draw()
                }
            })
        }
    </script>
@endsection
