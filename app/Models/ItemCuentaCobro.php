<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCuentaCobro extends Model
{
    use HasFactory;

    protected $table = 'items_cuenta_cobro';

    protected $fillable = [
        'cuenta_cobro_id',
        'item',
        'detalle',
        'cantidad',
        'precio_unitario',
    ];

    protected $appends = ['subtotal'];

    /**
     * Relación: un ítem pertenece a una cuenta de cobro.
     */
    public function cuentaCobro()
    {
        return $this->belongsTo(CuentaCobro::class, 'cuenta_cobro_id');
    }

    /**
     * Calcula el subtotal automáticamente.
     */
    public function getSubtotalAttribute()
    {
        return $this->cantidad * $this->precio_unitario;
    }
}
