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
 * @property int $friend_id
 * @property bool $accepted
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend whereAccepted($value)
 */
class UserFriend extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'friend_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    protected $timestamp = true;

    protected $table = 'user_friends';



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function friend(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_id', 'id');
    }
}
