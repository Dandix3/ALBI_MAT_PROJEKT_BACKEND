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
     * @return Builder
     */
    public function getClub(int $id): Builder
    {
        return Club::query()->where('id', $id);
    }

    /**
     * @return Builder
     */
    public function all(): Builder
    {
        return Club::query();
    }


    /**
     * Get the nearest clubs
     * @param float $lat
     * @param float $lng
     * @param int $limit
     * @param int $radius
     * @return Builder
     */
    public function getNearestClubs(float $lat, float $lng, int $radius = 1000, int $limit = 10): Builder
    {
        //radius je v kilometrech
        return Club::query()
            ->selectRaw('*, ( 6371 * acos( cos( radians(?) ) *
            cos( radians( lat ) )
            * cos( radians( lng ) - radians(?)
            ) + sin( radians(?) ) *
            sin( radians( lat ) ) )
            ) AS distance', [$lat, $lng, $lat])
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->limit($limit);
    }
}
