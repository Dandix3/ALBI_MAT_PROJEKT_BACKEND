<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFoundException;
use App\Http\Resources\AchievementActionResource;
use App\Http\Resources\AchievementResource;
use App\Models\AchievementAction;
use App\Models\Services\AchievementActionService;
use Illuminate\Http\JsonResponse;

class AchievementActionController extends Controller
{
    const ENDPOINT = "achievement-actions";

    public static function getEndpointUrl(): string {
        return self::ENDPOINT;
    }

    protected AchievementActionService $achievementActionService;

    public function __construct()
    {
        $this->achievementActionService = new AchievementActionService();
    }

    /**
     * @return JsonResponse
     */
    public function getAchievementActions(): JsonResponse
    {
        $achievementActions = $this->achievementActionService->getAchievementActionsForUser();
        return response()->json(
            [
                "status" => true,
                "message" => "Úspěchy byly úspěšně načteny.",
                'data' => AchievementActionResource::collection($achievementActions),
            ]
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function ackUserAchievement(int $id): JsonResponse
    {
        $this->achievementActionService->acknowledgeAchievementAction($id);
        return response()->json(
            [
                "status" => true,
                "message" => "Achievement action acknowledged.",
                "data" => AchievementActionResource::collection($this->achievementActionService->getAchievementActionsForUser()),
            ]
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function rejectUserAchievement(int $id): JsonResponse
    {
        $this->achievementActionService->rejectAchievementAction($id);
        return response()->json(
            [
                "status" => true,
                "message" => "Achievement action rejected.",
                "data" => AchievementActionResource::collection($this->achievementActionService->getAchievementActionsForUser()),
            ]
        );
    }
}
