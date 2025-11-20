<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();

            // Información general del contrato
            $table->string('numero')->unique();
            $table->string('objeto');
            $table->decimal('valor', 15, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();

            // Contratista asociado
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Estado del contrato
            $table->enum('estado', ['vigente', 'finalizado', 'suspendido'])->default('vigente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
