<?php

namespace App\Http\Resources;

use App\Models\UserAchievement;
use Illuminate\Http\Resources\Json\JsonResource;

class AchievementActionResource extends JsonResource
{
    /**
     * Transform the resource into an array
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_achievement_id" => $this->user_achievement_id,
            "achievement" => AchievementResource::make($this->whenLoaded('achievement')),
            "friend_to_check" => $this->friend_to_check,
            "friend" => UserResource::make($this->whenLoaded('user')),
            "prev_state" => $this->prev_state,
            "new_state" => $this->new_state,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
