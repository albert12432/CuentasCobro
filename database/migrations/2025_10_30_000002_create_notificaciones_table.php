<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('notificaciones')) {
            Schema::create('notificaciones', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('tipo')->default('cuenta_cobro');
                $table->string('titulo');
                $table->text('mensaje')->nullable();
                $table->unsignedBigInteger('cuenta_cobro_id')->nullable();
                $table->boolean('leida')->default(false);
                $table->timestamp('fecha_leida')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'leida']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
