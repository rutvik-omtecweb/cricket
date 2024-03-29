@extends('layouts.admin')
@section('style')
    <style>
        .verification-image {
            border: 2px solid #838383;
            border-radius: 7px;
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
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active">New Join Member List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body table-responsive">
                    <table id="memberTable" class="table table-borderless table-thead-bordered table-align-middle"
                        style="border: 1px solid #dee2e6;border-radius: 4px;">
                        <thead class="thead-light">
                            <tr>
                                @if (@$setting->health_card_document == 1)
                                    <th>Health Card Document</th>
                                @endif
                                @if (@$setting->licence_document == 1)
                                    <th>Licence Document</th>
                                @endif
                                @if (@$setting->other_document == 1)
                                    <th>Other Document</th>
                                @endif
                                <th>User Name</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Paid Amount</th>
                                <th>Expired Date</th>
                                <th>Reject</th>
                                <th>Approve</th>
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
        var memberTable
        $(document).ready(function() {
            memberTable = $('#memberTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: "{{ route('admin.get.new.member') }}",
                },

                columns: [
                    @if (@$setting->health_card_document == 1)
                        {
                            data: 'health_card_document',
                            render: function(data, type, row) {
                                if (row.verification_id_1) {
                                    return "<img src='" + "{{ URL::asset('storage/member') }}" +
                                        "/" +
                                        row.verification_id_1 +
                                        "' height='200' width='200' class='verification-image'>";
                                } else {
                                    return "<img src='{{ URL::asset('storage/admin/default/img1.jpg') }}' height='100' width='100'>";
                                }
                            }
                        },
                    @endif
                    @if (@$setting->licence_document == 1)

                        {
                            width: "10%",
                            data: 'licence_document',
                            render: function(data, type, row) {
                                if (row.verification_id_2) {
                                    return "<img src='" + "{{ URL::asset('storage/member') }}" +
                                        "/" +
                                        row.verification_id_2 +
                                        "' height='200' width='200' class='verification-image'>";
                                } else {
                                    return "<img src='{{ URL::asset('storage/admin/default/img1.jpg') }}' height='100' width='100'>";
                                }
                            }
                        },
                    @endif
                    @if (@$setting->other_document == 1)
                        {
                            width: "10%",
                            data: 'other_document',
                            render: function(data, type, row) {
                                if (row.verification_id_3) {
                                    return "<img src='" + "{{ URL::asset('storage/member') }}" +
                                        "/" +
                                        row.verification_id_3 +
                                        "' height='200' width='200' class='verification-image'>";
                                } else {
                                    return "<img src='{{ URL::asset('storage/admin/default/img1.jpg') }}' height='100' width='100'>";
                                }
                            }
                        },
                    @endif {
                        data: 'user_name',
                    },
                    {
                        data: 'name',
                        render: function(data, type, row) {
                            return row.first_name + ' ' + row.last_name;
                        }
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'phone',
                    },
                    {
                        data: 'amount',
                        render: function(data, type, row) {
                            if (row.payment_collect) {
                                return row.payment_collect.amount;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'expired_date',
                        render: function(data, type, row) {
                            if (row.payment_collect) {
                                return row.payment_collect.expired_date;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'reject',
                        render: function(data, type, row) {
                            var id = row.id;
                            var is_reject = row.is_reject;
                            var classname = is_reject === 1 ? 'checked' : '';
                            var title = is_reject === '1' ? 'Active' : 'In-Active';
                            return "<label class='switch' onclick='toggleRejectMember(\"" +
                                row
                                .id +
                                "\", " + is_reject + ")'><input type='checkbox' " +
                                classname +
                                " ><span class='slider round'></span></label>";
                        }
                    },
                    {
                        data: 'approve',
                        render: function(data, type, row) {
                            var id = row.id;
                            var is_approve = row.is_approve;
                            var classname = is_approve === 1 ? 'checked' : '';
                            var title = is_approve === '1' ? 'Active' : 'In-Active';
                            return "<label class='switch' onclick='toggleNewMember(\"" + row.id +
                                "\", " + is_approve + ")'><input type='checkbox' " + classname +
                                " ><span class='slider round'></span></label>";
                        }
                    },
                ],
            });
        });


        function toggleNewMember(id, status) {
            var message = status ? 'reject' : 'approve';
            var action = status ? 'cancel approve' : 'approve';
            Swal.fire({
                title: 'Are you sure you want to ' + message + ' this member?',
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
                    var userURL = BASE_URL + "/admin/toggle-new-member/" + id;
                    $.ajax({
                        url: userURL,
                        type: "POST",
                        data: {
                            message: message
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message)
                                memberTable.draw();
                            } else {
                                toastr.error(response.message)
                                memberTable.draw()
                            }
                        }
                    });
                } else {
                    memberTable.draw()
                }
            })
        }

        function toggleRejectMember(id, status) {
            var email = status ? '0' : '1';
            var action = status ? 'cancel rejection' : 'rejecting';
            var inputHtml = ''; // Initialize empty input HTML

            // Check if email is not '0', then include the input field
            if (email !== '0') {
                inputHtml =
                    '<textarea id="reject_reason" class="swal2-textarea" placeholder="Enter rejection reason here..." required></textarea>'
            }

            Swal.fire({
                title: 'Are you sure you want to ' + action + ' this member?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm',
                html: inputHtml // Include the input HTML conditionally
            }).then((result) => {
                if (result.isConfirmed) {
                    // Check if input textbox is displayed
                    if ($('#reject_reason').is(':visible')) {
                        var rejectReason = $('#reject_reason').val();
                        if (!rejectReason) {
                            toastr.error("Please enter a rejection reason.");
                            // Do not close the Swal dialog here
                            return; // Stop execution if rejection reason is required but empty
                        }
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var userURL = BASE_URL + "/admin/toggle-reject-member/" + id;
                    $.ajax({
                        url: userURL,
                        type: "POST",
                        data: {
                            reject_reason: rejectReason,
                            email: email
                        },
                        dataType: "json",
                        success: function(response) {
                            toastr.success(response.message);
                            memberTable.draw();
                        }
                    });
                } else {
                    memberTable.draw();
                }
            });
        }


        $('#import_form').validate({
            rules: {
                import_file: {
                    required: true,
                    extension: "csv|xls|xlsx"
                }
            },
            messages: {
                import_file: {
                    extension: "The file must be of type: csv, xls, xlsx."
                }
            }
        })

        function showImport() {
            $('#myModal').modal('show');
        }

        function importCategory() {
            if ($("#import_form").valid()) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var link = BASE_URL + "/admin/members/import";
                var formData = new FormData($('#import_form')[0]);
                var form = this;
                $('#loader').show();
                $.ajax({
                    type: 'POST',
                    url: link,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#loader').hide();
                        $('#myModal').modal('hide');
                        memberTable.draw()
                        if (response.success) {
                            toastr.success(response.message)
                        }
                    },
                    error: function(e) {
                        toastr.error(e?.responseJSON?.message)
                        if (e.responseJSON?.errors?.length > 0) {
                            let html = '';
                            html += '<ul class="alert alert-danger" style="padding-left: 10px">';
                            e.responseJSON?.errors?.forEach((error, i) => {
                                let sub = '';
                                sub += '<ul>';
                                error['errors'].forEach(element => {
                                    sub += '<li>' + element + '</li>'
                                });
                                sub += '</ul>';
                                html += '<li><span>Line ' + error['line'] + '</span>'
                                html += sub + '</li>'
                            });
                            html += '</ul>';
                            $('#errors_block').html(html);
                        }
                        $('#loader').hide()
                    }
                })
            }
        }

        $('#myModal').on('hidden.bs.modal', function(e) {
            $(this)
                .find("input")
                .val('')
                .end();
            $("#import_form").validate().resetForm();
            $('#errors_block').empty()
        })
    </script>
@endsection
