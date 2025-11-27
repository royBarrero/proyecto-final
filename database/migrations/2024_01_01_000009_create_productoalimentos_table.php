<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productoalimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->decimal('precio', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productoalimentos');
    }
};
