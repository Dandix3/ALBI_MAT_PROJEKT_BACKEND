<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Game
 * @package App\Models
 * @property int $ksp
 * @property string $name
 * @property int $EAN
 * @property string $klp
 * @property \DateTime $release_date
 * @property string $cap
 * @property \Illuminate\Database\Eloquent\Collection $games
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUserId($value)
 */
class UserGames extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'game_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
    protected $table = 'users_games';
    protected $primaryKey = 'id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function userAchievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class, 'user_id', 'user_id');
    }

    public function achievements(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Achievement::class, UserAchievement::class, 'user_id', 'id', 'user_id', 'achievement_id');
    }
}
