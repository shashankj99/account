@extends('layouts.app')

@section('page-styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/nepali.datepicker.v2.1.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <a href="{{ route('purchase.index') }}" class="btn btn-block btn-primary">
                <i class="fas fa-arrow-circle-left"></i> Go Back
            </a>
        </div>
        <div class="col-12 col-sm-8 col-md-10 mb-2">
            <div class="text-center">
                <h1 class="m-0 text-dark">Make a new purchase entry</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <form action="{{ route('purchase.store') }}" method="post">
                @csrf
                @include('invoice.purchase._form', ['buttonText' => 'Submit', 'companies' => $companies])
            </form>
        </div>
    </div>

@endsection

@section('page-scripts')
    {{-- <script src="{{ asset('js/nepali.datepicker.v2.1.min.js') }}"></script>
    <script src="{{ asset('js/nepalidate.js') }}"></script> --}}
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        jQuery(function($) {
            $('.select2').select2();

            let counter = 1, date=11;

            // add new fields
            $('#add-new-field').click(function() {
                // add the form field dynamically
                addFormField(counter);

                // increment the counter variable
                counter++;

                // increment the date variable
                date++;
            });

            // function to add the form field dynamically
            function addFormField(counter) {
                $('.form-field-div').append(`
                    <div class="form-group row">

                        <div class="col-12 col-sm-6 col-md-3 my-2">
                            <input id="invoice_no_${counter}" type="text" class="form-control" name="invoice_no_${counter}" required autofocus placeholder="Enter Invoice No.">
                        </div>

                        <div class="col-12 col-sm-6 col-md-3 my-2">
                            <input id="invoice_date_${counter}" type="date" class="form-control" name="invoice_date_${counter}" required autofocus placeholder="Enter Invoice Date">
                        </div>

                        <div class="col-12 col-sm-6 col-md-3 my-2">
                            <input id="amount_${counter}" type="number" class="form-control" name="amount_${counter}" required autofocus placeholder="Enter total amount" min="1">
                        </div>

                        <div class="col-12 col-sm-6 col-md-3 my-2">
                            <select name="type_${counter}" id="type_${counter}" class="form-control" required>
                                <option value="">-- Select tax type --</option>
                                <option value="0">Non-Taxable</option>
                                <option value="1">Taxable</option>
                            </select>
                        </div>

                    </div>
                `);
            }
        });
    </script>
@endsection
