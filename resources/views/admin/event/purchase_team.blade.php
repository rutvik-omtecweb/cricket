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
                                        <li class="breadcrumb-item active">Purchase Team Member List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body table-responsive">
                    <input type="hidden" value="{{ $event->id }}" name="event_id" id="event_id">
                    <table id="purchaseTeamTable" class="table table-borderless table-thead-bordered table-align-middle"
                        style="border: 1px solid #dee2e6;border-radius: 4px;">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Event</th>
                                <th>Amount</th>
                                <th>Date</th>
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
        var purchaseTeamTable
        $(document).ready(function() {
            purchaseTeamTable = $('#purchaseTeamTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                "ajax": {
                    "data": function(data) {
                        data.event_id = $('#event_id').val(); // Set the event_id parameter
                    },
                    "url": "{{ route('admin.purchase.team.list') }}", // Specify the URL to fetch data from
                    "type": "GET", // Specify the HTTP method (GET or POST)
                },

                columns: [{
                        data: 'full name',
                        render: function(data, type, row) {
                            if (row.user) {
                                return row.user.first_name + " " + row.user.last_name;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'email',
                        render: function(data, type, row) {
                            if (row.user) {
                                return row.user.email;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'event',
                        render: function(data, type, row) {
                            if (row.event) {
                                return row.event.title;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'amount',
                    },
                    {
                        data: 'created_at_formate',
                    },
                ],
            });
        });
    </script>
@endsection
