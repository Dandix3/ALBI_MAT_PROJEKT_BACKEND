<?php

namespace App\Models\Repositories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

class GameRepository
{
    /**
     * @param int $ean
     * @return Game
     */
    public function getGameByEAN(int $ean): Collection
    {
        return Game::where('EAN', $ean)->get();
    }

    public function getGameByKSP($ksp): Game
    {
        return Game::where('KSP', $ksp)->first();
    }
}
