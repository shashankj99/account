@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Ledger Sheet for {{ $account->name }}</h1>
        </div>
    </div>
@endsection

@section('content')

    {{-- ledger account table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-responsive-sm">
                <table class="table table-hover" id="account-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Ledger Account Name</th>
                            <th>Particulars</th>
                            <th>Qty</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($account->ledgerEntries as $entry)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <th>{{ $entry->date }}</th>
                                <td>{{ $entry->ledgerAccount->name }}</td>
                                <td>{{ $entry->particulars }}</td>
                                <td>{{ ($entry->qty == null) ? 0 : $entry->qty }}</td>
                                <td>Rs. {{ $entry->debit }}</td>
                                <td>Rs. {{ $entry->credit }}</td>
                                <td>Rs. {{ ($entry->amount == null) ? 0 : $entry->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total Balance</th>
                            <th>{{ $account->amount }}</th>
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
    <script src="{{ asset('js/dataTableButtons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/jszip.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/dataTableButtons/vfs_fonts.js') }}"></script>

    <script>
        jQuery(function($) {
            // data table
            $('#account-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "print",
                        title: "Ledger Sheet for " + "{{ $account->name }}",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                        text: '<i class="fas fa-fw fa-print"></i> Print'
                    },
                    {
                        extend: "excel",
                        title: "Ledger Sheet for " + "{{ $account->name }}",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                        text: '<i class="fas fa-fw fa-file-excel"></i> Download as Excel'
                    },
                    {
                        extend: "pdf",
                        title: "Ledger Sheet for " + "{{ $account->name }}",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                        text: '<i class="fas fa-fw fa-file-pdf"></i> Download as PDF'
                    },
                ]
            });
        });
    </script>
@endsection