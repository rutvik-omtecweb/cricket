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
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill"
                                    href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                    aria-selected="true">Register Documents</a>
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
                                                <label for="site_name">Site Name <span class="validation">*</span></label>
                                                <input type="text" name="site_name" class="form-control" maxlength="70"
                                                    id="site_name" placeholder="Site Name"
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
                                                <label for="phone">Phone Number <span class="validation">*</span></label>
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
                            <div class="tab-pane fade show " id="custom-tabs-four-home" role="tabpanel"
                                aria-labelledby="custom-tabs-four-home-tab">

                                <input type="text" name="id" value="1" hidden="">
                                <div _ngcontent-jyr-c201="" class="maintenance-wrap">
                                    <h3 _ngcontent-jyr-c201="">Document Configration ?</h3>
                                    <div class="col-md-12">
                                        <form action="{{ route('admin.general.setting.update', 1) }}" method="post"
                                            id="maintenance_form" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" value="{{ @$general_setting->id }}">
                                            <div class="card card-secondary">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="health_card_document">Helth Card
                                                                    Document</label><br>
                                                                <input type="checkbox" name="health_card_document"
                                                                    id="health_card_document" value="1" checked
                                                                    data-bootstrap-switch>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="licence_document">Licence Document</label><br>
                                                                <input type="checkbox" name="licence_document"
                                                                    value="1" id="licence_document" checked
                                                                    data-bootstrap-switch>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="other_document">Other Document</label><br>
                                                                <input type="checkbox" name="other_document"
                                                                    value="1" id="other_document" checked
                                                                    data-bootstrap-switch>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                    </div>
                                    </form>
                                </div>
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
        // imgInp.onchange = evt => {
        //     const [file] = imgInp.files
        //     if (file) {
        //         blah.src = URL.createObjectURL(file)
        //     }
        // }
        // imgInp1.onchange = evt => {
        //     const [file] = imgInp1.files
        //     if (file) {
        //         blah1.src = URL.createObjectURL(file)
        //     }
        // }

        // $.validator.addMethod('filesize', function(value, element, param) {
        //     return this.optional(element) || (element.files[0].size <= param * 1000000)
        // }, 'File size must be less than {0} MB');
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()


            $("input[data-bootstrap-switch]").each(function(index) {
                // Assuming index 0 is for health_card_document, index 1 is for licence_document, and index 2 is for other_document
                if (index === 0) {
                    $(this).bootstrapSwitch('state', {{ @$general_setting->health_card_document }});
                } else if (index === 1) {
                    $(this).bootstrapSwitch('state', {{ @$general_setting->licence_document }});
                    // Set the state for the licence_document checkbox here
                    // Example: $(this).bootstrapSwitch('state', {{ @$general_setting->licence_document }});
                } else if (index === 2) {
                    $(this).bootstrapSwitch('state', {{ @$general_setting->other_document }});

                    // Set the state for the other_document checkbox here
                    // Example: $(this).bootstrapSwitch('state', {{ @$general_setting->other_document }});
                }
            });

        });


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
                // copyright_text: {
                //     required: true,
                // },
                address: {
                    required: true,
                },
                // logo: {
                //     required: function() {
                //         var image = $('#image').val();
                //         return image == null || image == "" || image == undefined;
                //     },
                //     extension: "jpg|jpeg|png",
                //     filesize: 2
                // },
                // favicon: {
                //     required: function() {
                //         var image = $('#image1').val();
                //         return image == null || image == "" || image == undefined;
                //     },
                //     extension: "jpg|jpeg|png",
                //     filesize: 2
                // }
            },
        })
    </script>
@endsection
