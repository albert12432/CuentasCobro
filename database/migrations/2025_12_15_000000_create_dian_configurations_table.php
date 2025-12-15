<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Note: Sensitive fields (certificate_password, pin) are stored as text but
     * will be encrypted at the application level using Laravel's encrypted casts.
     * For production use, consider using a dedicated secrets manager or vault service.
     */
    public function up(): void
    {
        Schema::create('dian_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('environment')->default('set'); // 'set' or 'production'
            $table->string('test_set_id')->nullable(); // ID de pruebas en SET
            $table->string('software_id')->nullable(); // ID del software
            $table->string('pin')->nullable(); // PIN del software (encrypted via model cast)
            $table->text('certificate_path')->nullable(); // Ruta al certificado .p12/.pfx
            $table->text('certificate_password')->nullable(); // Contraseña del certificado (encrypted via model cast)
            $table->string('web_service_url')->nullable(); // URL del servicio web DIAN
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dian_configurations');
    }
};
