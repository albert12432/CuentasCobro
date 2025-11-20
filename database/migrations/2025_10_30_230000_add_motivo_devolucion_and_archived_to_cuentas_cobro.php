<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            if (!Schema::hasColumn('cuentas_cobro', 'motivo_devolucion')) {
                $table->text('motivo_devolucion')->nullable()->after('motivo_rechazo');
            }
            if (!Schema::hasColumn('cuentas_cobro', 'archived_at')) {
                $table->timestamp('archived_at')->nullable()->after('fecha_envio_cliente');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            if (Schema::hasColumn('cuentas_cobro', 'motivo_devolucion')) {
                $table->dropColumn('motivo_devolucion');
            }
            if (Schema::hasColumn('cuentas_cobro', 'archived_at')) {
                $table->dropColumn('archived_at');
            }
        });
    }
};
