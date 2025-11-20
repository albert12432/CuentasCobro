<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'fecha_inicio',
        'fecha_fin',
        'valor_contrato',
        // agrega los campos que tengas definidos en la migración de contratos
    ];

    // Un contrato puede tener muchas cuentas de cobro
    public function cuentasCobro()
    {
        return $this->hasMany(CuentaCobro::class, 'contrato_id');
    }
}
