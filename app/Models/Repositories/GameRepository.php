<?php

namespace App\Models\Repositories;

use App\Models\Game;

class GameRepository
{
    /**
     * @param int $ean
     * @return Game
     */
    public function getGameByEAN(int $ean): Game
    {
        return Game::where('EAN', $ean)->first();
    }
}
