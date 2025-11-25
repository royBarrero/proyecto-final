<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('estado');
            $table->decimal('total', 12, 2);
            $table->foreignId('idproveedors')->constrained('proveedors');
            $table->foreignId('idvendedors')->constrained('vendedors');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
