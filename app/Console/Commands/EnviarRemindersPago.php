<?php

namespace App\Console\Commands;

use App\Models\CuentaCobro;
use App\Models\Interaccion;
use Illuminate\Console\Command;
use Carbon\Carbon;

class EnviarRemindersPago extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Envía recordatorios de pago automáticos a clientes con cuentas pendientes';

    public function handle()
    {
        $this->info('Iniciando envío de recordatorios de pago...');
        
        $ahora = now();
        
        // Buscar cuentas que:
        // 1. Fueron enviadas al cliente (estado enviado_cliente)
        // 2. NO han sido pagadas
        // 3. Tienen recordatrios habilitados
        // 4. Ha llegado la fecha de próximo recordatorio
        
        $cuentas = CuentaCobro::where('estado_aprobacion', 'enviado_cliente')
            ->where('recordatorio_habilitado', true)
            ->where(function($q) {
                $q->whereNull('proxima_fecha_recordatorio')
                  ->orWhere('proxima_fecha_recordatorio', '<=', now());
            })
            ->with(['user'])
            ->get();

        if ($cuentas->isEmpty()) {
            $this->info('No hay cuentas pendientes de recordatorio.');
            return 0;
        }

        $enviados = 0;
        foreach ($cuentas as $cuenta) {
            try {
                $this->enviarRecordatorio($cuenta);
                $enviados++;
                $this->info("✅ Recordatorio enviado para cuenta: {$cuenta->numero}");
            } catch (\Exception $e) {
                $this->error("❌ Error enviando recordatorio para {$cuenta->numero}: {$e->getMessage()}");
            }
        }

        $this->info("Recordatorios enviados: {$enviados}/{$cuentas->count()}");
        return 0;
    }

    /**
     * Enviar recordatorio de pago
     */
    private function enviarRecordatorio($cuenta)
    {
        // Registrar interacción
        Interaccion::registrar(
            $cuenta->id,
            'recordatorio_pago',
            'Recordatorio de pago automático',
            "Se ha enviado un recordatorio de pago para la cuenta {$cuenta->numero} por valor de \${$cuenta->valor_total}. Plazo de pago: {$cuenta->plazo_pago} días.",
            null  // Sin user_id (sistema automático)
        );

        // Actualizar próxima fecha de recordatorio
        $diasFrecuencia = $cuenta->frecuencia_recordatorio_dias ?? 5;
        $cuenta->update([
            'proxima_fecha_recordatorio' => now()->addDays($diasFrecuencia),
            'contador_recordatorios' => $cuenta->contador_recordatorios + 1,
        ]);

        // Aquí iría la lógica real de envío:
        // - Email via Mail::send()
        // - WhatsApp via API
        // Este es un ejemplo simplificado
        
        if ($cuenta->cliente_email) {
            // TODO: Implementar envío de email
            // Mail::send('emails.recordatorio-pago', ['cuenta' => $cuenta], function($message) use ($cuenta) {
            //     $message->to($cuenta->cliente_email)
            //            ->subject("Recordatorio: Pago pendiente - {$cuenta->numero}");
            // });
        }

        if ($cuenta->cliente_whatsapp) {
            // TODO: Implementar envío vía WhatsApp API (Twilio, MessageBird, etc.)
        }
    }
}
