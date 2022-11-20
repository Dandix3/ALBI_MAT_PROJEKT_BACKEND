<?php

namespace App\Http\Resources;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchievementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'game_id' => $this->game_id,
            'title' => $this->title,
            'description' => $this->description,
            'min_points' => $this->min_points,
            'max_points' => $this->max_points,
            'user_points' => $this->userAchievement->points ?? 0,
            'user_achievement' => $this->userAchievement,
            'next_achievement' => $this->next_achievement,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
