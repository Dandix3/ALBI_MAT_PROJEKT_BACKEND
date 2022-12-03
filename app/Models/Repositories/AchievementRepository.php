<?php

namespace App\Models\Repositories;

use App\Models\Achievement;
use Illuminate\Database\Query\Builder;

class AchievementRepository
{
    /**
     * @param int $gameId
     * @return Builder|Achievement
     */
    public function getGameAchievements(int $gameId): Builder|Achievement
    {
        return Achievement::whereGameId($gameId);
    }

}
