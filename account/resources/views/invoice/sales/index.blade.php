@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Sales Wise Invoice Entry</h1>
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
                    This page is user limited. Each user can make sales entry of a single company at a single time. The sales entry made by a user is not visible to other users but limited to admin only.
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    {{-- Sales Enrty Button --}}
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4"></div>
        <div class="col-12 col-sm-12 col-md-4 my-2">
            <a href="{{ route('sales.create') }}" class="btn btn-block btn-primary">
                <i class="fas fa-upload"></i> Make Sales Entry
            </a>
        </div>
        <div class="col-12 col-sm-12 col-md-4"></div>
    </div>

    {{-- sales table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-responsive-sm">
                <table class="table table-hover" id="sales-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name Of Comapny</th>
                            <th>Invoice Number</th>
                            <th>Invoice Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $sale->company->name }}</td>
                                <td>{{ $sale->invoice_no }}</td>
                                <td>{{ $sale->invoice_date }}</td>
                                <td><span class="badge bg-warning">{{ ($sale->type == 1) ? "Taxable" : "Non-Taxable" }}</span></td>
                                <td>{{ $sale->amount }}</td>
                                <td>
                                    <a href="" class="btn btn-outline-success btn-sm view-details" data-toggle="tooltip" data-placement="top" title="View User Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm delete-user" data-id="{{ $sale->id }}" data-toggle="tooltip" data-placement="top" title="Delete User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <th>{{ $totalAmount }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
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
            $('#sales-table').DataTable();

            // tooltip for buttons
            $('.btn').tooltip();

        //     $('#user-table').on('click', '.delete-user', function() {
        //         if (confirm("Are you sure you want to delete this user?")) {
        //             let id = this.dataset.id,
        //                 url = "{{ route('user.destroy', ':id') }}";

        //             url = url.replace(":id", id);

        //             $.ajax({
        //                 url: url,
        //                 type: "DELETE",
        //                 data: {
        //                     "_token": "{{ csrf_token() }}",
        //                 },
        //                 success:function(response) {
        //                     alert(response);
        //                     location.reload();
        //                 }
        //             });
        //         } else {
        //             return false;
        //         }
        //     });
        });
    </script>
@endsection