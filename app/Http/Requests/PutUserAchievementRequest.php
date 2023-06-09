<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class PutUserAchievementRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'points' => 'required|integer|min:0',
            'friend_ids' => 'string|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'points.required' => 'Počet bodů je povinný.',
            'points.integer' => 'Počet bodů musí být celé číslo.',
            'points.min' => 'Počet bodů musí být kladné číslo.',
        ];
    }

}
