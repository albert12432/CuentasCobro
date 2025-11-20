<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('soportes')) {
            Schema::create('soportes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cuenta_cobro_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('nombre');
                $table->string('path');
                $table->string('mime')->nullable();
                $table->unsignedBigInteger('size')->nullable();
                $table->timestamps();
                $table->index('cuenta_cobro_id');
                $table->index('user_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('soportes');
    }
};
