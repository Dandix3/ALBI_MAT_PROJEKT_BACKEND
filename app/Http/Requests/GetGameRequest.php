<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class GetGameRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'scan' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'scan.required' => 'Sken je povinný.',
            'scan.numeric' => 'Sken musí být číslo.',
        ];
    }

}
