<?php

namespace App\Http\Requests\club;

use App\Http\Requests\AbstractGetRequest;

class UpdateClubRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'address' => 'string',
            'city' => 'string',
            'country' => 'string',
            'postal_code' => 'string',
            'lat' => 'numeric',
            'lng' => 'numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Název musí být řetězec.',
            'description.string' => 'Popis musí být řetězec.',
            'address.string' => 'Adresa musí být řetězec.',
            'city.string' => 'Město musí být řetězec.',
            'country.string' => 'Země musí být řetězec.',
            'postal_code.string' => 'PSČ musí být řetězec.',
            'lat.numeric' => 'Zeměpisná šířka musí být číslo.',
            'lng.numeric' => 'Zeměpisná délka musí být číslo.',
        ];
    }

}
