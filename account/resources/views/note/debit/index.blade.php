@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/nepali.datepicker.v2.1.min.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Debit Note Voucher Entry</h1>
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
                    This page is user limited. Each user can make debit note voucher entry of a single company at a single time. The debit note voucher entry made by a user is not visible to other users but limited to admin only.
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    {{-- Receipt Enrty Button --}}
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4"></div>
        <div class="col-12 col-sm-12 col-md-4 my-2">
            <a href="{{ route('debit.create') }}" class="btn btn-block btn-primary">
                <i class="fas fa-upload"></i> Make Debit Note Entry
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

                    <form action="{{ route('debit.index') }}" method="post">
                        @csrf

                        <div class="row">

                            {{-- date range picker --}}
                            <div class="col-12 col-sm-12 col-md-6 my-1">
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
                                        <option value="">-- select a company for debit note entry --</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
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

    {{-- debit table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-responsive-sm">
                <table class="table table-hover" id="debit-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Name Of Company</th>
                            <th>Debit Note No</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($debits as $debit)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $debit->date }}</td>
                                <td>{{ $debit->company->name }}</td>
                                <td><span class="badge bg-success">{{ $debit->debit_note_no }}</span></td>
                                <td>{{ ($debit->qty == null) ? 0 : $debit->qty }}</td>
                                <td>Rs. {{ $debit->amount }}</td>
                                <td>
                                    <a href="{{ route('debit.edit', $debit->id) }}" class="btn btn-outline-success btn-sm edit-debit" data-toggle="tooltip" data-placement="top" title="Edit Debit Note Detail">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm delete-debit" data-id="{{ $debit->id }}" data-toggle="tooltip" data-placement="top" title="Delete Debit Note Detail">
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
            $('#debit-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "print",
                        title: "Debit Note Voucher Entry",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                        text: '<i class="fas fa-fw fa-print"></i> Print'
                    },
                    {
                        extend: "excel",
                        title: "Debit Note Voucher Entry",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                        text: '<i class="fas fa-fw fa-file-excel"></i> Download as Excel'
                    },
                    {
                        extend: "pdf",
                        title: "Debit Note Voucher Entry",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                        text: '<i class="fas fa-fw fa-file-pdf"></i> Download as PDF'
                    },
                ]
            });

            // tooltip for buttons
            $('.btn').tooltip();

            // $('#reservation').daterangepicker();

            $('#debit-table').on('click', '.delete-debit', function() {
                if (confirm("Are you sure you want to delete this debit data?")) {
                    let id = this.dataset.id,
                        url = "{{ route('debit.destroy', ':id') }}";

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