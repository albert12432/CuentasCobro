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
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            // Eliminar restricción de clave foránea si existe
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // Ya no existe, continuar
            }
            
            // Eliminar restricción de contrato_id también
            try {
                $table->dropForeign(['contrato_id']);
            } catch (\Exception $e) {
                // Ya no existe, continuar
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            // Restaurar claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('contrato_id')->references('id')->on('contratos')->onDelete('set null');
        });
    }
};
