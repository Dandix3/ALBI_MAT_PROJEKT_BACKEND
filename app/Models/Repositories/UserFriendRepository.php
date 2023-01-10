<?php

namespace App\Models\Repositories;

use App\Exceptions\NotFoundException;
use App\Models\UserFriend;
use Illuminate\Database\Eloquent\Builder;

class UserFriendRepository
{

    public function getFriendRequest(int $userId, int $friendId): UserFriend|null
    {
        try {
            return UserFriend::where('user_id', $userId)
                ->where('friend_id', $friendId)
                ->firstOrFail();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getFriendById(int $id): ?UserFriend
    {
        return UserFriend::find($id) ?? null;
    }

    /**
     * @param int $userId
     * @param bool $accepted
     * @return UserFriend|Builder
     */
    public function getFriends(int $userId, bool $accepted, bool $myFriends = false): UserFriend|Builder
    {
        if ($myFriends) {
            return UserFriend::where('user_id', $userId)
                ->where('accepted', $accepted);
        } else {
            return UserFriend::whereAccepted($accepted)->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('friend_id', $userId);
            });
        }
    }


    /**
     * @param int $userId
     * @return UserFriend|Builder
     */
    public function getFriendRequests(int $userId): UserFriend|Builder
    {
        return UserFriend::whereFriendId($userId)->whereAccepted(false);
    }
}
