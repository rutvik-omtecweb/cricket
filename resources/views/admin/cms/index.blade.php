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
                                        <li class="breadcrumb-item active">CMS Pages List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                    <!-- Right side content -->
                                    <a href="{{ route('admin.cms.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>&nbsp;Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body">
                    <table id="cmsTable" class="table table-borderless table-thead-bordered table-align-middle"
                        style="border: 1px solid #dee2e6;border-radius: 4px;">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Url</th>
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
        var cmsTable
        $(document).ready(function() {
            cmsTable = $('#cmsTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: "{{ route('admin.get.cms') }}",
                },

                columns: [{
                        data: 'cms_page_name',
                    },
                    {
                        data: 'url',
                    },
                    {
                        data: 'is_active',
                        render: function(data, type, row) {
                            var id = row.id;
                            var is_active = row.is_active;
                            var classname = is_active === 1 ? 'checked' : '';
                            var title = is_active === '1' ? 'Active' : 'In-Active';
                            return "<label class='switch' onclick='toggleCMS(\"" + row.id +
                                "\", " + is_active + ")'><input type='checkbox' " + classname +
                                " ><span class='slider round'></span></label>";
                        }
                    },
                    {
                        width: "20%",
                        data: 'action',
                        render: function(data, type, row) {
                            let html = "";
                            html += "<a class='delete' href='" + BASE_URL + "/admin/cms/" +
                                row.id +
                                "/edit'><i class='fa fa-edit'></i></a>"
                            html +=
                                "<button type='submit' class='delete' style='border:0px;' onclick='deleteCMS(\"" +
                                row.id +
                                "\")'><i class='fa fa-trash' style='color:red'></i></button>";
                            return html;
                        }
                    },
                ],
            });
        });


        function deleteCMS(id) {
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
                    var userURL = BASE_URL + "/admin/cms/" + id;

                    $.ajax({
                        url: userURL,
                        type: "DELETE",
                        dataType: "json",
                        url: userURL,
                        success: function(response) {
                            toastr.success(response.message)
                            cmsTable.draw();
                        }
                    });
                }
            })
        }

        function toggleCMS(id, status) {
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
                    var userURL = BASE_URL + "/admin/toggle-cms/" + id;
                    $.ajax({
                        url: userURL,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            toastr.success(response.message)
                            cmsTable.draw();
                        }
                    });
                } else {
                    cmsTable.draw()
                }
            })
        }
    </script>
@endsection
