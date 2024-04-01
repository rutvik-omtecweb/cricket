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
                                        <li class="breadcrumb-item active">Member List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" onclick="showImport()" class="btn btn-primary"><i
                                            class="fa fa-upload"></i>&nbsp;Import</button>
                                    <a class="btn btn-primary" href="{{ route('member.export') }}">Export Member
                                        Data</a>
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
                                <th>Image</th>
                                <th>User Name</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Paid Amount</th>
                                <th>Expired Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div id="myModal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" style="width: 400px;">
                    <div class="modal-content">
                        <form method="POST" name="import_form" id="import_form" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal_title">Import Members</h5>
                                <input type="hidden" name="id" id="group_id" />
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="import_file">Choose File <span class="validation">*</span></label>
                                        <input type="file" name="import_file" class="form-control" id="import_file"
                                            data-msg-accept="The file must be of type: csv, xls, xlsx."
                                            placeholder="Choose File"
                                            accept=".csv, text/csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <span id="import_file_error" class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <a href="{{ asset('storage/import/member.xlsx') }}" download
                                            class="btn btn-primary"><i class="fa fa-download"></i>&nbsp;Sample File</a>
                                    </div>
                                </div>
                                <div id="loader" class="overlay dark" style="display: none;">
                                    <i class="fas fa-2x fa-sync-alt"></i>
                                </div>
                                <div id="errors_block">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="importCategory()" class="btn btn-primary">Import
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
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
                    url: "{{ route('admin.get.member') }}",
                },

                columns: [{
                        width: "20%",
                        data: 'image',
                        render: function(data, type, row) {
                            if (row.image) {
                                return "<img src='" + row
                                    .image + "' height='150' width='200'>";
                            } else {
                                return "<img src='{{ URL::asset('storage/admin/default/img1.jpg') }}' height='150' width='200'>";
                            }
                        }
                    },
                    {
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
                        data: 'is_active',
                        render: function(data, type, row) {
                            var id = row.id;
                            var is_active = row.is_active;
                            var classname = is_active === 1 ? 'checked' : '';
                            var title = is_active === '1' ? 'Active' : 'In-Active';
                            return "<label class='switch' onclick='toggleZone(\"" + row.id +
                                "\", " + is_active + ")'><input type='checkbox' " + classname +
                                " ><span class='slider round'></span></label>";
                        }
                    },
                    {
                        width: "10%",
                        data: 'action',
                        render: function(data, type, row) {
                            let html = "";
                            // html += "<a class='delete' href='" + BASE_URL + "/admin/members/" +
                            //     row.id +
                            //     "/edit'><i class='fa fa-edit'></i></a>"
                            html +=
                                "<button type='submit' class='delete' style='border:0px;' onclick='deleteMember(\"" +
                                row.id +
                                "\")'><i class='fa fa-trash' style='color:red'></i></button>";
                            html += "<a class='view' href='" + BASE_URL +
                                "/admin/members/" +
                                row.id + "'><i class='fa fa-eye'></i></a>";
                            return html;
                        }
                    },
                ],
            });
        });


        function deleteMember(id) {
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
                    var userURL = BASE_URL + "/admin/members/" + id;

                    $.ajax({
                        url: userURL,
                        type: "DELETE",
                        dataType: "json",
                        url: userURL,
                        success: function(response) {
                            // toastr.success(response.message)
                            // memberTable.draw();
                            if (response.success == true) {
                                toastr.success(response.message)
                                memberTable.draw();
                            } else {
                                toastr.error(response.message)
                            }
                        }
                    });
                }
            })
        }

        function toggleZone(id, status) {
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
                    var userURL = BASE_URL + "/admin/toggle-member/" + id;
                    $.ajax({
                        url: userURL,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            toastr.success(response.message)
                            memberTable.draw();
                        }
                    });
                } else {
                    memberTable.draw()
                }
            })
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
