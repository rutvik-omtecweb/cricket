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
                                        <li class="breadcrumb-item ">News List</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>&nbsp;Add</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Inner News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Outer News</a>
                        </li>
                    </ul><!-- Tab panes -->
                    <div class="tab-content mt-5">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="table-responsive">
                                <table id="newsTable" class="table table-borderless table-thead-bordered table-align-middle"
                                    style="border: 1px solid #dee2e6;border-radius: 4px;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <form action="{{ route('admin.update.outer.news') }}" method="post" id="outerNewsForm">
                                @csrf
                                <input type="hidden" id="outer_new_id" name="outer_new_id" value="{{ @$outer_news->id }}">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> News Link <span class="validation">*</span></label>
                                            <input type="text" name="link" class="form-control" id="link"
                                                value="{{ @$outer_news->link }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label" for="limit">Limit <span
                                                    class="validation">*</span></label>
                                            <input type="number" name="limit" class="form-control" id="limit"
                                                value="{{ @$outer_news->limit }}" min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var newsTable
        $(document).ready(function() {
            newsTable = $('#newsTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: "{{ route('admin.get.news') }}",
                },

                columns: [{
                        width: "20%",
                        data: 'image',
                        render: function(data, type, row) {
                            if (row.image) {
                                return "<img src='" + row
                                    .image + "' height='100' width='200'>";
                            } else {
                                return `<img src="{{ URL::asset('storage/admin/default/img1.jpg') }}" height="100" width="200">`;
                            }
                        }
                    },
                    {
                        data: 'news_name',
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
                            return "<label class='switch' onclick='toggleHome(\"" + row.id +
                                "\", " + is_active + ")'><input type='checkbox' " + classname +
                                " ><span class='slider round'></span></label>";
                        }
                    },
                    {
                        width: "10%",
                        data: 'action',
                        render: function(data, type, row) {
                            let html = "";
                            html += "<a class='delete' href='" + BASE_URL + "/admin/news/" +
                                row.id +
                                "/edit'><i class='fa fa-edit'></i></a>"

                            html +=
                                "<button type='submit' class='delete' style='border:0px;' onclick='deleteNews(\"" +
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

            jQuery.validator.addMethod("noSpace", function(value, element) {
                    return value.trim().length > 0;
                },
                "This field is required.")

            $("#outerNewsForm").validate({
                rules: {
                    link: {
                        required: true,
                        noSpace: true,
                        url: true
                    },
                    limit: {
                        required: true,
                    },
                },
            });
        });

        function deleteNews(id) {
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
                    var userURL = BASE_URL + "/admin/news/" + id;

                    $.ajax({
                        url: userURL,
                        type: "DELETE",
                        dataType: "json",
                        url: userURL,
                        success: function(response) {
                            toastr.success(response.message)
                            newsTable.draw();
                        }
                    });
                }
            })
        }

        function toggleHome(id, status) {
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
                    var userURL = BASE_URL + "/admin/toggle-news/" + id;
                    $.ajax({
                        url: userURL,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            toastr.success(response.message)
                            newsTable.draw();
                        }
                    });
                } else {
                    newsTable.draw()
                }
            })
        }
    </script>
@endsection
