@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Ledger Account Page</h1>
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
                    This page is user limited. Each user can make multiples ledger accounts for a single company one at a time. The ledger accounts made by a user is not visible to other users but limited to admin only. Because of various non disclosure reasons, the company deletion function is limited to admin level only.
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    {{-- ledger account creation Button --}}
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4"></div>
        <div class="col-12 col-sm-12 col-md-4 my-2">
            <a href="{{ route('account.create') }}" class="btn btn-block btn-primary">
                <i class="fas fa-plus"></i> Add A Ledger Account
            </a>
        </div>
        <div class="col-12 col-sm-12 col-md-4"></div>
    </div>

    {{-- ledger account table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-responsive-sm">
                <table class="table table-hover" id="account-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Company Name</th>
                            <th>Account Name</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ledgerAccounts as $account)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $account->company->name }}</td>
                                <td>{{ $account->name }}</td>
                                <td>Rs. {{ ($account->amount == null) ? 0 : $account->amount }}</td>
                                <td>
                                    <a href="{{ route('account.show', $account->id) }}" class="btn btn-outline-info btn-sm view-details" data-toggle="tooltip" data-placement="top" title="View Ledger Sheet">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('account.edit', $account->id) }}" class="btn btn-outline-success btn-sm edit-details" data-toggle="tooltip" data-placement="top" title="Edit Account Details">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @can('delete', $account)
                                        <button class="btn btn-outline-danger btn-sm delete-account" data-id="{{ $account->id }}" data-toggle="tooltip" data-placement="top" title="Delete Account Details">
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
            $('#account-table').DataTable();

            // tooltip for buttons
            $('.btn').tooltip();

            $('#account-table').on('click', '.delete-account', function() {
                if (confirm("Are you sure you want to delete this ledger account?")) {
                    let id = this.dataset.id,
                        url = "{{ route('account.destroy', ':id') }}";

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