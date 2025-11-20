<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('cuentas_cobro_historial')) {
            Schema::create('cuentas_cobro_historial', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cuenta_cobro_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('accion');
                $table->string('estado_anterior')->nullable();
                $table->string('estado_nuevo')->nullable();
                $table->text('comentario')->nullable();
                $table->timestamps();
                $table->index(['cuenta_cobro_id', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cuentas_cobro_historial');
    }
};
