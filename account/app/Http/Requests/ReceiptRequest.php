<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptRequest extends FormRequest
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
            'particulars' => 'required|string',
            'receipt_no' => 'required|numeric',
            'debit' => 'required|numeric',
            'credit' => 'required|numeric'
        ];
    }
}
