<div class="row justify-content-center">
    <div class="col-12">

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name Of Company') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $company->name) }}" required autocomplete="name" autofocus placeholder="Enter the name of company">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="reg_no" class="col-md-4 col-form-label text-md-right">{{ __('Registration Number') }}</label>

            <div class="col-md-6">
                <input id="reg_no" type="text" class="form-control @error('reg_no') is-invalid @enderror" name="reg_no" value="{{ old('reg_no', $company->reg_no) }}" required autocomplete="reg_no" placeholder="Enter the Registration number">

                @error('reg_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="reg_date" class="col-md-4 col-form-label text-md-right">{{ __('Date of Registration') }}</label>

            <div class="col-md-6">
                <input id="nepaliDate10" type="text" class="form-control @error('reg_date') is-invalid @enderror" name="reg_date" value="{{ old('reg_date', $company->reg_date) }}" requried placeholder="Date of Registration (YYYY-MM-DD)">

                @error('reg_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

            <div class="col-md-6">
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $company->address) }}" requried placeholder="Enter Address">
            </div>
        </div>

        <div class="form-group row">
            <label for="contact_no" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>

            <div class="col-md-6">
                <input id="contact_no" type="number" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no', $company->contact_no) }}" requried placeholder="Enter Contact Number" minlength="10" maxlength="15">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Company Type') }}</label>

            <div class="col-md-6">

                <select name="type" id="type" class="form-control select2 @error('type') is-invalid @enderror" required>
                    <option value="">-- Select a category for company --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ ($company->type == $category->id) ? "selected" : "" }}>{{ $category->name }}</option>
                    @endforeach
                </select>

                @error('type')
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