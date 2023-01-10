<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserFriendResource extends JsonResource
{
    /**
     * Transform the resource into an array
     * @return array
     */
    public function toArray($request)
    {
        if ($this->user_id == Auth::user()->id) {
            $user = $this->whenLoaded('user');
            $user_id = $this->user_id;
            $friend = $this->whenLoaded('friend');
            $friend_id = $this->friend_id;
        } else {
            $user = $this->whenLoaded('friend');
            $user_id = $this->friend_id;
            $friend = $this->whenLoaded('user');
            $friend_id = $this->user_id;
        }
        return [
            'id' => $this->id,
            'user_id' => $user_id,
            'user' => UserResource::make($user),
            'friend_id' => $friend_id,
            'friend' => UserResource::make($friend),
            'accepted' => $this->accepted,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
