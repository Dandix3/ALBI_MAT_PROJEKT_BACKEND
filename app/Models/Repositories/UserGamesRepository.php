<?php

namespace App\Models\Repositories;

use App\Models\Game;
use App\Models\UserGames;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserGamesRepository
{
    /**
     * @param int $userId
     * @return Builder|Game
     */
    public function getAllGamesFromUser(int $userId): Game|Builder
    {
        return UserGames::whereUserId($userId);
    }

    /**
     * @param Game $game
     * @return bool
     */
    public function checkGameInUserGames(Game $game): bool
    {
        $userGame = UserGames::whereUserId(Auth::user()->id)->whereGameId($game->ksp)->first();
        if ($userGame) {
            return true;
        }
        return false;
    }
}
