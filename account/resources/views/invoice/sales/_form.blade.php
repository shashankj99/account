<div class="row">
    <div class="col-12 col-sm-12 col-md-6 my-2">
        <select name="company_id" id="company_id" class="form-control select2 @error('company_id') is-invalid @enderror" required>
            <option value="">-- Select a company to make sales entry --</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>

        @error('company_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-12 col-sm-12 col-md-6 my-2">
        <button class="btn btn-block btn-success" id="add-new-field">
            <i class="fas fa-plus-circle"></i>  Add New Field    
        </button>
    </div>
</div>


<div class="form-field-div">
    <div class="form-group row">

        <div class="col-12 col-sm-6 col-md-3 my-2">
            <input id="invoice_no" type="text" class="form-control" name="invoice_no" required autofocus placeholder="Enter Invoice No.">
        </div>
    
        <div class="col-12 col-sm-6 col-md-3 my-2">
            <input id="invoice-date" type="date" class="form-control" name="invoice_date" required autofocus placeholder="Enter Invoice Date">
        </div>
    
        <div class="col-12 col-sm-6 col-md-3 my-2">
            <input id="amount" type="number" class="form-control" name="amount" required autofocus placeholder="Enter total amount" min="1">
        </div>
    
        <div class="col-12 col-sm-6 col-md-3 my-2">
            <select name="type" id="type" class="form-control" required>
                <option value="">-- Select tax type --</option>
                <option value="0">Non-Taxable</option>
                <option value="1">Taxable</option>
            </select>
        </div>

    </div>
</div>

{{-- Sales Submit Button --}}
<div class="row">
    <div class="col-12 col-sm-12 col-md-4"></div>
    <div class="col-12 col-sm-12 col-md-4 my-2">
        <button type="submit" class="btn btn-block btn-primary">
            <i class="fas fa-plus-circle"></i> {{ $buttonText }}
        </button>
    </div>
    <div class="col-12 col-sm-12 col-md-4"></div>
</div>
