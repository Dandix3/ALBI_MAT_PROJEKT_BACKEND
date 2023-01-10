<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFoundException;
use App\Http\Resources\UserFriendResource;
use App\Models\Services\UserFriendService;
use Illuminate\Http\JsonResponse;

class UserFriendController extends Controller
{
    const ENDPOINT = "user-friends";

    public static function getEndpointUrl(): string {
        return self::ENDPOINT;
    }

    protected UserFriendService $userFriendService;

    public function __construct()
    {
        $this->userFriendService = new UserFriendService();
    }

    public function getFriends(): JsonResponse
    {
        $friends = $this->userFriendService->getFriends();
        return response()->json([
            'status' => true,
            'message' => 'Přátelé uživatele.',
            'data' => [
                'friends' => UserFriendResource::collection($this->userFriendService->getFriends()),
                'friendRequests' => UserFriendResource::collection($this->userFriendService->getFriendRequests()),
                'pendingFriendRequests' => UserFriendResource::collection($this->userFriendService->getPendingFriendRequests())
            ]
        ]);
    }

    public function getFriendRequests(): JsonResponse
    {
        $friendRequests = $this->userFriendService->getFriendRequests();
        return response()->json([
            'status' => true,
            'message' => 'Žádosti o přátelství uživatelů.',
            'data' => [
                'friends' => UserFriendResource::collection($this->userFriendService->getFriends()),
                'friendRequests' => UserFriendResource::collection($this->userFriendService->getFriendRequests()),
                'pendingFriendRequests' => UserFriendResource::collection($this->userFriendService->getPendingFriendRequests())
            ]
        ]);
    }

    public function addFriend(int $friendId): JsonResponse
    {
        $friends = $this->userFriendService->addFriend($friendId);
        return response()->json([
            'status' => true,
            'message' => 'Žádost o přátelství byla odeslána.',
            'data' => [
                'friends' => UserFriendResource::collection($this->userFriendService->getFriends()),
                'friendRequests' => UserFriendResource::collection($this->userFriendService->getFriendRequests()),
                'pendingFriendRequests' => UserFriendResource::collection($this->userFriendService->getPendingFriendRequests())
            ]
        ]);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function removeFriend(int $id): JsonResponse
    {
        $friends = $this->userFriendService->removeFriend($id);
        return response()->json([
            'status' => true,
            'message' => 'Přítel odebrán.',
            'data' => [
                'friends' => UserFriendResource::collection($this->userFriendService->getFriends()),
                'friendRequests' => UserFriendResource::collection($this->userFriendService->getFriendRequests()),
                'pendingFriendRequests' => UserFriendResource::collection($this->userFriendService->getPendingFriendRequests())
            ]
        ]);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function acceptFriendRequest(int $friendId): JsonResponse
    {
        $friends = $this->userFriendService->acceptFriendRequest($friendId);
        return response()->json([
            'status' => true,
            'message' => 'Žádost o přátelství byla přijata.',
            'data' => [
                'friends' => UserFriendResource::collection($this->userFriendService->getFriends()),
                'friendRequests' => UserFriendResource::collection($this->userFriendService->getFriendRequests()),
                'pendingFriendRequests' => UserFriendResource::collection($this->userFriendService->getPendingFriendRequests())
            ]
        ]);
    }

    public function declineFriendRequest(int $friendId): JsonResponse
    {
        $friends = $this->userFriendService->declineFriendRequest($friendId);
        return response()->json([
            'status' => true,
            'message' => 'Žádost o přátelství byla zamítnuta.',
            'data' => [
                'friends' => UserFriendResource::collection($this->userFriendService->getFriends()),
                'friendRequests' => UserFriendResource::collection($this->userFriendService->getFriendRequests()),
                'pendingFriendRequests' => UserFriendResource::collection($this->userFriendService->getPendingFriendRequests())
            ]
        ]);
    }
}
