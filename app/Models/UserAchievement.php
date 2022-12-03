<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @method static \Illuminate\Database\Eloquent\Builder whereAchievementId($value)
 */
class UserAchievement extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const STATUS_CREATED = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_COMPLETED = 3;

    const STATUS_WAITING_FOR_CHECK = 4;
    const STATUS_CHECKED = 5;
    const STATUS_REJECTED = 6;
    const STATUS_ACCEPTED = 7;

    const STATUSES = [
        self::STATUS_CREATED => 'Vytvořeno',
        self::STATUS_IN_PROGRESS => 'Probíhá',
        self::STATUS_COMPLETED => 'Dokončeno',
        self::STATUS_WAITING_FOR_CHECK => 'Čeká na kontrolu',
        self::STATUS_CHECKED => 'Kontrolováno',
        self::STATUS_REJECTED => 'Zamítnuto',
        self::STATUS_ACCEPTED => 'Přijato',
    ];

    const FINAL_STATUSES = [
        self::STATUS_COMPLETED,
        self::STATUS_REJECTED,
        self::STATUS_ACCEPTED,
    ];

    const IN_PROGRESS_STATUSES = [
        self::STATUS_CREATED,
        self::STATUS_IN_PROGRESS,
        self::STATUS_WAITING_FOR_CHECK,
        self::STATUS_CHECKED,
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'achievement_id',
        'points',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    public function isFinalStatus(): bool
    {
        return in_array($this->status, self::FINAL_STATUSES);
    }

    public function setWaitingForCheckStatus(): void
    {
        if ($this->isFinalStatus()) {
            return;
        }
        $this->status_id = self::STATUS_WAITING_FOR_CHECK;
        $this->save();
    }
}
