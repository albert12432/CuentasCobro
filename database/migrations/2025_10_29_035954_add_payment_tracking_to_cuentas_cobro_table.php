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
            $table->date('fecha_pago')->nullable()->after('fecha_maxima_pago');
            $table->string('referencia_pago')->nullable()->after('fecha_pago');
            $table->string('metodo_pago')->nullable()->after('referencia_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            $table->dropColumn(['fecha_pago', 'referencia_pago', 'metodo_pago']);
        });
    }
};
