<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->char('estado', 1);
            $table->date('fecha');
            $table->foreignId('idproductoaves')->constrained('productoaves');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
