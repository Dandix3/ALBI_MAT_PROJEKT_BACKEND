<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class GetAchievementsRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'game_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'game_id.required' => 'Game ID je povinný.',
            'game_id.integer' => 'Game ID musí být číslo.',
        ];
    }

}
