<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    use HasFactory;

    protected $table = 'soportes';

    protected $fillable = [
        'cuenta_cobro_id', 'user_id', 'nombre', 'path', 'mime', 'size'
    ];

    public function cuenta()
    {
        return $this->belongsTo(CuentaCobro::class, 'cuenta_cobro_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
