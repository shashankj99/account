<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    // function to determine whether the user is allowed to make this request
    public function authorize() {
        return true;
    }

    // validation rules that apply to the request
    public function rules() {
        return [
            'name' => ["required"],
            'reg_no' => ["required", "numeric"],
            'reg_date' => ["required"],
            'type'=> ["required", "numeric"]
        ];
    }
}
