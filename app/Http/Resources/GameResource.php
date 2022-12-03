<?php

namespace App\Http\Resources;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'ksp' => $this->ksp ?? $this->game->ksp,
            'name' => $this->name ?? $this->game->name,
            'EAN' => $this->EAN ?? $this->game->EAN,
            'release_date' => $this->release_date ?? $this->game->release_date,
            'klp' => $this->klp ?? $this->game->klp,
            'cap' => $this->cap ?? $this->game->cap,
            'achievements' => AchievementResource::collection($this->game->achievements ?? $this->achievements),
        ];
    }
}
