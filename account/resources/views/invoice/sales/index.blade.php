@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/nepali.datepicker.v2.1.min.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Invoice Wise Sales Entry</h1>
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

    {{-- Filter form --}}
    <div class="row my-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter Options</h3>
        
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('sales.index') }}" method="post">
                        @csrf

                        <div class="row">

                            {{-- date range picker --}}
                            <div class="col-12 col-sm-12 col-md-4 my-1">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nepaliDate10" name="start_date" placeholder="Start(YYYY-MM-DD)">
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nepaliDate11" name="end_date" placeholder="End(YYYY-MM-DD)">
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                </div>
                            </div>

                            {{-- Company Filter --}}
                            <div class="col-12 col-sm-12 col-md-4 my-1">
                                <div class="form-group">
                                    <select name="company" id="" class="form-control">
                                        <option value="">-- select a company for sales entry --</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- sales type --}}
                            <div class="col-12 col-sm-12 col-md-2 my-1">
                                <div class="form-group">
                                    <select name="tax_type" id="" class="form-control">
                                        <option value="">-- Sales Type --</option>
                                        <option value="0">Non-Taxable</option>
                                        <option value="1">Taxable</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Filter Button --}}
                            <div class="col-12 col-sm-12 col-md-2 my-1">
                                <button type="submit" class="btn btn-block btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
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
                                <td>Rs. {{ $sale->amount }}</td>
                                <td>
                                    <button class="btn btn-outline-success btn-sm edit-sales" data-id="{{ $sale->id }}" data-toggle="tooltip" data-placement="top" title="Edit Sales Detail">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm delete-sales" data-id="{{ $sale->id }}" data-toggle="tooltip" data-placement="top" title="Delete Sales Detail">
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
                            <th>Rs. {{ $totalAmount }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="modal-sales-edit">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    {{-- <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script> --}}
    <script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/jszip.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/nepali.datepicker.v2.1.min.js') }}"></script>
    <script src="{{ asset('js/nepalidate.js') }}"></script>

    <script>
        jQuery(function($) {
            // data table
            $('#sales-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "print",
                        title: "Invoice Wise Sales Entry",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                        },
                        text: '<i class="fas fa-fw fa-print"></i> Print'
                    },
                    {
                        extend: "excel",
                        title: "Invoice Wise Sales Entry",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                        },
                        text: '<i class="fas fa-fw fa-file-excel"></i> Download as Excel'
                    },
                    {
                        extend: "pdf",
                        title: "Invoice Wise Sales Entry",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                        },
                        text: '<i class="fas fa-fw fa-file-pdf"></i> Download as PDF'
                    },
                ]
            });

            // tooltip for buttons
            $('.btn').tooltip();

            // $('#reservation').daterangepicker();

            $('#sales-table').on('click', '.edit-sales', function() {
                // assign route and id to the variables
                let url = "{{ route('sales.edit', ':id') }}",
                    id = this.dataset.id;
                
                // replace the id string with actual id
                url = url.replace(':id', id);

                // send ajax get request to the server
                $.get(url, function(response) {
                    $('#modal-sales-edit .modal-content').html(response);
                    $('#modal-sales-edit').modal({
                        display: 'show',
                        backdrop: 'static',
                        keyboard: false
                    });
                });


            });

            $('#sales-table').on('click', '.delete-sales', function() {
                if (confirm("Are you sure you want to delete this sales data?")) {
                    let id = this.dataset.id,
                        url = "{{ route('sales.destroy', ':id') }}";

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