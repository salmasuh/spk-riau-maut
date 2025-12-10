<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function getAuthIdentifierName()
    {
        return 'username';
    }

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

    // Hapus email_verified_at karena kolom email sudah dihapus
    protected $casts = [
        // tidak ada cast khusus
    ];

    /**
     * Helper: cek role
     */
    public function isRole($role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    /**
     * Scope user aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }
}