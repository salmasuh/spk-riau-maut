<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // gunakan properti $casts, bukan method
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Helper: cek apakah user memiliki role tertentu
     * @param string|array $role
     */
    public function isRole($role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    /**
     * Scope: hanya user aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }
}