<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    public function authorize()
    {
        return !is_auth();
    }

    public function rules()
    {
        return [
            'login'    => 'required',
            'password' => 'required'
        ];
    }
}
