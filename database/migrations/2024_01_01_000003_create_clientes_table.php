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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('direccion', 250)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->foreignId('idusuarios')->nullable()->constrained('usuarios');
            $table->smallInteger('activo')->default(1);
            
            $table->check('activo = ANY(ARRAY[0, 1])');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
