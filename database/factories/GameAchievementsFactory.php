<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class GameAchievementsFactory extends Factory
{

    protected $model = \App\Models\Achievement::class;

    public function definition()
    {
        return [
            'game_id' => $this->faker->numberBetween(1, 100),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
            'max_points' => $this->faker->numberBetween(1, 100),
        ];
    }
}
