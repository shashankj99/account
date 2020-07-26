<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    // function to determine whether the user is allowed to make this request
    public function authorize() {
        return true;
    }

    // validation rules that apply to the request
    public function rules() {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'mobile' => ["required", "numeric"],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ["required"],
        ];
    }
}
