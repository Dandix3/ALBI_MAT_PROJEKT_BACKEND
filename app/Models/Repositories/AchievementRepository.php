<?php

namespace App\Models\Repositories;

use App\Models\Game;

class AchievementRepository
{
    public function getGameAchievements($gameId)
    {
        $game = Game::find($gameId);
        //        $gameAchievements = $gameAchievements->sortBy('order');
        return $game->achievements;
    }
}
