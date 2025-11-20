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
            // Campos para reminders de pago
            $table->string('cliente_email', 255)->nullable()->after('descripcion');
            $table->string('cliente_whatsapp', 20)->nullable()->after('cliente_email');
            $table->boolean('recordatorio_habilitado')->default(true)->after('cliente_whatsapp');
            $table->integer('frecuencia_recordatorio_dias')->default(5)->after('recordatorio_habilitado');
            $table->dateTime('proxima_fecha_recordatorio')->nullable()->after('frecuencia_recordatorio_dias');
            $table->integer('contador_recordatorios')->default(0)->after('proxima_fecha_recordatorio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            $table->dropColumn([
                'cliente_email',
                'cliente_whatsapp',
                'recordatorio_habilitado',
                'frecuencia_recordatorio_dias',
                'proxima_fecha_recordatorio',
                'contador_recordatorios',
            ]);
        });
    }
};
