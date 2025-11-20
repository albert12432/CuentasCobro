<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relación many-to-many con roles
     */
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,        // Modelo relacionado
            'role_permission',  // Tabla pivote
            'permission_id',    // FK en pivote hacia Permission
            'role_id'           // FK en pivote hacia Role
        );
    }
}
