<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ClubMember extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'club_id',
        'user_id',
        'role',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $table = 'club_members';
    protected $timestamp = true;

    public function club(): BelongsTo
    {
        return $this->belongsTo('App\Models\Club');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    const ROLE_PENDING = 0;
    const ROLE_MEMBER = 1;
    const ROLE_ADMIN = 2;
    const ROLE_OWNER = 3;

    public function isPending(): bool
    {
        return $this->role === self::ROLE_PENDING;
    }

    public function setPending(): void
    {
        $this->role = self::ROLE_PENDING;
    }

    public function isMember(): bool
    {
        return $this->role === self::ROLE_MEMBER;
    }

    public function setMember(): void
    {
        $this->role = self::ROLE_MEMBER;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function setAdmin(): void
    {
        $this->role = self::ROLE_ADMIN;
    }

    public function isOwner(): bool
    {
        return $this->role === self::ROLE_OWNER;
    }

    public function setOwner(): void
    {
        $this->role = self::ROLE_OWNER;
    }

    public function isHigherThan(ClubMember $member): bool
    {
        return $this->role > $member->role;
    }

}
