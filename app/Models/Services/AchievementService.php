<?php

namespace App\Models\Services;

use App\Exceptions\NotFoundException;
use App\Models\Repositories\AchievementRepository;

class AchievementService
{
    protected AchievementRepository $gameAchievementsRepository;

    public function __construct()
    {
        $this->gameAchievementsRepository = new AchievementRepository();
    }

    public function getGameAchievements($gameId)
    {
        $gameAchievements = $this->gameAchievementsRepository->getGameAchievements($gameId);
        if ($gameAchievements === null) {
            throw new NotFoundException("Úspěchy pro hru s ID $gameId nebyly nalezeny.");
        }
        return $gameAchievements;
    }
}
