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
        ];
    }

    public function messages(): array
    {
        return [
            'lat.required' => 'Zeměpisná šířka je povinná.',
            'lng.required' => 'Zeměpisná délka je povinná.',
        ];
    }

}
