<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class AddFriendRequest extends AbstractGetRequest
{
    public function rules(): array
    {
        return [
            'friend_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'friend_id.required' => 'Je vyžadováno ID přítele',
            'friend_id.integer' => 'ID přítele musí být celé číslo',
            'friend_id.exists' => 'ID přítele neexistuje',
        ];
    }

}
