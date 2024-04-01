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
                                        <li class="breadcrumb-item active">Player List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                    <!-- Right side content -->
                                    {{-- <a href="#" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>&nbsp;Add
                                    </a> --}}
                                    <a class="btn btn-primary" href="{{ route('player.export') }}">Export Player
                                        Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body table-responsive">
                    <table id="bannerTable" class="table table-borderless table-thead-bordered table-align-middle"
                        style="border: 1px solid #dee2e6;border-radius: 4px;">
                        <thead class="thead-light">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Payment Type</th>
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
        var bannerTable
        $(document).ready(function() {
            bannerTable = $('#bannerTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: "{{ route('admin.get.players') }}",
                },

                columns: [{
                        width: "20%",
                        data: 'image',
                        render: function(data, type, row) {
                            if (row.user.image) {
                                return "<img src='" + row
                                    .user.image + "' height='150' width='200'>";
                            } else {
                                return `<img src="{{ URL::asset('storage/admin/default/img1.jpg') }}" height="150" width="200">`;
                            }

                        }
                    },
                    {
                        data: 'name',
                        render: function(data, type, row) {
                            return row.user ? (row.user.first_name + ' ' + row.user.last_name) :
                                '-';
                        }

                    },
                    {
                        data: 'email',
                        render: function(data, type, row) {
                            return row.user ? (row.user.email) :
                                '-';
                        }
                    },
                    {
                        data: 'phone',
                        render: function(data, type, row) {
                            return row.user ? (row.user.phone) :
                                '-';
                        }
                    },
                    {
                        data: 'amount',
                        render: function(data, type, row) {
                            return row.amount ? ('$' + row.amount) : '-';
                        }
                    },
                    {
                        data: 'payment_type',
                        render: function(data, type, row) {
                            // Check if payment_type exists and convert it to uppercase
                            return row.payment_type;
                            // return row.payment_type ? row.payment_type.toUpperCase() : '-';
                        }
                    },
                ],
            });
        });
    </script>
@endsection
