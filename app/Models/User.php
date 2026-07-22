<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function intern(): HasOne
    {
        return $this->hasOne(Intern::class);
    }

    public function supervisor(): HasOne
    {
        return $this->hasOne(Supervisor::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function hasRole(string $roleName): bool
    {
        return $this->role?->role_name === $roleName;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isHr(): bool
    {
        return $this->hasRole('HR');
    }

    public function isSupervisor(): bool
    {
        return $this->hasRole('Supervisor');
    }

    public function isIntern(): bool
    {
        return $this->hasRole('Intern');
    }

    public function isActive(): bool
    {
        return $this->status === 'Active';
    }
}
