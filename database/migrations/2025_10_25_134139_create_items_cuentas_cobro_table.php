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
        Schema::create('items_cuenta_cobro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuenta_cobro_id');
            $table->string('item'); // Nombre del ítem
            $table->text('detalle')->nullable(); // Descripción del ítem
            $table->integer('cantidad')->default(1); // Cantidad de unidades
            $table->decimal('precio_unitario', 15, 2); // Precio por unidad
            $table->decimal('subtotal', 15, 2)->storedAs('cantidad * precio_unitario'); // subtotal automático
            $table->timestamps();

            // Relación con la cuenta de cobro
            $table->foreign('cuenta_cobro_id')
                ->references('id')
                ->on('cuentas_cobro')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_cuenta_cobro');
    }
};
