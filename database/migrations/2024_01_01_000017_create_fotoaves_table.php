<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fotoaves', function (Blueprint $table) {
            $table->id();
            $table->string('nombrefoto', 250);
            $table->foreignId('idproductoaves')->constrained('productoaves')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotoaves');
    }
};
