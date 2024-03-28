@extends('layouts.admin')
@section('content')
    <div class="container-fluid ">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="page-header-title">
                            General Setting
                        </h1>
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>
            </div>
        </section>
        <div class="card-body">
            <div class="col-8">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-messages-tab" data-toggle="pill"
                                    href="#custom-tabs-four-messages" role="tab"
                                    aria-controls="custom-tabs-four-messages" aria-selected="false">General</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-four-messages" role="tabpanel"
                                aria-labelledby="custom-tabs-four-messages-tab">
                                <form action="{{ route('admin.general.setting.update', 1) }}" method="post"
                                    enctype="multipart/form-data" id="generalsetting" name="generalsetting">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        {{-- <div class="col-md-4"> --}}
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value={{ @$general_setting->id }}>
                                                    <label for="site_name">Site Name <span
                                                            class="validation">*</span></label>
                                                    <input type="text" name="site_name" class="form-control"
                                                        maxlength="70" id="site_name" placeholder="Site Name"
                                                        value="{{ old('site_name', @$general_setting->site_name) }}">
                                                    @error('Site Name')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone Number <span
                                                            class="validation">*</span></label>
                                                    <input type="text" id="phone" class="form-control" name="phone"
                                                        placeholder="Phone Number"
                                                        value="{{ old('phone', @$general_setting->phone) }}" maxlength="20">
                                                    @error('phone')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email">Email <span class="validation">*</span></label>
                                                    <input type="email" id="email" class="form-control" name="email"
                                                        placeholder="Email"
                                                        value="{{ old('email', @$general_setting->email) }}">
                                                    @error('email')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="address">Address <span class="validation">*</span></label>
                                                    <textarea name="address" class="form-control" id="address" cols="3" rows="3" placeholder="Enter address">{{ @$general_setting->address }}</textarea>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                    

                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
        imgInp1.onchange = evt => {
            const [file] = imgInp1.files
            if (file) {
                blah1.src = URL.createObjectURL(file)
            }
        }

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');


        $("#generalsetting").validate({
            rules: {
                site_name: {
                    required: true,
                },
                phone: {
                    required: true,
                },
                email: {
                    required: true,
                },
                copyright_text: {
                    required: true,
                },
                address: {
                    required: true,
                },
                logo: {
                    required: function() {
                        var image = $('#image').val();
                        return image == null || image == "" || image == undefined;
                    },
                    extension: "jpg|jpeg|png",
                    filesize: 2
                },
                favicon: {
                    required: function() {
                        var image = $('#image1').val();
                        return image == null || image == "" || image == undefined;
                    },
                    extension: "jpg|jpeg|png",
                    filesize: 2
                }
            },
        })
    </script>
@endsection
