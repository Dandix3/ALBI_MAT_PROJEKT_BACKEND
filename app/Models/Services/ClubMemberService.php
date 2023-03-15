<?php

namespace App\Models\Services;

use App\Exceptions\ModelDuplicateFoundException;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\NotFoundException;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Repositories\ClubRepository;
use App\Models\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ClubMemberService
{
    protected ClubRepository $clubRepository;
    protected UserRepository $userRepository;
    public function __construct(
    ) {
        $this->clubRepository = new ClubRepository();
        $this->userRepository = new UserRepository();
    }

    public function getClubMembers(int $clubId): Collection
    {
        $club = $this->clubRepository->getClub($clubId)->first();
        if (!$club) {
            throw new NotFoundException('Club not found');
        }
        $members = $club->members()->get();
        return $members;
    }

    public function addMembers(int $clubId, array $members): Model
    {
        $club = $this->clubRepository->getClub($clubId)->first();
        if (!$club) {
            throw new NotFoundException('Club not found');
        }
        foreach ($members as $member) {
            $user = $this->userRepository->getUserById($member);
            if (!$user) {
                throw new NotFoundException('User not found');
            }
            $newMember = new ClubMember();
            $newMember->club_id = $clubId;
            $newMember->user_id = $member;
            $newMember->setMemberRole();
            $newMember->save();
        }

        return $club;
    }

    public function joinClub(int $clubId): ClubMember
    {
        $club = $this->clubRepository->getClub($clubId)->first();
        if (!$club) {
            throw new NotFoundException('Club not found');
        }

        $isMember = ClubMember::where('club_id', $clubId)->where('user_id', Auth::user()->id)->first();
        if ($isMember) {
            throw new ModelDuplicateFoundException('Už jsi členem klubu');
        }

        $user = Auth::user();

        $newMember = new ClubMember();
        $newMember->club_id = $clubId;
        $newMember->user_id = $user->id;
        $newMember->role = 0;
        $newMember->save();

        return $newMember;
    }

    public function addOwner(int $clubId, int $userId): ClubMember
    {
        $newMember = new ClubMember();
        $newMember->club_id = $clubId;
        $newMember->user_id = $userId;
        $newMember->setOwner();
        $newMember->save();

        return $newMember;
    }

    public function leaveClub(int $clubId): void
    {
        $club = $this->clubRepository->getClub($clubId)->first();
        if (!$club) {
            throw new NotFoundException('Club not found');
        }
        $user = Auth::user();

        $member = ClubMember::where('club_id', $clubId)->where('user_id', $user->id)->first();
        if (!$member) {
            throw new NotFoundException('Member not found');
        }

        if ($member->isOwner()) {
            throw new ModelDuplicateFoundException('Nemůžeš opustit klub, který jsi založil');
        }

        $member->delete();
    }

    public function removeMember(int $id): void
    {
        $member = ClubMember::where('id', $id)->first();
        if (!$member) {
            throw new NotFoundException('Member not found');
        }

        $member->delete();
    }

    public function promoteMember(int $clubId, int $userId): ClubMember
    {
        $club = $this->clubRepository->getClub($clubId)->first();
        if (!$club) {
            throw new NotFoundException('Club not found');
        }
        $user = $this->userRepository->getUserById($userId)->first();
        if (!$user) {
            throw new NotFoundException('User not found');
        }

        $member = ClubMember::where('club_id', $clubId)->where('user_id', $userId)->first();
        if (!$member) {
            throw new NotFoundException('Member not found');
        }

        $member->setAdmin();
        $member->save();

        return $member;
    }

    public function demoteMember(int $clubId, int $userId): ClubMember
    {
        $club = $this->clubRepository->getClub($clubId)->first();
        if (!$club) {
            throw new NotFoundException('Club not found');
        }
        $user = $this->userRepository->getUserById($userId)->first();
        if (!$user) {
            throw new NotFoundException('User not found');
        }

        $member = ClubMember::where('club_id', $clubId)->where('user_id', $userId)->first();
        if (!$member) {
            throw new NotFoundException('Member not found');
        }

        $member->setMember(); //member
        $member->save();

        return $member;
    }

    /**
     * @throws NotFoundException
     */
    public function acceptMember(int $id): ClubMember
    {
        $member = ClubMember::where('id', $id)->first();
        if (!$member) {
            throw new NotFoundException('Member not found');
        }

        $member->setMemberRole();
        $member->save();

        return $member;
    }

    /**
     * @throws NotFoundException
     */
    public function rejectMember(int $id): void
    {
        $member = ClubMember::where('id', $id)->first();
        if (!$member) {
            throw new NotFoundException('Member not found');
        }

        $member->delete();
    }
}
