<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        Schema::create('cuentas_cobro', function (Blueprint $table) {
            $table->id();
            
            // Datos generales de la cuenta
            $table->string('numero')->unique();
            $table->date('fecha_emision');
            $table->decimal('valor_total', 15, 2)->default(0);
            $table->string('departamento');
            $table->string('municipio');
            $table->text('descripcion')->nullable();

            // Datos del beneficiario o cliente
            $table->string('tipo_identificacion')->nullable(); // CC o NIT
            $table->string('identificacion')->nullable();      // número de identificación
            $table->string('tipo_cliente')->nullable();        // Natural o Jurídico
            $table->string('nombre_beneficiario')->nullable();
            $table->string('plazo_pago')->nullable();          // Ej: "30 días"
            $table->date('fecha_maxima_pago')->nullable();     // Fecha calculada o establecida manualmente

            // Relación con contrato
            $table->unsignedBigInteger('contrato_id')->nullable();
            $table->foreign('contrato_id')
                  ->references('id')
                  ->on('contratos')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas_cobro');
    }
};
