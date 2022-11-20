<?php

namespace App\Models\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUserById($id)
    {
        return User::where('id', $id)->first();
    }

    public function getAllUsers()
    {
        return User::all();
    }

}
