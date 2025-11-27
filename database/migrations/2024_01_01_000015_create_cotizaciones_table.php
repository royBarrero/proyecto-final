<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('total', 12, 2);
            $table->integer('validez');
            $table->foreignId('idclientes')->constrained('clientes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
