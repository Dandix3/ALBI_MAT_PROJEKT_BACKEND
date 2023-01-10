<?php

namespace App\Models\Services;

use App\Exceptions\ModelNotFoundException;
use App\Models\AchievementAction;
use App\Models\Repositories\AchievementActionRepository;
use App\Models\Repositories\UserAchievementRepository;
use App\Models\Repositories\UserFriendRepository;
use App\Models\UserFriend;
use http\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class AchievementActionService
{
    protected AchievementActionRepository $achievementActionRepository;
    protected UserAchievementRepository $userAchievementRepository;

    public function __construct()
    {
        $this->achievementActionRepository = new AchievementActionRepository();
        $this->userAchievementRepository = new UserAchievementRepository();
    }

    public function getAchievementActionsForUser(): array|Collection
    {
        return $this->achievementActionRepository->getAchievementActionsForUser(Auth::user()->id)->with(['achievement', 'user'])->get();
    }

    public function createAchievementAction(int $friendId, int $achievementId, int $prevState, int $newState): AchievementAction
    {
        $achievementAction = new AchievementAction();
        $achievementAction->user_id = Auth::user()->id;
        $achievementAction->friend_to_check = $friendId;
        $achievementAction->user_achievement_id = $achievementId;
        $achievementAction->prev_state = $prevState;
        $achievementAction->new_state = $newState;
        $achievementAction->save();

        return $achievementAction;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function acknowledgeAchievementAction(int $achievementActionId): bool
    {
        $achievementAction = $this->achievementActionRepository->getAchievementActionById($achievementActionId);
        if ($achievementAction === null) {
            throw new ModelNotFoundException('Achievement action not found');
        }

        $userAchievement = $this->userAchievementRepository->getUserAchievement($achievementAction->user_achievement_id);
        $userAchievement->setAcceptedStatus();

        if ($userAchievement->achievement()->first()->max_points === $userAchievement->points) {
            $userAchievement->setCompletedStatus();
            throw new ModelNotFoundException('Našel jsem to');
        }


        $achievementAction->delete();

        return true;
    }

    public function rejectAchievementAction(int $achievementActionId): bool
    {
        $achievementAction = $this->achievementActionRepository->getAchievementActionById($achievementActionId);
        if ($achievementAction === null) {
            throw new ModelNotFoundException('Achievement action not found');
        }

        $userAchievement = $this->userAchievementRepository->getUserAchievement($achievementAction->user_achievement_id);
        $userAchievement->setRejectedStatus();
        $userAchievement->points = $achievementAction->prev_state;
        $userAchievement->save();

        $achievementAction->delete();

        return true;
    }
}
