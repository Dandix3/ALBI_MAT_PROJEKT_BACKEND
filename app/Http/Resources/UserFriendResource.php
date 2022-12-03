<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserFriendResource extends JsonResource
{
    /**
     * Transform the resource into an array
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'friend_id' => $this->friend_id,
            'friend' => new UserResource($this->whenLoaded('friend')),
            'accepted' => $this->accepted,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
