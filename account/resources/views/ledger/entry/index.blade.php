@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Ledger Entry Page</h1>
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
                    This page is user limited. Each user can make multiples ledger entries for a single ledger account one at a time. The ledger entries made by a user is not visible to other users but limited to admin only.
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    {{-- ledger entry creation Button --}}
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4"></div>
        <div class="col-12 col-sm-12 col-md-4 my-2">
            <a href="{{ route('entry.create') }}" class="btn btn-block btn-primary">
                <i class="fas fa-plus"></i> Add A Ledger Entry
            </a>
        </div>
        <div class="col-12 col-sm-12 col-md-4"></div>
    </div>

    {{-- ledger entry table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-responsive-sm">
                <table class="table table-hover" id="entry-table">
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ledgerEntries as $entry)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <th>{{ $entry->date }}</th>
                                <td>{{ $entry->ledgerAccount->name }}</td>
                                <td>{{ $entry->particulars }}</td>
                                <td>{{ ($entry->qty == null) ? 0 : $entry->qty }}</td>
                                <td>Rs. {{ $entry->debit }}</td>
                                <td>Rs. {{ $entry->credit }}</td>
                                <td>Rs. {{ ($entry->amount == null) ? 0 : $entry->amount }}</td>
                                <td>
                                    <a href="{{ route('entry.edit', $entry->id) }}" class="btn btn-outline-success btn-sm edit-details" data-toggle="tooltip" data-placement="top" title="Edit Entry Details">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm delete-entry" data-id="{{ $entry->id }}" data-toggle="tooltip" data-placement="top" title="Delete Entry Details">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
            $('#entry-table').DataTable();

            // tooltip for buttons
            $('.btn').tooltip();

            $('#entry-table').on('click', '.delete-entry', function() {
                if (confirm("Are you sure you want to delete this ledger entry?")) {
                    let id = this.dataset.id,
                        url = "{{ route('entry.destroy', ':id') }}";

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