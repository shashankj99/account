@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Category Management Page</h1>
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
                    This page is independent of user particulars. The category created by one user can be used by another user. But the other user can't be able to edit or delete the category.
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="row">
        {{-- category form --}}
        <div class="col-12 col-sm-12 col-md-6 my-2">
            <form action="{{ route('category.store') }}" method="post">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Category') }}</label>
        
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter Category">
        
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- cateory table --}}
        <div class="table-responsive-sm">
            <table class="table table-hover table-sm" id="category-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @can('update', $category)
                                    <button class="btn btn-outline-success btn-sm edit-category" data-id="{{ $category->id }}" data-toggle="tooltip" data-placement="top" title="Edit Category"><i class="fas fa-edit"></i></button>
                                @endcan
                                @can('delete', $category)
                                    <button class="btn btn-outline-danger btn-sm delete-category" data-id="{{ $category->id }}" data-toggle="tooltip" data-placement="top" title="Delete Category"><i class="fas fa-trash"></i></button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="modal-category-edit">
        <div class="modal-dialog">
            <div class="modal-content">
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
            $('#category-table').DataTable();

            // tooltip for buttons
            $('.btn').tooltip();

            $('#category-table').on('click', '.edit-category', function() {
                // assign route and id to the variables
                let url = "{{ route('category.edit', ':id') }}",
                    id = this.dataset.id;
                
                // replace the id string with actual id
                url = url.replace(':id', id);

                // send ajax get request to the server
                $.get(url, function(response) {
                    $('#modal-category-edit .modal-content').html(response);
                    $('#modal-category-edit').modal({
                        display: 'show',
                        backdrop: 'static',
                        keyboard: false
                    });
                });


            });

            $('#category-table').on('click', '.delete-category', function() {
                if (confirm("Are you sure you want to delete this category?")) {
                    let id = this.dataset.id,
                        url = "{{ route('category.destroy', ':id') }}";

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