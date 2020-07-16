@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/nepali.datepicker.v2.1.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('nav-menu')
    <li class="nav-item">
        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-category" data-backdrop="static" data-keyboard="false">
            <i class="fas fa-copy"></i> Company Category
        </button>
    </li>
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <a href="{{ route('company.index') }}" class="btn btn-block btn-primary">
                <i class="fas fa-arrow-circle-left"></i> Go Back
            </a>
        </div>
        <div class="col-12 col-sm-8 col-md-10 mb-2">
            <div class="text-center">
                <h1 class="m-0 text-dark">Add a new company</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    
    <div class="row">
        <div class="col-12">
            <form action="{{ route('company.store') }}" method="post">
                @csrf
                @include('company._form', ['buttonText' => 'Submit', 'categories' => $categories])
            </form>
        </div>
    </div>

    {{-- add category modal --}}
    <div class="modal fade" id="modal-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Company Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('category.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <input type="text" name="name" class="form-control" placeholder="Enter a category for the company">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Add
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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