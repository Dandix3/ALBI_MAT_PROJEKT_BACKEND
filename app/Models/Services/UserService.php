<?php

namespace App\Models\Services;

use App\Exceptions\NotFoundException;
use App\Models\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
    public function getUser(): Authenticatable
    {
        return Auth::user();
    }

    /**
     * @param string $nickname
     * @return User
     * @throws NotFoundException
     */
    public function findUserByNickname(string $nickname): User
    {
        $user = $this->userRepository->findUserByNickname($nickname);
        if ($user === null) {
            throw new NotFoundException('User not found');
            throw new ModelNotFoundException('Uživatel s touto přezdívkou neexistuje.');
        }

        return $user;

    }

    /**
     * @param int|null $id
     * @return User
     */
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

    /**
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAllUsers();
    }

}
