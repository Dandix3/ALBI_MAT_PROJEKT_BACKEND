<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Services\UserFriendService;
use App\Models\Services\UserService;
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

    public function friends(): JsonResponse
    {
        $friends = $this->userFriendService->getFriends();
        return response()->json([
            'status' => true,
            'message' => 'Přátelé uživatele.',
            'data' => UserResource::collection($friends)
        ]);
    }

    public function friendRequests(): JsonResponse
    {
        $friendRequests = $this->userFriendService->getFriendRequests();
        return response()->json([
            'status' => true,
            'message' => 'Žádosti o přátelství uživatelů.',
            'data' => UserResource::collection($friendRequests)
        ]);
    }

    public function addFriend(int $friendId): JsonResponse
    {
        $success = $this->userFriendService->addFriend($friendId);
        return response()->json([
            'status' => $success,
            'message' => $success ? 'Žádost o přátelství odeslána.' : 'Žádost o přátelství se nezdařila.',
        ]);
    }

    public function removeFriend(int $friendId): JsonResponse
    {
        $success = $this->userFriendService->removeFriend($friendId);
        return response()->json([
            'status' => $success,
                'message' => $success ? 'Přítel odebrán.' : 'Odebrání přítele se nezdařilo.',
        ]);
    }

    public function acceptFriend(int $friendId): JsonResponse
    {
        $success = $this->userFriendService->acceptFriendRequest($friendId);
        return response()->json([
            'status' => $success,
                'message' => $success ? 'Žádost o přátelství přijata.' : 'Přijetí žádosti o přátelství se nezdařilo.',
        ]);
    }

    public function rejectFriend(int $friendId): JsonResponse
    {
        $success = $this->userFriendService->rejectFriendRequest($friendId);
        return response()->json([
            'status' => $success,
            'message' => $success ? 'Žádost o přátelství zamítnuta.' : 'Odmítnutí žádosti o přátelství se nezdařilo.',
        ]);
    }
}
