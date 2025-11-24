<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('direccion', 250)->nullable();
            $table->string('telefono', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedors');
    }
};
