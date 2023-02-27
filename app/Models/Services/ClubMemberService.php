<?php

namespace App\Models\Services;

use App\Exceptions\NotFoundException;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Repositories\ClubRepository;
use App\Models\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Nette\Schema\ValidationException;

class ClubMemberService
{
    public function __construct(
        protected ClubRepository $clubRepository,
        protected UserRepository $userRepository,
    ) {
    }

    public function addMember(int $clubId, int $userId): ClubMember
    {
        $club = $this->clubRepository->getClub($clubId)->first();
        if (!$club) {
            throw new NotFoundException('Club not found');
        }
        $user = $this->userRepository->getUserById($userId)->first();
        if (!$user) {
            throw new NotFoundException('User not found');
        }

        $newMember = new ClubMember();
        $newMember->club_id = $clubId;
        $newMember->user_id = $userId;
        $newMember->role = 1; //member
        $newMember->save();

        return $newMember;
    }

    public function joinClub(int $clubId): ClubMember
    {
        $club = $this->clubRepository->getClub($clubId)->first();
        if (!$club) {
            throw new NotFoundException('Club not found');
        }
        $user = Auth::user();

        $newMember = new ClubMember();
        $newMember->club_id = $clubId;
        $newMember->user_id = $user->id;
        $newMember->role = 0;
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

        $member->delete();
    }

    public function removeMember(int $clubId, int $userId): void
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

        $member->role = 2; //admin
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

        $member->role = 1; //member
        $member->save();

        return $member;
    }

}
