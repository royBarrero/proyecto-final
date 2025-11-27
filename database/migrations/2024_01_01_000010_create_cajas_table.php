<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_apertura')->useCurrent();
            $table->timestamp('fecha_cierre')->nullable();
            $table->decimal('monto_inicial', 12, 2);
            $table->decimal('monto_final', 12, 2)->nullable();
            $table->string('estado', 10)->default('abierta');
            $table->foreignId('idusuarios')->constrained('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
