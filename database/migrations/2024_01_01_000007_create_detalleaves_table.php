<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalleaves', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100);
            $table->string('edad', 7);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalleaves');
    }
};
