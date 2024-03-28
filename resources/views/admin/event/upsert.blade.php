@extends('layouts.admin')

@section('content')
    <div class="container-fluid ">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="page-header-title">
                            @if (@$event)
                                Update
                            @else
                                Create
                            @endif Event
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('admin.events.index') }}">Event List</a>
                            </li>
                            @if (@$event)
                                <li class="breadcrumb-item active">Update Event</li>
                            @else
                                <li class="breadcrumb-item active">Create Event</li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <form
            action="@if (@$event->id) {{ route('admin.events.update', ['event' => @$event->id]) }} @else {{ route('admin.events.store') }} @endif "
            method="post" enctype="multipart/form-data" id="eventForm" name="eventForm">
            @csrf
            @if (@$event->id)
                @method('PUT')
            @endif

            <div class="card col-md-8">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title">Title <span class="validation">*</span></label>
                                <input type="text" name="title" class="form-control" id="title" maxlength="35"
                                    placeholder="Title" value="{{ @$event->title }}" maxlength="50">
                                @error('title')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start_date">Start Date <span class="validation">*</span></label>
                                <input type="date" name="start_date" class="form-control" id="start_date"
                                    value="{{ @$event->start_date }}">
                                @error('start_date')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="end_date">End Date <span class="validation">*</span></label>
                                <input type="date" name="end_date" class="form-control" id="end_date"
                                    value="{{ @$event->end_date }}">
                                @error('end_date')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="form-group">
                                <label for="number_of_team">Number Of Team <span class="validation">*</span></label>
                                <input type="number" name="number_of_team" class="form-control" id="number_of_team"
                                    value="{{ @$event->number_of_team }}" min="0" placeholder="Number Of Team">
                                @error('number_of_team')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputFile">Image <span class="validation">*</span></label>
                                <input type="file" name="image" class="form-control" id="imgInp" accept="image/*"
                                    data-rule-required="true"
                                    data-msg-accept="Please upload file in these format only (jpg, jpeg, png)." />
                                <input type="hidden" name="oldimage" class="form-control" id="image"
                                    placeholder="showphotos" value="{{ @$event->image }}">
                                @error('image')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <img id="blah"
                                style="border: 1px solid #adb5bd !important; border-radius: 13px !important;"
                                @if (@$event->image) src="{{ @$event->image }}"
                                    @else
                                        src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                onerror="this.src='{{ URL::asset('storage/admin/default/img1.jpg') }}'"
                                alt="Your Slider Image" width="200px" height="150px" />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputFile"><i class="fa fa-map-marker"></i>&nbsp;&nbsp; Location <span class="validation">*</span></label>
                                <textarea name="location" id="location" cols="30" rows="2" class="form-control">{{ @$event->location }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Description <span class="validation">*</span></label>
                                <textarea name="description" id="content" placeholder="Description" cols="20" rows="20" maxlength="250"
                                    class="form-control">{{ @$event->description }}</textarea>
                                    <span id="content_error" class="error"></span>

                                @error('description')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                {{-- <span class="content_error" id="content_error"></span> --}}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group event-checkbox">
                                <div class="form-check">
                                    <input class="form-check-input" name="email_notifications" type="checkbox"
                                        id="email_notifications" value="1"
                                        @if (@$event->email_notifications) checked @endif>
                                    <label class="form-check-label font-weight-bold" for="email_notifications">
                                        Send email
                                        notifications
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary float-right">
                            Submit
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-warning float-right mr-2">Back</a>
                    </div>
                </div>
            </div>
        </form>
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

        $(function() {
            $('#content').summernote({
                height: 500 // Set the height to 300 pixels
            });
        });



        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');

        jQuery.validator.addMethod("requiredSummernote", function() {
                return !($("#content").summernote('isEmpty'));
            }, 'This field is required.');

        jQuery.validator.addMethod("greaterThan",
            function(value, element, params) {
                if (!/Invalid|NaN/.test(new Date(value))) {
                    return new Date(value) >= new Date($(params).val());
                }

                return isNaN(value) && isNaN($(params).val()) ||
                    (Number(value) >= Number($(params).val()));
            }, 'Must be greater than or equal to {0}.');


        $("#eventForm").validate({
            ignore: [],
            rules: {
                title: {
                    required: true,
                },
                description: {
                    requiredSummernote: true
                },
                start_date: {
                    required: true,
                },
                end_date: {
                    required: true,
                    greaterThan: "#start_date"
                },
                // number_of_team: {
                //     required: true,
                // },
                location: {
                    required: true,
                },
                // email_notifications: {
                //     required: true,
                // },
                image: {
                    required: function() {
                        var image = $('#image').val();
                        return image == null || image == "" || image == undefined;
                    },
                    extension: "jpg|jpeg|png",
                    filesize: 2
                },
            },
            messages: {
                image: {
                    extension: "Please image upload in jpg, jpeg and png",
                },
                end_date: {
                    greaterThan: "Must be greater than start date",
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('.select2-container'));
                }
                else if (element.attr("name") == "description") {
                        error.appendTo('#content_error');
                }
                 else if (element.attr("type") == "checkbox") {
                    error.insertAfter(element.closest('.event-checkbox'));
                } else {
                    error.insertAfter(element);
                }
            }
        })
    </script>
@endsection
