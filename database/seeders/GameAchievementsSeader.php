<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameAchievementsSeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::all()->each(function ($game) {
//            $ach = Achievement::create([
//                'game_id' => $game->ksp,
//                'title' => 'Počet odehraných her',
//                'description' => 'Počet odehraných her',
//                'max_points' => 10,
//            ]);
//            $ach2 = Achievement::create([
//                'game_id' => $game->ksp,
//                'title' => 'Počet odehraných her',
//                'description' => 'Počet odehraných her',
//                'min_points' => 10,
//                'max_points' => 30,
//            ]);
//            $ach->next_achievement = $ach2->id;
//            $ach->save();

            $ach = Achievement::create([
                'game_id' => $game->ksp,
                'title' => 'Počet vyhraných her',
                'description' => 'Počet vyhraných her',
                'max_points' => 10,
            ]);

            $ach = Achievement::create([
                'game_id' => $game->ksp,
                'title' => 'Získej všechny karty',
                'description' => 'Získej všechny karty - SPECIAL',
                'max_points' => 1,
            ]);
        });
    }
}
