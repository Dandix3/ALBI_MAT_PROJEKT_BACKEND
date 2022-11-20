<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\GetGameRequest;
use App\Http\Resources\AchievementResource;
use App\Http\Resources\GameResource;
use App\Models\Services\AchievementService;
use Illuminate\Http\JsonResponse;

class AchievementController extends Controller
{
    const ENDPOINT = "game-achievements";

    public static function getEndpointUrl(): string {
        return self::ENDPOINT;
    }

    protected AchievementService $gameAchievementsService;

    public function __construct()
    {
        $this->gameAchievementsService = new AchievementService();
    }

    /**
     * @throws NotFoundException
     */
    public function getGameAchievements(int $id): JsonResponse
    {
        $gameAchievements = $this->gameAchievementsService->getGameAchievements($id);

        return response()->json([
            'status' => true,
            'message' => 'Game Achievements',
            'data' => AchievementResource::collection($gameAchievements)
        ]);
    }
}
