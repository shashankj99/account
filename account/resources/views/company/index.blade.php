@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Company Management Page</h1>
        </div>
    </div>
@endsection

@section('content')
    
    {{-- Info Box --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Info !</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    This page is accessible by all users. Users can create & edit a company but can not delete the company. Because of various non disclosure reasons, the company deletion function is limited to admin level only.
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    {{-- Company creation Button --}}
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4"></div>
        <div class="col-12 col-sm-12 col-md-4 my-2">
            <a href="{{ route('company.create') }}" class="btn btn-block btn-primary">
                <i class="fas fa-plus"></i> Add A Company
            </a>
        </div>
        <div class="col-12 col-sm-12 col-md-4"></div>
    </div>

    {{-- company table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-responsive-sm">
                <table class="table table-hover" id="company-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Registration No.</th>
                            <th>Date of Registration</th>
                            <th>Company Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->reg_no }}</td>
                                <td>{{ $company->reg_date }}</td>
                                <td><span class="badge bg-success">{{ \App\Category::find($company->type)->name }}</span></td>
                                <td>
                                    <a href="{{ route('company.edit', $company->id) }}" class="btn btn-outline-success btn-sm edit-details" data-toggle="tooltip" data-placement="top" title="Edit Company Details">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @can('delete', $company)
                                        <button class="btn btn-outline-danger btn-sm delete-company" data-id="{{ $company->id }}" data-toggle="tooltip" data-placement="top" title="Delete Company">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>

    <script>
        jQuery(function($) {
            // data table
            $('#company-table').DataTable();

            // tooltip for buttons
            $('.btn').tooltip();

            $('#company-table').on('click', '.delete-company', function() {
                if (confirm("Are you sure you want to delete this company?")) {
                    let id = this.dataset.id,
                        url = "{{ route('company.destroy', ':id') }}";

                    url = url.replace(":id", id);

                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success:function(response) {
                            alert(response);
                            location.reload();
                        }
                    });
                } else {
                    return false;
                }
            });
        });
    </script>
@endsection
