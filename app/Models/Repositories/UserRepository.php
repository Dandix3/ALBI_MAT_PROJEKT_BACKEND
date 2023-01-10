<?php

namespace App\Models\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
     * @param string $nickname
     * @return User|null
     */
    public function findUserByNickname(string $nickname): User|null
    {
        return User::where('nickname', $nickname)->first() ?? null;
    }

    /**
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::all();
    }

}
