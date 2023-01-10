<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class UserFriend
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $friend_to_check
 * @method static \Illuminate\Database\Eloquent\Builder|AchievementAction whereFriendToCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AchievementAction whereUserAchievementId($value)
 */
class AchievementAction extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'friend_to_check',
        'user_achievement_id',
        'prev_state',
        'new_state',
    ];

    protected $table = 'achievements_actions';


    /**
     * Uživatel co poslal žádost o check
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function friend(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_to_check');
    }

    public function achievement(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            Achievement::class,
            UserAchievement::class,
            'id',
            'id',
            'user_achievement_id',
            'achievement_id'
        );
    }

}
