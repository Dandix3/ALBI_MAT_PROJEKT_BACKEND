<?php

namespace App\Models\Repositories;

use App\Models\Game;
use App\Models\UserGames;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class UserGamesRepository
{
    public function setGameToUser(Game $game): void
    {
        try {
            UserGames::create([
                'user_id' => Auth::user()->id,
                'game_id' => $game->ksp,
            ]);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getGameFromUser(Game $game): void
    {
    }

    public function getAllGamesFromUser()
    {
        return UserGames::whereUserId(Auth::user()->id);
    }

    public function checkGameInUserGames(Game $game): bool
    {
        try {
            $result = UserGames::whereUserId(Auth::user()->id)->whereGameId($game->ksp)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }
        return true;
    }

    public function deleteGameFromUser(Game $game): void
    {
    }

    public function deleteAllGamesFromUser(): void
    {
    }
}
