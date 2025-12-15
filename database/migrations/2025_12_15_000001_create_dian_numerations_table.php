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
        Schema::create('dian_numerations', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento'); // Factura, Nota Crédito, Nota Débito, Documento Soporte
            $table->string('prefijo')->nullable(); // Prefijo autorizado (ej: SETP, FE, DS)
            $table->integer('numero_inicial'); // Número inicial del rango
            $table->integer('numero_final'); // Número final del rango
            $table->integer('numero_actual'); // Número actual en uso
            $table->date('vigencia_inicio'); // Fecha de inicio de vigencia
            $table->date('vigencia_fin'); // Fecha de fin de vigencia
            $table->string('resolucion'); // Número de resolución DIAN
            $table->date('fecha_resolucion')->nullable(); // Fecha de la resolución
            $table->string('clave_tecnica')->nullable(); // Clave técnica si aplica
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dian_numerations');
    }
};
