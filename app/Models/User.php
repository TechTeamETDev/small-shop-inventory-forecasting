<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles; // Spatie trait for roles & permissions

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Add HasRoles

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',                  // add role if you want mass assignment
        'must_reset_password',   // ✅ add this for first-login reset
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed', // Laravel 10+ automatic hashing
        'must_reset_password' => 'boolean', // ✅ cast as boolean
    ];

    /**
     * Optional convenience helpers
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin'); // Uses Spatie
    }

    public function isEmployee(): bool
    {
        return $this->hasRole('Employee'); // Uses Spatie
    }
}