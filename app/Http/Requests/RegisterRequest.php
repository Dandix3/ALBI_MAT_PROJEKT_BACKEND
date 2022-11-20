<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nickname' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Jméno je povinné.',
            'first_name.string' => 'Jméno musí být řetězec.',
            'first_name.max' => 'Jméno může mít maximálně 255 znaků.',
            'last_name.required' => 'Příjmení je povinné.',
            'last_name.string' => 'Příjmení musí být řetězec.',
            'last_name.max' => 'Příjmení může mít maximálně 255 znaků.',
            'email.required' => 'Email je povinný.',
            'email.string' => 'Email musí být řetězec.',
            'email.email' => 'Email musí být platný email.',
            'email.max' => 'Email může mít maximálně 255 znaků.',
            'email.unique' => 'Email je již použit.',
            'nickname.required' => 'Přezdívka je povinná.',
            'nickname.string' => 'Přezdívka musí být řetězec.',
            'nickname.max' => 'Přezdívka může mít maximálně 255 znaků.',
            'password.required' => 'Heslo je povinné.',
            'password.min' => 'Heslo musí mít minimálně 8 znaků.',
        ];
    }

}
