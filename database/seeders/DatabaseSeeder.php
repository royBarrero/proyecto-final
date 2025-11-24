<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Parte 1
        $this->call([
            CategoriasSeeder::class,
            RolsSeeder::class,
            UsuariosSeeder::class,
            ClientesSeeder::class,
            VendedorsSeeder::class,
            DetalleavesSeeder::class,
            ProductoalimentosSeeder::class,
            ProductoavesSeeder::class,
            FotoavesSeeder::class,
            MetodopagosSeeder::class,

        // Parte 2
            ComprasSeeder::class,
            DetallecomprasSeeder::class,
            CotizacionesSeeder::class,
            DetallecotizacionesSeeder::class,
            PedidosSeeder::class,
            DetallepedidosSeeder::class,
            PagosSeeder::class,
            CajasSeeder::class,
            MovimientoscajaSeeder::class,
            AuditoriasSeeder::class,
        ]);
    }
}
