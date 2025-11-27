<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            ProveedorsSeeder::class,

        // Parte 2
            ComprasSeeder::class,
            DetallecomprasSeeder::class,
            CotizacionesSeeder::class,
            DetallecotizacionesSeeder::class,
            PedidosSeeder::class,
            DetallepedidosSeeder::class,
            CajasSeeder::class,
            PagosSeeder::class,
            MovimientoscajaSeeder::class,
            AuditoriasSeeder::class,
            PermisosSeeder::class,
            AsignarPermisosSeeder::class,
            AsignarPermisosPorCasosDeUsoSeeder::class,
            
        ]);

        DB::statement("SELECT setval('auditorias_id_seq', COALESCE((SELECT MAX(id) FROM auditorias), 1));");
        DB::statement("SELECT setval('cajas_id_seq', COALESCE((SELECT MAX(id) FROM cajas), 1));");
        DB::statement("SELECT setval('categorias_id_seq', COALESCE((SELECT MAX(id) FROM categorias), 1));");
        DB::statement("SELECT setval('clientes_id_seq', COALESCE((SELECT MAX(id) FROM clientes), 1));");
        DB::statement("SELECT setval('compras_id_seq', COALESCE((SELECT MAX(id) FROM compras), 1));");
        DB::statement("SELECT setval('cotizaciones_id_seq', COALESCE((SELECT MAX(id) FROM cotizaciones), 1));");
        DB::statement("SELECT setval('detalleaves_id_seq', COALESCE((SELECT MAX(id) FROM detalleaves), 1));");
        DB::statement("SELECT setval('detallecompras_id_seq', COALESCE((SELECT MAX(id) FROM detallecompras), 1));");
        DB::statement("SELECT setval('detallecotizaciones_id_seq', COALESCE((SELECT MAX(id) FROM detallecotizaciones), 1));");
        DB::statement("SELECT setval('detallepedidos_id_seq', COALESCE((SELECT MAX(id) FROM detallepedidos), 1));");
        DB::statement("SELECT setval('fotoaves_id_seq', COALESCE((SELECT MAX(id) FROM fotoaves), 1));");
        DB::statement("SELECT setval('metodopagos_id_seq', COALESCE((SELECT MAX(id) FROM metodopagos), 1));");
        DB::statement("SELECT setval('migrations_id_seq', COALESCE((SELECT MAX(id) FROM migrations), 1));");
        DB::statement("SELECT setval('movimientoscaja_id_seq', COALESCE((SELECT MAX(id) FROM movimientoscaja), 1));");
        DB::statement("SELECT setval('pagos_id_seq', COALESCE((SELECT MAX(id) FROM pagos), 1));");
        DB::statement("SELECT setval('pedidos_id_seq', COALESCE((SELECT MAX(id) FROM pedidos), 1));");
        DB::statement("SELECT setval('productoalimentos_id_seq', COALESCE((SELECT MAX(id) FROM productoalimentos), 1));");
        DB::statement("SELECT setval('productoaves_id_seq', COALESCE((SELECT MAX(id) FROM productoaves), 1));");
        DB::statement("SELECT setval('proveedors_id_seq', COALESCE((SELECT MAX(id) FROM proveedors), 1));");
        DB::statement("SELECT setval('rols_id_seq', COALESCE((SELECT MAX(id) FROM rols), 1));");
        DB::statement("SELECT setval('stocks_id_seq', COALESCE((SELECT MAX(id) FROM stocks), 1));");
        DB::statement("SELECT setval('usuarios_id_seq', COALESCE((SELECT MAX(id) FROM usuarios), 1));");
        DB::statement("SELECT setval('vendedors_id_seq', COALESCE((SELECT MAX(id) FROM vendedors), 1));");
        DB::statement("SELECT setval('permisos_id_seq', COALESCE((SELECT MAX(id) FROM permisos), 1));");
        DB::statement("SELECT setval('rol_permiso_id_seq', COALESCE((SELECT MAX(id) FROM rol_permiso), 1));");    
    }
}
