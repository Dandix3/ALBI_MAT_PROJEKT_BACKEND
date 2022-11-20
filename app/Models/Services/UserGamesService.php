<?php

namespace App\Models\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\UserAlreadyHasGameException;
use App\Models\Game;
use App\Models\Repositories\GameRepository;
use App\Models\Repositories\UserGamesRepository;
use App\Models\UserGames;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Nette\Schema\ValidationException;

class UserGamesService
{
    protected UserGamesRepository $userGamesRepository;

    public function __construct()
    {
        $this->userGamesRepository = new UserGamesRepository();
    }

    /**
     * @param string|null $ean
     * @return Game
     * @throws NotFoundException
     * @throws \Exception
     */
    public function setGameToUser(Game $game): void
    {
//        if ($this->checkGameInUserGames($game)) {
//            throw new UserAlreadyHasGameException("Hra je již v seznamu");
//        }

        $this->userGamesRepository->setGameToUser($game);
    }

    public function getUsersGames(): Collection
    {
        return $this->userGamesRepository->getAllGamesFromUser()->get();
    }


    protected function checkGameInUserGames(Game $game): bool
    {
        return $this->userGamesRepository->checkGameInUserGames($game);
    }

}
