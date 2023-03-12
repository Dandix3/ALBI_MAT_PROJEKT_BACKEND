<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Club
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string $postal_code
 * @property string $country
 * @property int $owner_id
 * @property string $members
 * @property string $description
 * @property $location
 * @property string $created_at
 * @property string $updated_at
 * @property User $owner
 */
class Club extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'postal_code',
        'country',
        'owner_id',
        'members',
        'description',
        'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    protected $table = 'clubs';
    protected $timestamp = true;

    public function owner(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function members(): HasManyThrough
    {
        return $this->hasManyThrough(
            'App\Models\User',
            'App\Models\ClubMember',
            'club_id',
            'id',
            'id',
            'user_id'
        );
    }

}
