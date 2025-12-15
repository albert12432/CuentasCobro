<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DianNumeration extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_documento',
        'prefijo',
        'numero_inicial',
        'numero_final',
        'numero_actual',
        'vigencia_inicio',
        'vigencia_fin',
        'resolucion',
        'fecha_resolucion',
        'clave_tecnica',
        'activo'
    ];

    protected $casts = [
        'vigencia_inicio' => 'date',
        'vigencia_fin' => 'date',
        'fecha_resolucion' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Get the next number formatted with prefix.
     *
     * @return string The next formatted number
     */
    public function getSiguienteNumeroAttribute(): string
    {
        $nextNumber = $this->numero_actual + 1;
        
        if ($nextNumber > $this->numero_final) {
            throw new \RuntimeException(
                "No hay más números disponibles en este rango. " .
                "Número actual: {$this->numero_actual}, Número final: {$this->numero_final}"
            );
        }
        
        return $this->prefijo ? $this->prefijo . '-' . $nextNumber : (string) $nextNumber;
    }

    /**
     * Check if the numeration is still valid.
     *
     * @return bool True if valid
     */
    public function isVigente(): bool
    {
        $today = now()->toDateString();
        return $this->activo && 
               $this->vigencia_inicio <= $today && 
               $this->vigencia_fin >= $today &&
               $this->numero_actual < $this->numero_final;
    }
}
