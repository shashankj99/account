<div class="row justify-content-center">
    <div class="col-12">

        <div class="form-group row">
            <label for="company_id" class="col-md-4 col-form-label text-md-right">{{ __('Select a Company') }}</label>

            <div class="col-md-6">

                <select name="company_id" id="company_id" class="form-control select2 @error('company_id') is-invalid @enderror" required>
                    <option value="">-- Select a company for account --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ ($account->company_id == $company->id) ? "selected" : "" }}>{{ $company->name }}</option>
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
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Account Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $account->name) }}" required autocomplete="name" autofocus placeholder="Enter the name for Ledger Account">

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
                    <i class="fas fa-plus-circle"></i> {{ $buttonText }}
                </button>
            </div>
        </div>

    </div>
</div>