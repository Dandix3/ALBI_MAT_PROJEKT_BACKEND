<?php

namespace App\Http\Requests\club;

use App\Http\Requests\AbstractGetRequest;

class AddMembersToClubRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'user_ids' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_ids.required' => 'Uživatelé jsou povinní.',
        ];
    }

}
