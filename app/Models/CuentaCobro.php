<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaCobro extends Model
{
    use HasFactory;

    protected $table = 'cuentas_cobro';

    protected $fillable = [
        'numero',
        'fecha_emision',
        'valor_total',
        'departamento',
        'municipio',
        'descripcion',
        'motivo_rechazo',
        'motivo_devolucion',
        'tipo_identificacion',
        'identificacion',
        'tipo_cliente',
        'nombre_beneficiario',
        'plazo_pago',
        'contrato_id',
        'user_id',
        'estado_aprobacion',
        'etapa_aprobacion',
        'aprobado_por_id',
        'fecha_aprobacion',
        'fecha_rechazo',
        'fecha_envio_cliente',
        'archived_at',
        'cliente_email',
        'cliente_whatsapp',
        'recordatorio_habilitado',
        'frecuencia_recordatorio_dias',
        'proxima_fecha_recordatorio',
        'contador_recordatorios',
        'estado_pago',
        'fecha_pago',
        'pagado_por',
        'observaciones',
    ];

    /**
     * Relación: una cuenta de cobro tiene muchos ítems.
     */
    public function items()
    {
        return $this->hasMany(ItemCuentaCobro::class, 'cuenta_cobro_id');
    }

    /**
     * Relación: una cuenta de cobro pertenece a un contrato.
     */
    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'contrato_id');
    }
    
    /**
     * Relación: una cuenta de cobro pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: historial de cambios.
     */
    public function historial()
    {
        return $this->hasMany(CuentaCobroHistorial::class, 'cuenta_cobro_id')->orderByDesc('created_at');
    }

    /**
     * Relación: usuario que aprobó finalmente.
     */
    public function aprobadoPor()
    {
        return $this->belongsTo(User::class, 'aprobado_por_id');
    }

    /**
     * Relación: soportes (archivos adjuntos)
     */
    public function soportes()
    {
        return $this->hasMany(Soporte::class, 'cuenta_cobro_id');
    }

    /**
     * Relación: interacciones (historial de comunicaciones)
     */
    public function interacciones()
    {
        return $this->hasMany(Interaccion::class, 'cuenta_cobro_id')->orderByDesc('created_at');
    }

    /**
     * Calcula el valor total automáticamente sumando los ítems.
     */
    public function calcularTotal()
    {
        return $this->items->sum(fn($item) => $item->cantidad * $item->precio_unitario);
    }

    /**
     * Actualiza el valor_total basado en los ítems actuales.
     */
    public function actualizarValorTotal()
    {
        $this->valor_total = $this->calcularTotal();
        $this->save();
    }

    /**
     * Registrar entrada en historial.
     */
    public function registrarHistorial(?int $userId, string $accion, ?string $estadoAnterior, ?string $estadoNuevo, ?string $comentario = null): void
    {
        CuentaCobroHistorial::create([
            'cuenta_cobro_id' => $this->id,
            'user_id' => $userId,
            'accion' => $accion,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $estadoNuevo,
            'comentario' => $comentario,
        ]);
    }

    /** Scope: no archivadas */
    public function scopeNotArchived($query)
    {
        return $query->whereNull('archived_at');
    }

    /**
     * Helper: verifica si la cuenta está en revisión.
     */
    public function isEnRevision(): bool
    {
        return $this->estado_aprobacion === 'en_revision';
    }

    /**
     * Helper: verifica si un usuario puede aprobar esta cuenta según su rol y la etapa actual.
     */
    public function canUserApprove(?User $user): bool
    {
        if (!$user || !$this->isEnRevision()) {
            return false;
        }

        $roleName = $user->role?->name;
        if ($roleName === 'super_admin') {
            return true; // Super admin puede aprobar en cualquier etapa
        }

        // Mapeo de roles a etapas
        $roleToEtapa = [
            'supervisor' => 'supervisor',
            'ordenador_gasto' => 'ordenador_gasto',
            'contratacion' => 'contratacion',
            'alcalde' => 'alcalde',
        ];

        return isset($roleToEtapa[$roleName]) && $this->etapa_aprobacion === $roleToEtapa[$roleName];
    }

    /**
     * Helper: obtiene el texto legible del estado de aprobación.
     */
    public function getEstadoTexto(): string
    {
        $estados = [
            'pendiente' => 'Pendiente',
            'en_revision' => 'En Revisión',
            'en_correccion' => 'En Corrección',
            'aprobado' => 'Aprobado',
            'rechazado' => 'Rechazado',
            'enviado_cliente' => 'Enviado al Cliente',
            'pagado' => 'Pagado',
        ];

        return $estados[$this->estado_aprobacion] ?? 'Desconocido';
    }

    /**
     * Helper: obtiene el texto legible de la etapa actual.
     */
    public function getEtapaTexto(): string
    {
        $etapas = [
            'supervisor' => 'Supervisor',
            'ordenador_gasto' => 'Ordenador del Gasto',
            'contratacion' => 'Contratación',
            'alcalde' => 'Alcalde',
            'tesoreria' => 'Tesorería',
            'contratista' => 'Contratista',
        ];

        return $etapas[$this->etapa_aprobacion] ?? ucfirst(str_replace('_', ' ', $this->etapa_aprobacion ?? ''));
    }

    /**
     * Helper: obtiene el color del badge según el estado.
     */
    public function getEstadoColor(): string
    {
        $colores = [
            'pendiente' => '#FF9500',
            'en_revision' => '#007AFF',
            'en_correccion' => '#FF9500',
            'aprobado' => '#34C759',
            'rechazado' => '#FF3B30',
            'enviado_cliente' => '#5856D6',
            'pagado' => '#30D158',
        ];

        return $colores[$this->estado_aprobacion] ?? '#86868b';
    }

    /**
     * Helper: obtiene el icono del badge según el estado.
     */
    public function getEstadoIcono(): string
    {
        $iconos = [
            'pendiente' => 'schedule',
            'en_revision' => 'visibility',
            'en_correccion' => 'edit',
            'aprobado' => 'check_circle',
            'rechazado' => 'cancel',
            'enviado_cliente' => 'send',
            'pagado' => 'payments',
        ];

        return $iconos[$this->estado_aprobacion] ?? 'help';
    }

    /**
     * Helper: verifica si el usuario es el dueño contratista de esta cuenta.
     */
    public function isOwner(?User $user): bool
    {
        return $user && $user->id === $this->user_id && $user->role?->name === 'contratista';
    }

    /**
     * Helper: verifica si la cuenta está aprobada y lista para enviar al cliente.
     */
    public function canSendToClient(?User $user): bool
    {
        if (!$user || $this->estado_aprobacion !== 'aprobado') {
            return false;
        }

        $allowedRoles = ['ordenador_gasto', 'alcalde', 'super_admin', 'tesoreria'];
        return in_array($user->role?->name, $allowedRoles);
    }

    /**
     * Helper: verifica si la cuenta está lista para registrar pago (Tesorería).
     */
    public function canRegisterPayment(?User $user): bool
    {
        if (!$user || $this->estado_aprobacion !== 'aprobado' || $this->etapa_aprobacion !== 'tesoreria') {
            return false;
        }

        return in_array($user->role?->name, ['tesoreria', 'super_admin']);
    }
}
