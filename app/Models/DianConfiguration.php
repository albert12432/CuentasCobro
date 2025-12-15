<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DianConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'environment',
        'test_set_id',
        'software_id',
        'pin',
        'certificate_path',
        'certificate_password',
        'web_service_url',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'certificate_password' => 'encrypted',
        'pin' => 'encrypted',
    ];

    protected $hidden = [
        'certificate_password',
        'pin',
    ];
}
