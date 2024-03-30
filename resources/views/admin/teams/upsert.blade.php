@extends('layouts.admin')

@section('content')
    <div class="container-fluid ">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="page-header-title">
                            @if (@$teams)
                                Update
                            @else
                                Create
                            @endif Teams
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('admin.teams.index') }}">Team List</a>
                            </li>
                            @if (@$teams)
                                <li class="breadcrumb-item active">Update Team </li>
                            @else
                                <li class="breadcrumb-item active">Create Team </li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <form
            action="@if (@$teams->id) {{ route('admin.teams.update', @$teams->id) }} @else {{ route('admin.teams.store') }} @endif "
            method="post" enctype="multipart/form-data" id="team_form" name="team_form">
            @csrf
            @if (@$teams->id)
                @method('PUT')
            @endif

            <div class="card col-md-8">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="team_name">Name <span class="validation">*</span></label>
                                <input type="text" name="team_name" class="form-control" id="team_name" maxlength="100"
                                    placeholder="Name" value="{{ @$teams->team_name }}">
                                @error('team_name')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputFile">Image <span class="validation">*</span></label>
                                <div class="">
                                    <input type="file" name="image" class="form-control" id="imgInp"
                                        accept="image/*" data-rule-required="true"
                                        data-msg-accept="Please upload file in these format only (jpg, jpeg, png)." />
                                    <input type="hidden" name="oldimage" class="form-control" id="image"
                                        placeholder="showphotos" value="{{ @$teams->image }}">
                                </div>
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
                                @if (@$teams->image) src="{{ @$teams->image }}"
                                    @else
                                        src="{{ URL::asset('storage/admin/default/img1.jpg') }}" @endif
                                onerror="this.src='{{ URL::asset('storage/default/img1.jpg') }}'" alt="Your Slider Image"
                                width="200px" height="150px" />
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputFile">Members </label>
                                <select name="member_id[]" id="member_id" class="form-control select2" multiple="multiple"
                                    data-placeholder="Select Members">

                                    @foreach ($members as $key => $member)
                                        @php
                                            $isSelected = optional($selected_member)
                                                ->pluck('member_id')
                                                ->contains($member->id);
                                        @endphp
                                        <option value="{{ $member->id }}" {{ @$isSelected ? 'selected' : '' }}>
                                            {{ $member->user->first_name }} {{ $member->user->last_name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('image')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="fom-group">
                                <label for="exampleInputFile">Description </label>
                                <textarea name="description" id="description" placeholder="Description" cols="20" rows="10"
                                    class="form-control">{{ @$teams->description }}</textarea>

                                <span id="description_error" class="error"></span>

                                @error('description')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="content_error" id="content_error"></span>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary float-right">
                            Submit
                        </button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-warning float-right mr-2">Back</a>
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
            $('#description').summernote({
                height: 500 // Set the height to 300 pixels
            });
        });


        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');

        // jQuery.validator.addMethod("requiredSummernote", function() {
        //     return !($("#description").summernote('isEmpty'));
        // }, 'This field is required');

        $("#team_form").validate({
            rules: {
                team_name: {
                    required: true,
                },
                // description: {
                //     requiredSummernote: true
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
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "description") {
                    error.appendTo('#description_error');
                } else {
                    error.insertAfter(element);
                }
            }
        })
    </script>
@endsection
