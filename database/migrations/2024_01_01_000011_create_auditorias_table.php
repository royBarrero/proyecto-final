<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->string('tabla', 255);
            $table->integer('registro_id');
            $table->string('accion', 50);
            $table->integer('usuario_id')->nullable();
            $table->jsonb('cambios')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        DB::statement("SELECT setval('auditorias_id_seq', (SELECT MAX(id) FROM auditorias));");

    }

    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
