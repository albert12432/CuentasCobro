<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            if (!Schema::hasColumn('cuentas_cobro', 'estado_aprobacion')) {
                $table->string('estado_aprobacion')->default('en_revision')->after('valor_total');
            }
            if (!Schema::hasColumn('cuentas_cobro', 'etapa_aprobacion')) {
                $table->string('etapa_aprobacion')->nullable()->after('estado_aprobacion');
            }
            if (!Schema::hasColumn('cuentas_cobro', 'motivo_rechazo')) {
                $table->text('motivo_rechazo')->nullable()->after('descripcion');
            }
            if (!Schema::hasColumn('cuentas_cobro', 'aprobado_por_id')) {
                $table->unsignedBigInteger('aprobado_por_id')->nullable()->after('plazo_pago');
            }
            if (!Schema::hasColumn('cuentas_cobro', 'fecha_aprobacion')) {
                $table->timestamp('fecha_aprobacion')->nullable()->after('aprobado_por_id');
            }
            if (!Schema::hasColumn('cuentas_cobro', 'fecha_rechazo')) {
                $table->timestamp('fecha_rechazo')->nullable()->after('fecha_aprobacion');
            }
            if (!Schema::hasColumn('cuentas_cobro', 'fecha_envio_cliente')) {
                $table->timestamp('fecha_envio_cliente')->nullable()->after('fecha_rechazo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            if (Schema::hasColumn('cuentas_cobro', 'fecha_envio_cliente')) $table->dropColumn('fecha_envio_cliente');
            if (Schema::hasColumn('cuentas_cobro', 'fecha_rechazo')) $table->dropColumn('fecha_rechazo');
            if (Schema::hasColumn('cuentas_cobro', 'fecha_aprobacion')) $table->dropColumn('fecha_aprobacion');
            if (Schema::hasColumn('cuentas_cobro', 'aprobado_por_id')) $table->dropColumn('aprobado_por_id');
            if (Schema::hasColumn('cuentas_cobro', 'motivo_rechazo')) $table->dropColumn('motivo_rechazo');
            if (Schema::hasColumn('cuentas_cobro', 'etapa_aprobacion')) $table->dropColumn('etapa_aprobacion');
            if (Schema::hasColumn('cuentas_cobro', 'estado_aprobacion')) $table->dropColumn('estado_aprobacion');
        });
    }
};
