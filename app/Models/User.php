<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_USER = 'user';
    const ROLE_REFERRAL = 'referral';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'referer',
    ];

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isManager()
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function isReferral()
    {
        return $this->role === self::ROLE_REFERRAL;
    }

    public function generatedLinks()
    {
        return $this->hasMany(GeneratedLink::class);
    }

    public function avatar()
    {
        return $this->morphOne(Media::class, 'model');
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('uploads/' . $this->avatar->file_path) : asset('img/placeholder_avatar.png');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role == 1;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
