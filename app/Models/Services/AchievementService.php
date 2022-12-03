<?php

namespace App\Models\Services;

use App\Exceptions\NotFoundException;
use App\Models\Repositories\AchievementRepository;
use App\Models\Repositories\UserAchievementRepository;

class AchievementService
{
    protected AchievementRepository $gameAchievementsRepository;
    protected UserAchievementRepository $userAchievementsRepository;

    public function __construct()
    {
        $this->gameAchievementsRepository = new AchievementRepository();
        $this->userAchievementsRepository = new UserAchievementRepository();
    }

    /**
     * Slouží pro aktualizaci achievementu uživatele
     * @param $achievementId
     * @param $points
     * @return void
     * @throws NotFoundException
     */
    public function updateUserAchievement($achievementId, $points): void
    {
        $achievement = $this->userAchievementsRepository->getUserAchievement($achievementId);
        if ($achievement === null) {
            throw new NotFoundException("Úspěchy pro hru s ID $achievementId nebyly nalezeny.");
        }

        $achievement->points = $points;
        $achievement->setWaitingForCheckStatus();
        $achievement->save();
    }
}
