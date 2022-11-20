<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email je povinný.',
            'email.string' => 'Email musí být řetězec.',
            'email.email' => 'Email musí být platný email.',
            'email.max' => 'Email může mít maximálně 255 znaků.',
            'password.required' => 'Heslo je povinné.',
            'password.min' => 'Heslo musí mít minimálně 8 znaků.',
        ];
    }

}
