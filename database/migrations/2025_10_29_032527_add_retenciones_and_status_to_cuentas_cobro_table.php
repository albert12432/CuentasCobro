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
            $table->decimal('retencion_fuente', 15, 2)->default(0)->after('valor_total');
            $table->decimal('retencion_ica', 15, 2)->default(0)->after('retencion_fuente');
            $table->decimal('retencion_iva', 15, 2)->default(0)->after('retencion_ica');
            
            $table->decimal('retefuente_porcentaje', 5, 2)->default(0)->after('retencion_iva');
            $table->decimal('reteica_porcentaje', 5, 2)->default(0)->after('retefuente_porcentaje');
            $table->decimal('reteiva_porcentaje', 5, 2)->default(0)->after('reteica_porcentaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            $table->dropColumn([
                'retencion_fuente', 
                'retencion_ica', 
                'retencion_iva',
                'retefuente_porcentaje',
                'reteica_porcentaje',
                'reteiva_porcentaje'
            ]);
        });
    }
};
