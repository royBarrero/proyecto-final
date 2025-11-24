<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detallecotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idcotizaciones')->constrained('cotizaciones');
            $table->integer('idproductoaves');
            $table->integer('cantidad');
            $table->decimal('preciounitario', 10, 2);
            $table->decimal('subtotal', 12, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detallecotizaciones');
    }
};
