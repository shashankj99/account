<div class="modal-header">
    <h4 class="modal-title">Edit Company Category</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{ route('category.update', $category->id) }}" method="post">
    @csrf
    {{ method_field('PUT') }}
    <div class="modal-body">
        <div class="form-group row">
            <div class="col-12">
                <input type="text" name="name" class="form-control" value="{{ $category->name }}">
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-check-circle"></i> Update
        </button>
    </div>
</form>
