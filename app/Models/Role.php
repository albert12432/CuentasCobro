<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relación many-to-many con permisos
     */
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,       // Modelo relacionado
            'role_permission',       // Tabla pivote
            'role_id',               // FK en tabla pivote que apunta a Role
            'permission_id'          // FK en tabla pivote que apunta a Permission
        );
    }

    /**
     * Relación uno a muchos con usuarios
     */
    public function users()
    {
        return $this->hasMany(
            User::class,            
            'role_id',              
            'id'                    
        );
    }
}
