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
    protected ClubMemberService $clubMemberService;

    public function __construct()
    {
        $this->clubRepository = new ClubRepository();
        $this->clubMemberService = new ClubMemberService();
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
     * @param float $lat
     * @param float $lng
     * @param int $radius
     * @return Collection
     */
    public function getNearestClubs(float $lat, float $lng, int $radius, int $limit): Collection
    {
        return $this->clubRepository->getNearestClubs($lat, $lng, $radius, $limit)->with(['owner', 'members'])->get();
    }

    /**
     * @throws ValidationException
     */
    public function createClub(array $data): Club
    {
        $club = new Club();
        $club->name = $data['name'];
        $club->description = $data['description'];
        $club->address = $data['address'];
        $club->city = $data['city'];
        $club->country = $data['country'] ?? null;
        $club->postal_code = $data['postal_code'];
        $club->lat = $data['lat'];
        $club->lng = $data['lng'];
        $club->owner_id = Auth::user()->id;
        $club->save();

        $this->clubMemberService->addOwner($club->id, Auth::user()->id);

        return $club;
    }

    /**
     * @throws NotFoundException
     */
    public function updateClub(int $id, array $data): Model
    {
        $club = $this->getClub($id);
        $club->name = $data['name'] ?? $club->name;
        $club->description = $data['description'] ?? $club->description;
        $club->address = $data['address'] ?? $club->address;
        $club->city = $data['city'] ?? $club->city;
        $club->country = $data['country'] ?? $club->country;
        $club->postal_code = $data['postal_code'] ?? $club->postal_code;
        $club->lat = $data['lat'] ?? $club->lat;
        $club->lng = $data['lng'] ?? $club->lng;
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
