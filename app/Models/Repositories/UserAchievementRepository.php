<?php

namespace App\Models\Repositories;

use App\Models\UserAchievement;
use Illuminate\Support\Facades\Auth;

class UserAchievementRepository
{

    /**
     * @param int $achievementId
     */
    public function createUserAchievement(int $achievementId): void
    {
        $achievement = new UserAchievement();
        $achievement->achievement_id = $achievementId;
        $achievement->user_id = Auth::user()->id;
        $achievement->points = 0;
        $achievement->status_id = UserAchievement::STATUS_CREATED;
        $achievement->save();
    }

    /**
     * @param int $id
     * @return UserAchievement|null
     */
    public function getUserAchievement(int $id): ?UserAchievement
    {
        return UserAchievement::find($id);
    }
}
