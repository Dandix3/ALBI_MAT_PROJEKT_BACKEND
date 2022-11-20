<?php

namespace App\Models\Services;

use App\Models\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Nette\Schema\ValidationException;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }


    /**
     * @return User
     */
    public function getUser(): \Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }

    public function getUserById(int $id = null): User
    {
        if ($id === null) {
            throw new ValidationException("ID is required");
        }
        $result = $this->userRepository->getUserById($id);

        if (!$result) {
            throw new ModelNotFoundException("User not found");
        }

        return $result;
    }

    public function getAllUsers(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->userRepository->getAllUsers();
    }

}
