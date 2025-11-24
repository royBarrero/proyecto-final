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
        Schema::create('vendedors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('direccion', 250)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('email', 150)->unique();
            $table->foreignId('idusuarios')->nullable()->constrained('usuarios');
            $table->smallInteger('activo')->default(0);
            
        });
        DB::statement("ALTER TABLE vendedors ADD CONSTRAINT chk_activo_valid CHECK (activo = ANY(ARRAY[0, 1]));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendedors');
    }
};
