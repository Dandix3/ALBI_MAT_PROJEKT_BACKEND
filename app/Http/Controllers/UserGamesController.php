<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Services\UserGamesService;
use Illuminate\Http\JsonResponse;

class UserGamesController extends Controller
{
    const ENDPOINT = "userGames";

    public static function getEndpointUrl(): string {
        return self::ENDPOINT;
    }

    protected UserGamesService $userGamesService;

    public function __construct()
    {
        $this->userGamesService = new UserGamesService();
    }

    /**
     * @return JsonResponse
     */
    public function getUsersGames(): JsonResponse
    {
        $games = $this->userGamesService->getUsersGames();

        return response()->json([
            'status' => true,
            'message' => 'User Games',
            'data' => GameResource::collection($games)
        ]);
    }
}
