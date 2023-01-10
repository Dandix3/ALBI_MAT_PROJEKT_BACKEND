<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\GetGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class GameController extends Controller
{
    const ENDPOINT = "games";

    public static function getEndpointUrl(): string {
        return self::ENDPOINT;
    }

    protected GameService $gameService;

    public function __construct()
    {
        $this->gameService = new GameService();
    }


    /**
     * @throws NotFoundException
     */
    public function scanGame(GetGameRequest $request): JsonResponse
    {
        $game = $this->gameService->scannedGame($request->scan);
        return response()->json([
            'status' => true,
            'message' => 'Game Details',
            'data' => new GameResource($game)
        ]);
    }

    public function addGame($ksp): JsonResponse
    {
        $game = $this->gameService->addGame($ksp);
        return response()->json([
            'status' => true,
            'message' => 'Hra přidána',
            'data' => GameResource::make($game),
        ]);
    }
}
