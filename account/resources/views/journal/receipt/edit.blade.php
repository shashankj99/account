@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/nepali.datepicker.v2.1.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <a href="{{ route('receipt.index') }}" class="btn btn-block btn-primary">
                <i class="fas fa-arrow-circle-left"></i> Go Back
            </a>
        </div>
        <div class="col-12 col-sm-8 col-md-10 mb-2">
            <div class="text-center">
                <h1 class="m-0 text-dark">Edit receipt entry</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <form action="{{ route('receipt.update', $receipt->id) }}" method="post">
                @csrf
                {{ method_field('PUT') }}
                @include('journal.receipt._form', ['buttonText' => 'Update', 'companies' => $companies, 'receipt' => $receipt])
            </form>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script src="{{ asset('js/nepali.datepicker.v2.1.min.js') }}"></script>
    <script src="{{ asset('js/nepalidate.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        jQuery(function($) {
            $('.select2').select2();
        });
    </script>
@endsection
