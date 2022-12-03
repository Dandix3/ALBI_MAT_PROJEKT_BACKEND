<?php

namespace App\Models\Services;

use App\Exceptions\UserAlreadyHasGameException;
use App\Models\Game;
use App\Models\Repositories\UserAchievementRepository;
use App\Models\Repositories\UserGamesRepository;
use App\Models\UserGames;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserGamesService
{
    protected UserGamesRepository $userGamesRepository;
    protected UserAchievementRepository $userAchievementRepository;

    public function __construct()
    {
        $this->userGamesRepository = new UserGamesRepository();
        $this->userAchievementRepository = new UserAchievementRepository();
    }

    /**
     * @param Game $game
     * @return void
     * @throws Exception
     */
    public function setGameToUser(Game $game): void
    {

        try {
            DB::beginTransaction();
            if ($this->checkGameInUserGames($game)) {
                throw new UserAlreadyHasGameException("Uživatel již hru s ID $game->ksp má.");
            }

            $userGame = new UserGames();
            $userGame->user_id = Auth::user()->id;
            $userGame->game_id = $game->ksp;

            $gamesAchievements = $game->achievements;

            $gamesAchievements->each(function ($achievement) use ($userGame) {
                $this->userAchievementRepository->createUserAchievement($achievement->id);
            });

            $userGame->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return Collection
     */
    public function getUsersGames(): Collection
    {
        return $this->userGamesRepository->getAllGamesFromUser(Auth::user()->id)->with('game')->get();
    }


    protected function checkGameInUserGames(Game $game): bool
    {
        return $this->userGamesRepository->checkGameInUserGames($game);
    }

}
