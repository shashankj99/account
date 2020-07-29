<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_id' => 'required|numeric',
            'date' => 'required',
            'credit_note_no' => 'required|numeric',
            'amount' => 'required|numeric'
        ];
    }
}
