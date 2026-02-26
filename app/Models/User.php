<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Allow mass assignment of role
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Hidden fields in arrays/JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast password to hashed automatically
    protected $casts = [
        'password' => 'hashed',
    ];

    // Helper methods
    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isEmployee(): bool {
        return $this->role === 'employee';
    }
}