<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaccion extends Model
{
    protected $table = 'interacciones';
    
    protected $fillable = [
        'cuenta_cobro_id',
        'user_id',
        'tipo',
        'asunto',
        'detalle',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación: Interacción pertenece a CuentaCobro
     */
    public function cuentaCobro(): BelongsTo
    {
        return $this->belongsTo(CuentaCobro::class, 'cuenta_cobro_id');
    }

    /**
     * Relación: Interacción pertenece a User (usuario que registró)
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Método estático para registrar una interacción
     */
    public static function registrar($cuenta_id, $tipo, $asunto, $detalle = null, $user_id = null)
    {
        $user_id = $user_id ?? auth()->id();
        
        return static::create([
            'cuenta_cobro_id' => $cuenta_id,
            'user_id' => $user_id,
            'tipo' => $tipo,
            'asunto' => $asunto,
            'detalle' => $detalle,
        ]);
    }

    /**
     * Obtener color para cada tipo de interacción
     */
    public function getColor()
    {
        return match($this->tipo) {
            'nota_manual' => '#007AFF',          // Azul
            'recordatorio_pago' => '#FF9500',   // Naranja
            'llamada' => '#5856D6',             // Púrpura
            'email_enviado' => '#34C759',       // Verde
            'aprobacion' => '#30D158',          // Verde claro
            'rechazo' => '#FF3B30',             // Rojo
            'devolucion' => '#FF9500',          // Naranja
            'pago_registrado' => '#00C6FF',     // Azul claro
            default => '#86868B'                // Gris
        };
    }

    /**
     * Obtener icono para cada tipo de interacción
     */
    public function getIcono()
    {
        return match($this->tipo) {
            'nota_manual' => 'note',
            'recordatorio_pago' => 'notifications',
            'llamada' => 'call',
            'email_enviado' => 'mail',
            'aprobacion' => 'check_circle',
            'rechazo' => 'cancel',
            'devolucion' => 'undo',
            'pago_registrado' => 'payments',
            default => 'info'
        };
    }

    /**
     * Obtener etiqueta amigable del tipo
     */
    public function getEtiqueta()
    {
        return match($this->tipo) {
            'nota_manual' => 'Nota Manual',
            'recordatorio_pago' => 'Recordatorio de Pago',
            'llamada' => 'Llamada',
            'email_enviado' => 'Email Enviado',
            'aprobacion' => 'Aprobación',
            'rechazo' => 'Rechazo',
            'devolucion' => 'Devolución',
            'pago_registrado' => 'Pago Registrado',
            default => 'Interacción'
        };
    }
}
