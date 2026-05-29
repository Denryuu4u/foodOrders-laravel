<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'address',
        'gender',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Relationships
    public function foodOrders()
    {
        return $this->hasMany(FoodOrder::class);
    }

    // Helper: is admin?
    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    // Profile picture URL helper
    public function getProfilePictureUrlAttribute(): string
    {
        if ($this->profile_picture && file_exists(storage_path('app/public/profile_pictures/' . $this->profile_picture))) {
            return asset('storage/profile_pictures/' . $this->profile_picture);
        }
        return asset('images/default.png');
    }
}
