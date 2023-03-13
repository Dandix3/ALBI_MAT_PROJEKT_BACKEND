<?php

namespace App\Http\Requests\club;

use App\Http\Requests\AbstractGetRequest;

class CreateClubRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'string|nullable',
            'postal_code' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
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
