@extends('layouts.admin')
@section('style')
    <style>
        /* DataTable styling */
        #member_list_wrapper {
            margin-bottom: 20px;
            /* Example: Add margin below the DataTable */
        }

        /* Buttons extension styling */
        .dt-buttons {
            margin-bottom: 20px;
            /* Example: Add margin below the buttons */
        }

        /* Individual button styling */
        .dt-button {
            margin-right: 5px;
            /* Example: Add margin between buttons */
            color: #fff;
            /* Example: Change text color */
            background-color: #007bff;
            /* Example: Change background color */
            border-color: #007bff;
            /* Example: Change border color */
            border-radius: 5px;
            /* Example: Add border radius */
            padding: 8px 12px;
            /* Example: Adjust padding */
            font-size: 14px;
            /* Example: Adjust font size */
        }

        /* Hover effect for buttons */
        .dt-button:hover {
            background-color: #0056b3;
            /* Example: Change background color on hover */
            border-color: #0056b3;
            /* Example: Change border color on hover */
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
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
                                    <li class="breadcrumb-item ">Reports</li>
                                </ol>
                            </div>
                            <div class="col-md-6 text-right">

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Payment Report</a>
                    </li>
                </ul>
                <div class="tab-content mt-5">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <div class="row mb-3">
                            {{-- <div class="col-2">
                                <div class="form-group">
                                    <label>Type </label>
                                    <select class="form-control select2" style="width: 100%;" name="type_id" id="type_id">
                                        <option value="ALL">Select Type</option>
                                        <option value="member_registation">Member Registration</option>
                                        <option value="player_fees">Player Fess</option>
                                        <option value="team_registation">Team Registration</option>
                                        <option value="event_registation">Event Registration</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Date Range Picker</label>
                                    <input type="text" name="member_daterange" class="form-control" readonly
                                        id="member_daterange">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="member_list" class="table table-borderless table-thead-bordered table-align-middle"
                                style="border: 1px solid #dee2e6;border-radius: 4px;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Member Amount</th>
                                        <th>Player Amount</th>
                                        <th>Team Amount</th>
                                        <th>Event Purchase Team Amount</th>
                                        <th>Event Participant Amount</th>
                                        <th>Start Date</th>
                                        <th>Expired Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var memberList
        $(document).ready(function() {

            var today = moment();
            var startOfMonth = today.clone().startOf('month');
            var endOfMonth = today.clone().endOf('month');

            function initializeDateRangePicker(selector) {
                $(selector).daterangepicker({
                    "startDate": startOfMonth,
                    "endDate": endOfMonth,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    "cancelButtonClasses": "btn-danger",
                });
            }

            $(function() {
                initializeDateRangePicker('input[name="member_daterange"]');
            });

            $('input[name="member_daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                memberList.draw();
            });

            memberList = $('#member_list').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: ''
                }, ],
                ajax: {
                    data: function(data) {
                        data.date_range = $("#member_daterange").val();
                    },
                    url: "{{ route('admin.member.payment.report') }}",
                },
                columns: [{
                        data: 'name',
                        render: function(data, type, row) {
                            return row.first_name + ' ' + row.last_name;
                        }
                    },
                    {
                        data: 'email',
                        render: function(data, type, row) {
                            return row.email;
                        }
                    },
                    {
                        data: 'phone',
                        render: function(data, type, row) {
                            return row.phone;
                        }
                    },
                    {
                        data: 'member_amount',
                        render: function(data, type, row) {
                            return row.payment_collect ? '$' + row.payment_collect.amount : '-';
                        }
                    },
                    {
                        data: 'player_amount',
                        render: function(data, type, row) {
                            return row.player ? '$' + row.player.amount : '-';
                        }
                    },
                    {
                        data: 'team_amount',
                        render: function(data, type, row) {
                            return row.team_payment ? '$' + row.team_payment.amount : '-';
                        }
                    },
                    {
                        data: 'event_purchase_team',
                        render: function(data, type, row) {
                            if (row.event_payment && row.event_payment.length > 0) {
                                return '$' + row.event_payment[0].amount;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'event_participant',
                        render: function(data, type, row) {
                            return row.total_participant_amount ? '$' + row
                                .total_participant_amount :
                                '-';
                        }
                    },
                    {
                        data: 'date',
                        render: function(data, type, row) {
                            return row.created_at_formate;
                        }
                    },
                    {
                        data: 'date',
                        render: function(data, type, row) {
                            return row.payment_collect ? row.payment_collect.expired_date :
                                '-';
                        }
                    },

                ]
            });

            $('#member_daterange').change(function(e) {
                memberList.draw();
            });

        });
    </script>
@endsection
