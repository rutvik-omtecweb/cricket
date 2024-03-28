@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="cards card-defaults">
            <div class="card col-md-6">
                <section class="content-header">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Live Score</h5>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body">
                    <form
                        action="@if (@$live_score->id) {{ route('admin.live-score.update', @$live_score->id) }} @else {{ route('admin.live-score.store') }} @endif"
                        method="post" id="scoreForm">
                        @csrf
                        @if (@$live_score->id)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="current_link">Current Score Link <span class="validation">*</span></label>
                                    <input type="text" name="current_link" id="current_link" class="form-control"
                                        value="{{ @$live_score->current_link }}" placeholder="Current Score Link">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="past_link">Past Score Link <span class="validation">*</span></label>
                                    <input type="text" name="past_link" id="past_link" class="form-control"
                                        value="{{ @$live_score->past_link }}" placeholder="Past Score Link">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary float-right">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $("#scoreForm").validate({
            ignore: [],
            rules: {
                current_link: {
                    required: true,
                    url: true
                },
                past_link: {
                    required: true,
                    url: true
                },
            },
        })
    </script>
@endsection
