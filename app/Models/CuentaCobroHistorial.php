<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaCobroHistorial extends Model
{
    use HasFactory;

    protected $table = 'cuentas_cobro_historial';

    protected $fillable = [
        'cuenta_cobro_id', 'user_id', 'accion', 'estado_anterior', 'estado_nuevo', 'comentario'
    ];

    public function cuenta()
    {
        return $this->belongsTo(CuentaCobro::class, 'cuenta_cobro_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIcono(): string
    {
        return match ($this->accion) {
            'creado' => 'add_circle',
            'revisado' => 'visibility',
            'aprobado' => 'check_circle',
            'rechazado' => 'cancel',
            'enviado_cliente' => 'send',
            'pagado' => 'paid',
            'pago_rechazado' => 'cancel',
            'devuelto' => 'undo',
            'reenviado' => 'redo',
            default => 'info',
        };
    }

    public function getColor(): string
    {
        return match ($this->accion) {
            'creado' => '#0A84FF',
            'revisado' => '#5856D6',
            'aprobado' => '#34C759',
            'rechazado' => '#FF3B30',
            'enviado_cliente' => '#5856D6',
            'pagado' => '#34C759',
            'pago_rechazado' => '#FF3B30',
            'devuelto' => '#FF9500',
            'reenviado' => '#0A84FF',
            default => '#8E8E93',
        };
    }
}
