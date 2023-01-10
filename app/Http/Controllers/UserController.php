<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Resources\UserResource;
use App\Models\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    const ENDPOINT = "users";

    public static function getEndpointUrl(): string {
        return self::ENDPOINT;
    }

    protected UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function user(): JsonResponse
    {
        $user = $this->userService->getUser();
        return response()->json([
            'status' => true,
            'message' => 'User Details',
            'data' => $user,
        ]);
    }

    public function users(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json([
            'status' => true,
            'message' => 'User Details',
            'data' => UserResource::collection($users)
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function findUserByNickname(string $nickname): JsonResponse
    {
        $user = $this->userService->findUserByNickname($nickname);
        return response()->json([
            'status' => true,
            'message' => 'User Details',
            'data' => $user
        ]);
    }

    public function getUser($id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        return response()->json([
            'status' => true,
            'message' => 'User Details',
            'data' => UserResource::make($user)
        ]);
    }
}
