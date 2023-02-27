<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class CreateClubRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'location' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Název je povinný.',
            'description.required' => 'Popis je povinný.',
            'address.required' => 'Adresa je povinná.',
            'city.required' => 'Město je povinné.',
            'country.required' => 'Země je povinná.',
            'postal_code.required' => 'PSČ je povinné.',
            'location.required' => 'Poloha je povinná.',
        ];
    }

}
