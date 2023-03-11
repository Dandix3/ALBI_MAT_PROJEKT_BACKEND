<?php

namespace App\Http\Requests\club;

use App\Http\Requests\AbstractGetRequest;

class FindNearestClubRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'numeric',
            'limit' => 'numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'lat.required' => 'Zeměpisná šířka je povinná.',
            'lng.required' => 'Zeměpisná délka je povinná.',
            'lat.numeric' => 'Zeměpisná šířka musí být číslo.',
            'lng.numeric' => 'Zeměpisná délka musí být číslo.',
            'radius.numeric' => 'Rádius musí být číslo.',
            'limit.numeric' => 'Limit musí být číslo.',
        ];
    }

}
