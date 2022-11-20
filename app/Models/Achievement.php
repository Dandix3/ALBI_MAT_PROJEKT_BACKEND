<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Achievement
 * @package App\Models
 * @property int $ksp
 * @property string $name
 * @property int $EAN
 * @property string $klp
 * @property \DateTime $release_date
 * @property string $cap
 * @property \Illuminate\Database\Eloquent\Collection $games
 *
 */
class Achievement extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'game_id',
        'title',
        'description',
        'min_points',
        'max_points',
        'prev_achievement',
        'next_achievement',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function userAchievement()
    {
        return $this->hasOne(UserAchievement::class);
    }

    public function nextAchievement()
    {
        return $this->hasOne(Achievement::class, 'id', 'next_achievement');
    }

}
