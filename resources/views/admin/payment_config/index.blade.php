@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="cards card-defaults">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <section class="content-header">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Member Register Payment Configuration</h5>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="card-body">
                            <form
                                action="@if (@$payment->id) {{ route('admin.payment.update', @$payment->id) }} @else {{ route('admin.payment.store') }} @endif"
                                method="post" id="paymentForm">
                                @csrf
                                @if (@$payment->id)
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" name="title" value="{{ @$payment->title }}">
                                            <label for="title">Title <span class="validation">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                value="{{ @$payment->title }}" placeholder="Title" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="amount">Amount <span class="validation">*</span></label>
                                            {{-- <input type="number" name="amount" id="amount" class="form-control"
                                                value="{{ @$payment->amount }}" min="0"> --}}
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                </div>
                                                <input type="number" name="amount" id="payment-amount"
                                                    class="form-control" placeholder="Amount"
                                                    value="{{ @$payment->amount }}" aria-label="Amount"
                                                    aria-describedby="basic-addon1" min="0">
                                            </div>
                                            <span id="payment-amount-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="days">Days <span class="validation">*</span></label>
                                            <input type="number" name="days" id="days" class="form-control"
                                                value="{{ @$payment->days }}" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="">
                                        <button type="submit" class="btn btn-primary float-right">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <section class="content-header">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Team Register Payment Configuration</h5>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="card-body">
                            <form
                                action="@if (@$team_payment->id) {{ route('admin.payment.update', @$team_payment->id) }} @else {{ route('admin.payment.store') }} @endif"
                                method="post" id="TeamForm">
                                @csrf
                                @if (@$payment->id)
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" name="title" value="{{ @$team_payment->title }}">
                                            <label for="title">Title <span class="validation">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                value="{{ @$team_payment->title }}" placeholder="Title" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="amount">Amount <span class="validation">*</span></label>
                                            {{-- <input type="number" name="amount" id="amount" class="form-control"
                                                value="{{ @$payment->amount }}" min="0"> --}}
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                </div>
                                                <input type="number" name="amount" id="team_amount" class="form-control"
                                                    placeholder="Amount" value="{{ @$team_payment->amount }}"
                                                    aria-label="Amount" aria-describedby="basic-addon1" min="0">
                                            </div>
                                            <span id="team-amount-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="">
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
            <div class="card col-md-6">
                <section class="content-header">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Player Payment Configuration</h5>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card-body">
                    <form
                        action="@if (@$player_payment->id) {{ route('admin.payment.update', @$player_payment->id) }} @else {{ route('admin.payment.store') }} @endif"
                        method="post" id="playerForm">
                        @csrf
                        @if (@$player_payment->id)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" name="title" value="{{ @$payment->title }}">
                                    <label for="title">Title <span class="validation">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ @$player_payment->title }}" placeholder="Title" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="validation">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                        </div>
                                        <input type="number" name="amount" id="amount" class="form-control"
                                            placeholder="Amount" value="{{ @$player_payment->amount }}"
                                            aria-label="Amount" aria-describedby="basic-addon1" min="0">
                                    </div>
                                    <span id="amount-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="">
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
        $("#paymentForm").validate({
            ignore: [],
            rules: {
                title: {
                    required: true,
                },
                amount: {
                    required: true,
                },
                days: {
                    required: true,
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.attr("id") == "payment-amount") {
                    error.appendTo('#payment-amount-error');
                } else {
                    error.insertAfter(element);
                }
            }
        })
        $("#playerForm").validate({
            ignore: [],
            rules: {
                title: {
                    required: true,
                },
                amount: {
                    required: true,
                },
                days: {
                    required: true,
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.attr("id") == "amount") {
                    error.appendTo('#amount-error');
                } else {
                    error.insertAfter(element);
                }
            }
        })

        $("#TeamForm").validate({
            ignore: [],
            rules: {
                title: {
                    required: true,
                },
                amount: {
                    required: true,
                },
                days: {
                    required: true,
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.attr("id") == "team_amount") {
                    error.appendTo('#team-amount-error');
                } else {
                    error.insertAfter(element);
                }
            }
        })
    </script>
@endsection
