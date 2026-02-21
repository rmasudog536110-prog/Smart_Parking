<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role',
    ];

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

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function hasAdminAccess(): bool
    {
        return in_array($this->role, ['admin']);
    }

    public function hasOperatorAccess(): bool
    {
        return in_array($this->role, ['staff']);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile && $this->profile->profile_picture
            ? Storage::url($this->profile->profile_picture)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3b82f6&color=fff&size=128';
    }

}
