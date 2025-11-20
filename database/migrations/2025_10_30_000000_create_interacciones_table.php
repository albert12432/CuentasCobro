<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_cobro_id')->constrained('cuentas_cobro')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('tipo', ['nota_manual', 'recordatorio_pago', 'llamada', 'email_enviado', 'aprobacion', 'rechazo', 'devolucion', 'pago_registrado'])->default('nota_manual');
            $table->string('asunto', 200);
            $table->text('detalle')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index('cuenta_cobro_id');
            $table->index('user_id');
            $table->index('tipo');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interacciones');
    }
};
