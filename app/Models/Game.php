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
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereKsp($value)
 */
class Game extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ksp',
        'name',
        'EAN',
        'klp',
        'release_date',
        'cap',
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
        'release_date' => 'datetime',
    ];
    protected $table = 'games';
    protected $primaryKey = 'ksp';

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'game_id', 'ksp');
    }

}
