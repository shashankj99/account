<div class="row justify-content-center">
    <div class="col-12">

        <div class="form-group row">
            <label for="company_id" class="col-md-4 col-form-label text-md-right">{{ __('Select a Company') }}</label>

            <div class="col-md-6">

                <select name="company_id" id="company_id" class="form-control select2 @error('company_id') is-invalid @enderror" required>
                    <option value="">-- Select a company for entry --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ ($payment->company_id == $company->id) ? "selected" : "" }}>{{ $company->name }}</option>
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
                <input id="nepaliDate10" type="text" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', $payment->date) }}" requried placeholder="Date (YYYY-MM-DD)">

                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="receipt_no" class="col-md-4 col-form-label text-md-right">{{ __('Voucher Number') }}</label>

            <div class="col-md-6">
                <input id="receipt_no" type="text" class="form-control @error('receipt_no') is-invalid @enderror" name="receipt_no" value="{{ old('receipt_no', $payment->receipt_no) }}" required autocomplete="receipt_no" autofocus placeholder="Enter the voucher no">

                @error('receipt_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="particulars" class="col-md-4 col-form-label text-md-right">{{ __('Particulars') }}</label>

            <div class="col-md-6">
                <input id="particulars" type="text" class="form-control @error('particulars') is-invalid @enderror" name="particulars" value="{{ old('particulars', $payment->particulars) }}" required autocomplete="particulars" autofocus placeholder="Enter the particulars for entry">

                @error('particulars')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="debit" class="col-md-4 col-form-label text-md-right">{{ __('Enter Debit Amount') }}</label>

            <div class="col-md-6">
                <input id="debit" type="text" class="form-control @error('debit') is-invalid @enderror" name="debit" value="{{ old('debit', $payment->debit) }}" required autocomplete="debit" autofocus placeholder="Enter the debit amount">

                @error('debit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="credit" class="col-md-4 col-form-label text-md-right">{{ __('Enter Credit Amount') }}</label>

            <div class="col-md-6">
                <input id="credit" type="text" class="form-control @error('credit') is-invalid @enderror" name="credit" value="{{ old('credit', $payment->credit) }}" required autocomplete="credit" autofocus placeholder="Enter the credit amount">

                @error('credit')
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