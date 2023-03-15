<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\club\AddMembersToClubRequest;
use App\Http\Requests\club\CreateClubRequest;
use App\Http\Requests\club\FindNearestClubRequest;
use App\Http\Requests\club\UpdateClubRequest;
use App\Http\Resources\ClubMemberResource;
use App\Http\Resources\ClubResource;
use App\Models\ClubMember;
use App\Models\Services\ClubMemberService;
use App\Models\Services\ClubService;
use Illuminate\Http\JsonResponse;
use function Symfony\Component\Translation\t;

class ClubController extends Controller
{
    const ENDPOINT = "clubs";

    public static function getEndpointUrl(): string {
        return self::ENDPOINT;
    }

    protected ClubService $clubService;
    protected ClubMemberService $clubMemberService;

    public function __construct()
    {
        $this->clubService = new ClubService();
        $this->clubMemberService = new ClubMemberService();
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

    public function getNearestClubs(FindNearestClubRequest $request): JsonResponse
    {
        $data = $request->validated();
        $clubs = $this->clubService->getNearestClubs($data['lat'], $data['lng'], $data['radius'] ?? 1000, $data['limit'] ?? 10);
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

    /**
     * @throws NotFoundException
     */
    public function updateClub(int $id, UpdateClubRequest $request): JsonResponse
    {
        $data = $request->validated();

        $club = $this->clubService->updateClub($id, $data);
        return response()->json([
            'status' => true,
            'message' => 'Club updated',
            'data' => ClubResource::make($club),
        ]);
    }

    public function deleteClub(int $id): JsonResponse
    {
        $this->clubService->deleteClub($id);
        return response()->json([
            'status' => true,
            'message' => 'Club deleted',
        ]);
    }

    /**
     * @throws NotFoundException
     * @throws ModelNotFoundException
     */
    public function joinClub(int $id): JsonResponse
    {
        $this->clubMemberService->joinClub($id);
        return response()->json([
            'status' => true,
            'message' => 'Club joined',
            'data' => ClubMemberResource::collection($this->clubMemberService->getClubMembers($id)),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function leaveClub(int $id): JsonResponse
    {
        $this->clubMemberService->leaveClub($id);
        return response()->json([
            'status' => true,
            'message' => 'Club left',
        ]);
    }

    public function removeMember(int $id, int $memberId): JsonResponse
    {
        $this->clubMemberService->removeMember($id, $memberId);
        return response()->json([
            'status' => true,
            'message' => 'Member removed',
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function addMembers(int $id, AddMembersToClubRequest $request): JsonResponse
    {
        $requestVal = $request->validated();
        $members = json_decode($requestVal['user_ids'], true);
        $this->clubMemberService->addMembers($id, $members);
        return response()->json([
            'status' => true,
            'message' => 'Members added',
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function acceptMember(int $id, int $memberId): JsonResponse
    {
        $this->clubMemberService->acceptMember($id, $memberId);
        return response()->json([
            'status' => true,
            'message' => 'Member accepted',
        ]);
    }

    public function declineMember(int $id, int $memberId): JsonResponse
    {
        $this->clubMemberService->rejectMember($id, $memberId);
        return response()->json([
            'status' => true,
            'message' => 'Member declined',
        ]);
    }
}
