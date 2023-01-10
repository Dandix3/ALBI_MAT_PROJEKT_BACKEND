<?php

namespace App\Models\Services;

use App\Exceptions\ModelNotFoundException;
use App\Models\Repositories\UserFriendRepository;
use App\Models\UserFriend;
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
    public function addFriend(int $friendId): Collection|null
    {
        $userFriend = new UserFriend();
        $userFriend->user_id = Auth::user()->id;
        $userFriend->friend_id = $friendId;
        $userFriend->save();

        //return $this->userFriendRepository->getFriends(Auth::user()->id)->with(['user', 'friend'])->get();
        return null;
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function removeFriend(int $id): Collection|null
    {
        $friend = $this->userFriendRepository->getFriendById($id);
        if ($friend === null) {
            throw new ModelNotFoundException();
        }

        $friend->delete();
        //return $this->userFriendRepository->getFriends(Auth::user()->id)->with(['user', 'friend'])->get();
        return null;
    }

    /**
     * @return Collection
     */
    public function getFriends(): Collection
    {
        return $this->userFriendRepository->getFriends(Auth::user()->id, true)->with(['user', 'friend'])->get();
    }

    /**
     * @return Collection
     */
    public function getFriendRequests(): Collection
    {
        return $this->userFriendRepository->getFriendRequests(Auth::user()->id)->with(['user', 'friend'])->get();
    }

    /**
     * @return Collection
     */
    public function getPendingFriendRequests(): Collection
    {
        return $this->userFriendRepository->getFriends(Auth::user()->id, false, true)->with(['user', 'friend'])->get();
    }

    /**
     * @param int $friendId
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function acceptFriendRequest(int $id): Collection|null
    {
        $friendRequest = $this->userFriendRepository->getFriendById($id);
        if ($friendRequest === null) {
            throw new ModelNotFoundException("Žádost o přátelství nebyla nalezena.");
        }

        $friendRequest->accepted = true;
        $friendRequest->save();
        //return $this->userFriendRepository->getFriendRequests(Auth::user()->id)->with(['user', 'friend'])->get();
        return null;
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function declineFriendRequest(int $id): Collection|null
    {
        $friendRequest = $this->userFriendRepository->getFriendById($id);
        if (!$friendRequest) {
            throw new ModelNotFoundException("Odmítnutí Žádosti, žádost o přátelství nebyla nalezena.");
        }
        $friendRequest->delete();
        //return $this->userFriendRepository->getFriendRequests(Auth::user()->id)->with(['user', 'friend'])->get();
        return null;
    }
}
