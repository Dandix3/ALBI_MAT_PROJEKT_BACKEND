<?php

namespace App\Models\Repositories;

use App\Models\AchievementAction;
use Illuminate\Database\Eloquent\Builder;

class AchievementActionRepository
{
    public function getAchievementActionsForUser(int $userId): Builder
    {
            return AchievementAction::whereFriendToCheck($userId);
    }

    public function getAchievementActionById(int $achievementActionId): AchievementAction|null
    {
        try {
            return AchievementAction::findOrFail($achievementActionId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
