<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productoaves', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->decimal('precio', 10, 2);
            $table->foreignId('idcategorias')->constrained('categorias');
            $table->foreignId('iddetalleaves')->unique()->constrained('detalleaves');
            $table->integer('cantidad')->default(0);
            
        });
        DB::statement("ALTER TABLE productoaves ADD CONSTRAINT chk_cantidad_no_negativa CHECK (cantidad >= 0);");
    }

    public function down(): void
    {
        Schema::dropIfExists('productoaves');
    }
};
