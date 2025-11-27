<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientoscaja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idcaja')->constrained('cajas')->onDelete('cascade');
            $table->string('tipo', 10);
            $table->text('descripcion')->nullable();
            $table->decimal('monto', 12, 2);
            $table->timestamp('fecha')->useCurrent();
            $table->string('origen', 30)->nullable();
            $table->integer('idreferencia')->nullable();
            
        });
        DB::statement("ALTER TABLE movimientoscaja ADD CONSTRAINT chk_tipo_valido CHECK (tipo IN ('ingreso', 'egreso'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientoscaja');
    }
};
