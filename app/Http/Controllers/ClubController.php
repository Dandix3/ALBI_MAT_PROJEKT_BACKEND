<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\CreateClubRequest;
use App\Http\Resources\ClubResource;
use App\Http\Resources\UserResource;
use App\Models\ClubMember;
use App\Models\Services\ClubService;
use App\Models\Services\UserService;
use Illuminate\Http\JsonResponse;

class ClubController extends Controller
{
    const ENDPOINT = "clubs";

    public static function getEndpointUrl(): string {
        return self::ENDPOINT;
    }

    protected ClubService $clubService;

    public function __construct()
    {
        $this->clubService = new ClubService();
    }

    public function getClub(int $id): JsonResponse
    {
        $club = $this->clubService->getClub($id);
        return response()->json([
            'status' => true,
            'message' => 'Club',
            'data' => ClubResource::make($club),
        ]);
    }

    public function getAllClubs(): JsonResponse
    {
        $clubs = $this->clubService->getAll();
        return response()->json([
            'status' => true,
            'message' => 'Clubs',
            'data' => ClubResource::collection($clubs),
        ]);
    }

    public function getNearestClubs(float $lat, float $lng): JsonResponse
    {
        $clubs = $this->clubService->getNearestClubs($lat, $lng);
        return response()->json([
            'status' => true,
            'message' => 'Nearest Clubs',
            'data' => ClubResource::collection($clubs),
        ]);
    }

    public function createClub(CreateClubRequest $request): JsonResponse
    {
        $data = $request->validated();

        $club = $this->clubService->createClub($data);
        return response()->json([
            'status' => true,
            'message' => 'Club created',
            'data' => ClubResource::make($club),
        ]);
    }
}
