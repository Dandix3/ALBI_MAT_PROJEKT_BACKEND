<?php

namespace App\Models\Repositories;

use App\Models\Game;

class GameRepository
{
    public function getGameByEAN($ean)
    {
        return Game::where('EAN', $ean)->first();
    }
}
