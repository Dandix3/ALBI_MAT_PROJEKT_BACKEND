<?php

namespace App\Models\Services;

use App\Exceptions\NotFoundException;
use App\Models\Repositories\AchievementRepository;
use App\Models\Repositories\UserAchievementRepository;

class AchievementService
{
    protected AchievementRepository $gameAchievementsRepository;
    protected UserAchievementRepository $userAchievementsRepository;
    protected AchievementActionService $achievementActionService;

    public function __construct()
    {
        $this->gameAchievementsRepository = new AchievementRepository();
        $this->userAchievementsRepository = new UserAchievementRepository();
        $this->achievementActionService = new AchievementActionService();
    }

    /**
     * Slouží pro aktualizaci achievementu uživatele
     * @param int $achievementId
     * @param int $points
     * @param array $friendsIds
     * @return \App\Models\UserAchievement
     * @throws NotFoundException
     */
    public function updateUserAchievement(int $achievementId, int $points, array $friendsIds): \App\Models\UserAchievement
    {
        $achievement = $this->userAchievementsRepository->getUserAchievement($achievementId);
        if ($achievement === null) {
            throw new NotFoundException("Úspěchy pro hru s ID $achievementId nebyly nalezeny.");
        }

        foreach ($friendsIds as $friendId) {
            $this->achievementActionService->createAchievementAction($friendId, $achievementId, $achievement->points, $points);
        }

        $achievement->points = $points;
        $achievement->setWaitingForCheckStatus();
        $achievement->save();

        return $achievement;
    }
}
