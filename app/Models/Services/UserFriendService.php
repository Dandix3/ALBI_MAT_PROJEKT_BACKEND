<?php

namespace App\Models\Services;

use App\Models\Repositories\UserFriendRepository;
use App\Models\UserFriend;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class UserFriendService
{
    protected UserFriendRepository $userFriendRepository;

    public function __construct()
    {
        $this->userFriendRepository = new UserFriendRepository();
    }

    /**
     * @param int $friendId
     * @return bool
     */
    public function addFriend(int $friendId): bool
    {
        return $this->userFriendRepository->addFriend(Auth::user()->id, $friendId);
    }

    /**
     * @param int $friendId
     * @return bool
     */
    public function removeFriend(int $friendId): bool
    {
        return $this->userFriendRepository->removeFriend(Auth::user()->id, $friendId);
    }

    /**
     * @return Collection
     */
    public function getFriends(): Collection
    {
        return $this->userFriendRepository->getFriends(Auth::user()->id)->with('friend')->get();
    }

    /**
     * @return Collection
     */
    public function getFriendRequests(): Collection
    {
        return $this->userFriendRepository->getFriendRequests(Auth::user()->id)->with('user')->get();
    }

    /**
     * @param int $friendId
     * @return bool
     */
    public function acceptFriendRequest(int $friendId): bool
    {
        return $this->userFriendRepository->acceptFriendRequest(Auth::user()->id, $friendId);
    }

    /**
     * @param int $friendId
     * @return bool
     */
    public function rejectFriendRequest(int $friendId): bool
    {
        return $this->userFriendRepository->declineFriendRequest(Auth::user()->id, $friendId);
    }
}
