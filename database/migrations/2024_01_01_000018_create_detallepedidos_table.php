<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detallepedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idpedidos')->constrained('pedidos');
            $table->foreignId('idproductoaves')->constrained('productoaves');
            $table->integer('cantidad');
            $table->decimal('preciounitario', 10, 2);
            $table->decimal('subtotal', 12, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detallepedidos');
    }
};
