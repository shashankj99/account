<div class="modal-header">
    <h4 class="modal-title">Edit Purchase Entry</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form action="{{ route('purchase.update', $purchase->id) }}" method="post">
    @csrf
    {{ method_field('PUT') }}
    
    <div class="modal-body">

        <div class="form-group row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="company_id">Select a company</label>
                    </div>
                    <div class="col-12 col-sm-6 col-md-9 mb-3">
                        <select name="company_id" id="" class="form-control">
                            <option value="">-- Select a company from below --</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ ($purchase->company_id == $company->id) ? "selected" : ""}}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="invoice_no">Invoice Number</label>
                    </div>
                    <div class="col-12 col-sm-6 col-md-9 mb-3">
                        <input type="text" class="form-control" name="invoice_no" value="{{ $purchase->invoice_no }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="invoice_date">Invoice Date</label>
                    </div>
                    <div class="col-12 col-sm-6 col-md-9 mb-3">
                        <input type="date" class="form-control" name="invoice_date" value="{{ $purchase->invoice_date }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="amount">Total Amount</label>
                    </div>
                    <div class="col-12 col-sm-6 col-md-9 mb-3">
                        <input type="text" class="form-control" name="amount" value="{{ $purchase->amount }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="tax_type">Select Tax Type</label>
                    </div>
                    <div class="col-12 col-sm-6 col-md-9 mb-3">
                        <select name="tax_type" id="" class="form-control">
                            <option value="">-- Select a company from below --</option>
                            <option value="0" {{ ($purchase->type == 0) ? "selected" : "" }}>Non-Taxable</option>
                            <option value="1" {{ ($purchase->type == 1) ? "selected" : "" }}>Taxable</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>