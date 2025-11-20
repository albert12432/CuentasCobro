<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación: cada usuario tiene un rol
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Métodos de verificación de rol
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function hasAnyRole($roles)
    {
        if (!is_array($roles)) $roles = [$roles];
        return $this->role && in_array($this->role->name, $roles);
    }

    public function isAdmin(): bool
    {
        return $this->hasAnyRole(['alcalde', 'ordenador_gasto']);
    }

    public function canApprovePayments(): bool
    {
        return $this->hasAnyRole(['alcalde', 'ordenador_gasto', 'tesoreria']);
    }

    public function canManageContracts(): bool
    {
        return $this->hasAnyRole(['contratacion', 'alcalde']);
    }

    public function isContractAdmin(): bool
    {
        return $this->hasRole('contratacion');
    }
}
