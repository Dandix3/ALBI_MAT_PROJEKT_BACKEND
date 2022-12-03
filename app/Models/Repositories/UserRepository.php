<?php

namespace App\Models\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    /**
     * @param int $userId
     * @return User
     */
    public function getUserById(int $userId): User
    {
        return User::where('id', $userId)->first();
    }

    /**
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::all();
    }

}
