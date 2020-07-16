@extends('layouts.app')

@section('content-header')
    <div class="row mb-2">
        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <a href="{{ route('user.index') }}" class="btn btn-block btn-primary">
                <i class="fas fa-arrow-circle-left"></i> Go Back
            </a>
        </div>
        <div class="col-12 col-sm-8 col-md-10 mb-2">
            <div class="text-center">
                <h1 class="m-0 text-dark">Register a new user</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    
    <div class="row">
        <div class="col-12">
            <form action="{{ route('user.store') }}" method="post">
                @csrf
                @include('user._form', ['buttonText' => 'Submit'])
            </form>
        </div>
    </div>

@endsection