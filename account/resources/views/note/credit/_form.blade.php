<div class="row justify-content-center">
    <div class="col-12">

        <div class="form-group row">
            <label for="company_id" class="col-md-4 col-form-label text-md-right">{{ __('Select a Company') }}</label>

            <div class="col-md-6">

                <select name="company_id" id="company_id" class="form-control select2 @error('company_id') is-invalid @enderror" required>
                    <option value="">-- Select a company for entry --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ ($credit->company_id == $company->id) ? "selected" : "" }}>{{ $company->name }}</option>
                    @endforeach
                </select>

                @error('company_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date Of Entry') }}</label>

            <div class="col-md-6">
                <input id="nepaliDate10" type="text" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', $credit->date) }}" requried placeholder="Date (YYYY-MM-DD)">

                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="credit_note_no" class="col-md-4 col-form-label text-md-right">{{ __('Credit Note Number') }}</label>

            <div class="col-md-6">
                <input id="credit_note_no" type="text" class="form-control @error('credit_note_no') is-invalid @enderror" name="credit_note_no" value="{{ old('credit_note_no', $credit->credit_note_no) }}" required autocomplete="credit_note_no" autofocus placeholder="Enter the credit note no">

                @error('credit_note_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="qty" class="col-md-4 col-form-label text-md-right">{{ __('Enter Quantity') }}</label>

            <div class="col-md-6">
                <input id="qty" type="text" class="form-control @error('qty') is-invalid @enderror" name="qty" value="{{ old('qty', $credit->qty) }}" autocomplete="qty" autofocus placeholder="Enter the quantity">

                @error('qty')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Enter Amount') }}</label>

            <div class="col-md-6">
                <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount', $credit->amount) }}" required autocomplete="amount" autofocus placeholder="Enter the amount">

                @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> {{ $buttonText }}
                </button>
            </div>
        </div>

    </div>
</div>