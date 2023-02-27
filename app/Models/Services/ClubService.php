<?php

namespace App\Models\Services;

use App\Exceptions\NotFoundException;
use App\Models\Club;
use App\Models\Repositories\ClubRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Nette\Schema\ValidationException;

class ClubService
{
    protected ClubRepository $clubRepository;

    public function __construct()
    {
        $this->clubRepository = new ClubRepository();
    }

    /**
     * @param int $id
     * @return Model
     * @throws NotFoundException
     */
    public function getClub(int $id): Model
    {
        $club = $this->clubRepository->getClub($id)->with(['owner', 'members'])->first();

        if (!$club) {
            throw new NotFoundException('Club not found');
        }
        return $club;
    }

    /**
     * @return Collection<Club>
     */
    public function getAll(): Collection
    {
        return $this->clubRepository->all()->with(['owner', 'members'])->get();
    }

    /**
     * @return Collection<Club>
     */
    public function getNearestClubs(float $lat, float $lng): Collection
    {
        return $this->clubRepository->getNearestClubs($lat, $lng)->with(['owner', 'members'])->get();
    }

    /**
     * @throws ValidationException
     */
    public function createClub(array $data): Club
    {
        $club = new Club();
        $club->name = $data['name'];
        $club->description = $data['description'];
        $club->owner_id = $data['owner_id'];
        $club->save();

        return $club;
    }

    /**
     * @throws NotFoundException
     */
    public function updateClub(int $id, array $data): Model
    {
        $club = $this->getClub($id);
        $club->name = $data['name'];
        $club->description = $data['description'];
        $club->save();

        return $club;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteClub(int $id): void
    {
        $club = $this->getClub($id);
        if ($club->owner_id !== Auth::user()->id) {
            throw new NotFoundException('You are not the owner of this club');
        }
        $club->delete();
    }

}
