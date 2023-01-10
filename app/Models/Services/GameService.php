<?php

namespace App\Models\Services;

use App\Exceptions\ModelDuplicateFoundException;
use App\Exceptions\NotFoundException;
use App\Models\Game;
use App\Models\Repositories\GameRepository;
use Nette\Schema\ValidationException;

class GameService
{
    protected GameRepository $gameRepository;
    protected UserGamesService $userGamesService;

    public function __construct()
    {
        $this->gameRepository = new GameRepository();
        $this->userGamesService = new UserGamesService();
    }

    /**
     * @param string|null $ean
     * @return Game
     * @throws NotFoundException
     * @throws ModelDuplicateFoundException
     */
    public function scannedGame(string $ean = null): Game
    {
        if ($ean === null) {
            throw new ValidationException("EAN is required");
        }
        $result = $this->gameRepository->getGameByEAN($ean);

        if (!$result) {
            throw new NotFoundException("Hra nebyla nalezena");
        }

        if ($result->count() > 1) {
            throw new ModelDuplicateFoundException("Hra byla nalezena vícekrát, zadejte další kód");
        }
        //$this->userGamesService->setGameToUser($result->first());

        return $result->first();
    }

    public function addGame($ksp): Game
    {
        $game = $this->gameRepository->getGameByKSP($ksp);
        $this->userGamesService->setGameToUser($game);
        return $game;
    }
}
