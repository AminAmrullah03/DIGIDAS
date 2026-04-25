<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // ─── Role Constants ───────────────────────────────────────────────────────
    const ROLE_SUPERADMIN = 'superadmin';
    const ROLE_GURU       = 'guru';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nip',
        'email',
        'password',
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
            'password'          => 'hashed',
        ];
    }

    // ─── Role Helpers ─────────────────────────────────────────────────────────

    /**
     * Cek apakah user adalah superadmin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPERADMIN;
    }

    /**
     * Cek apakah user adalah guru.
     */
    public function isGuru(): bool
    {
        return $this->role === self::ROLE_GURU;
    }

    /**
     * Alias isSuperAdmin() — dipakai di blade: auth()->user()->isAdmin()
     */
    public function isAdmin(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Cek apakah user punya salah satu dari role yang diberikan.
     * Contoh: $user->hasRole(['superadmin', 'guru'])
     *
     * @param  string|array<string>  $roles
     */
    public function hasRole(string|array $roles): bool
    {
        return in_array($this->role, (array) $roles, strict: true);
    }
}