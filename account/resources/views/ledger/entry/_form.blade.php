<div class="row justify-content-center">
    <div class="col-12">

        <div class="form-group row">
            <label for="ledger_account_id" class="col-md-4 col-form-label text-md-right">{{ __('Select a Company') }}</label>

            <div class="col-md-6">

                <select name="ledger_account_id" id="ledger_account_id" class="form-control select2 @error('ledger_account_id') is-invalid @enderror" required>
                    <option value="">-- Select a account for entry --</option>
                    @foreach ($ledgerAccounts as $account)
                        <option value="{{ $account->id }}" {{ ($entry->ledger_account_id == $account->id) ? "selected" : "" }}>{{ $account->name }}</option>
                    @endforeach
                </select>

                @error('ledger_account_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date Of Entry') }}</label>

            <div class="col-md-6">
                <input id="nepaliDate10" type="text" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', $entry->date) }}" requried placeholder="Date (YYYY-MM-DD)">

                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="particulars" class="col-md-4 col-form-label text-md-right">{{ __('Particulars') }}</label>

            <div class="col-md-6">
                <input id="particulars" type="text" class="form-control @error('particulars') is-invalid @enderror" name="particulars" value="{{ old('particulars', $entry->particulars) }}" required autocomplete="particulars" autofocus placeholder="Enter the particulars for Ledger Account">

                @error('particulars')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="qty" class="col-md-4 col-form-label text-md-right">{{ __('qty') }}</label>

            <div class="col-md-6">
                <input id="qty" type="text" class="form-control @error('qty') is-invalid @enderror" name="qty" value="{{ old('qty', $entry->qty) }}" required autocomplete="qty" autofocus placeholder="Enter the qty for Ledger Account">

                @error('qty')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="debit" class="col-md-4 col-form-label text-md-right">{{ __('Enter Debit Amount') }}</label>

            <div class="col-md-6">
                <input id="debit" type="text" class="form-control @error('debit') is-invalid @enderror" name="debit" value="{{ old('debit', $entry->debit) }}" required autocomplete="debit" autofocus placeholder="Enter the debit for Ledger Account">

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
                <input id="credit" type="text" class="form-control @error('credit') is-invalid @enderror" name="credit" value="{{ old('credit', $entry->credit) }}" required autocomplete="credit" autofocus placeholder="Enter the credit for Ledger Account">

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