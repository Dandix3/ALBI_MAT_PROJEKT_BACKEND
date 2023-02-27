<?php

namespace App\Models\Repositories;

use App\Models\Club;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ClubRepository
{
    /**
     * @param int $id
     * @return Collection|Model
     */
    public function getClub(int $id): Collection|Model
    {
        return Club::query()->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<Club>
     */
    public function all(): Collection
    {
        return Club::query()->get();
    }


    /**
     * Get the nearest clubs
     * @param float $lat
     * @param float $lng
     * @param int $limit
     * @param int $radius
     * @return Collection
     */
    public function getNearestClubs(float $lat, float $lng, int $limit = 10, int $radius = 1000): Collection
    {
        return Club::query()
            ->selectRaw('*, ( 6371 * acos( cos( radians(?) ) *
            cos( radians( lat ) )
            * cos( radians( lng ) - radians(?)
            ) + sin( radians(?) ) *
            sin( radians( lat ) ) )
            ) AS distance', [$lat, $lng, $lat])
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->limit($limit)
            ->get();
    }
}
