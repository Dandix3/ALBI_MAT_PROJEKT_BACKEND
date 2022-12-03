<?php

namespace App\Models\Repositories;

use App\Models\UserFriend;
use PhpParser\Builder;

class UserFriendRepository
{
    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function addFriend(int $userId, int $friendId): bool
    {
        $userFriend = new UserFriend();
        $userFriend->user_id = $userId;
        $userFriend->friend_id = $friendId;
        $userFriend->save();
        return true;
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function removeFriend(int $userId, int $friendId): bool
    {
        $userFriend = UserFriend::where('user_id', $userId)->where('friend_id', $friendId)->first();
        $userFriend->delete();
        return true;
    }

    /**
     * @param int $userId
     * @return UserFriend|Builder
     */
    public function getFriends(int $userId): UserFriend|Builder
    {
        return UserFriend::where('user_id', $userId);
    }

    /**
     * @param int $userId
     * @return UserFriend|Builder
     */
    public function getFriendRequests(int $userId): UserFriend|Builder
    {
        return UserFriend::where('friend_id', $userId);
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function acceptFriendRequest(int $userId, int $friendId): bool
    {
        $userFriend = UserFriend::where('user_id', $friendId)->where('friend_id', $userId)->first();
        $userFriend->accepted = true;
        $userFriend->save();
        return true;
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function declineFriendRequest(int $userId, int $friendId): bool
    {
        $userFriend = UserFriend::where('user id', $friendId)->where('friend_id', $userId)->first();
        $userFriend->delete();
        return true;
    }
}
