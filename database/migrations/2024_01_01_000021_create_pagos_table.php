<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('estado');
            $table->decimal('monto', 12, 2);
            $table->foreignId('idpedidos')->nullable()->constrained('pedidos');
            $table->foreignId('idmetodopagos')->constrained('metodopagos');
            $table->foreignId('idcaja')->nullable()->constrained('cajas')->onDelete('cascade');
            $table->string('tipo', 10)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('origen', 30)->nullable();
            $table->integer('idreferencia')->nullable();
            
        });
        DB::statement("
        ALTER TABLE pagos 
        ADD CONSTRAINT chk_tipo_valido 
        CHECK (tipo IN ('ingreso', 'egreso') OR tipo IS NULL)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
