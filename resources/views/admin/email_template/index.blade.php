@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <section class="content-header">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h3 class="card-title"></h3>
                                <div class="col-md-6">
                                    <h5>Email Templates</h5>
                                </div>
                                <div class="col-md-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item ">Email Templates</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body">
                    <div class="row">
                        @foreach ($email_templates as $key => $email_template)
                        <button type="button" class="btn btn-primary ml-2 mb-3 email-title" data-id="{{ $email_template->id }}">{{ $email_template['title'] }}</button>
                        @endforeach
                    </div>
                    <form action="" method="post" id="emailtemplate">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" id="email_tempalte_id" value="{{ @$email_templates->first()->id }}">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Subject <span class="validation">*</span></label>
                                            <input type="text" id="subject" class="form-control" name="subject" placeholder="Subject" maxlength="100" value="{{ @$email_templates->first()->subject }}">
                                            @error('subject')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="content">Body <span class="validation">*</span></label>
                                            <textarea id="content" class="form-control summernote" name="content" placeholder="Content">{{ @$email_templates->first()->content }}</textarea>
                                            <span id="content_error"></span>
                                            @error('content')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">
                                    Save
                                </button>
                            </div>
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
    var t = $('#content').summernote({
        height: 500,
        focus: true
    });

    $(function() {
        $('#content').summernote()
    })

    $("#emailtemplate").validate({
        ignore: [],
        normalizer: function(value) {
            return $.trim(value);
        },
        rules: {
            subject: {
                required: true,
            },
            content: {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            if (element.is('textarea')) {
                error.appendTo('#content_error');
            } else {
                error.insertAfter(element);
            }
        },
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.email-title').click(function() {
        var emailTemplateId = $(this).data('id');
        var link = BASE_URL + "/admin/get-email-template/" + emailTemplateId;

        $.ajax({
            url: link,
            method: 'GET',
            success: function(response) {
                $('#subject').val(response.data.subject)
                $('#email_tempalte_id').val(response.data.id)
                $(".summernote").summernote("code", response.data.content);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    $('#emailtemplate').submit(function(e) {
        if ($('#emailtemplate').valid()) {
            var id = $('#email_tempalte_id').val();
            var action_url = "{{ route('admin.email-template.update', ['_id_']) }}";
            var url = action_url.replace('_id_', id);
            $('#emailtemplate').attr('action', url);
        }
    });
</script>
@endsection