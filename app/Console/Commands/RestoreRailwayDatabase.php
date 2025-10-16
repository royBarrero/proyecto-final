<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RestoreRailwayDatabase extends Command
{
    // Nombre del comando que usarás en Artisan
    protected $signature = 'restore:railway';

    // Descripción del comando
    protected $description = 'Restaura la base de datos desde backup.sql en Railway';

    public function handle()
    {
        // Ruta del archivo backup.sql
        $path = database_path('backup.sql');

        // Leer el contenido del archivo
        $sql = file_get_contents($path);

        // Ejecutar el SQL en la base de datos configurada en .env
        DB::unprepared($sql);

        // Mensaje de éxito
        $this->info('¡Base de datos restaurada en Railway correctamente!');
    }
}
