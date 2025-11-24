<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CajasSeeder extends Seeder{
    public function run(){
        DB::table('cajas')->insert(['id'=> '1', 'fecha_apertura'=> '2025-11-04 13=>38=>31.425372', 'fecha_cierre'=> '2025-11-04 17=>47=>41', 'monto_inicial'=> '1000.00', 'monto_final'=> '1000.00', 'estado'=> 'cerrada', 'idusuarios'=> '16'] );
        DB::table('cajas')->insert(['id'=> '2', 'fecha_apertura'=> '2025-11-04 13=>47=>54.310963', 'fecha_cierre'=> '2025-11-05 04=>57=>43', 'monto_inicial'=> '1000.00', 'monto_final'=> '800.00', 'estado'=> 'cerrada', 'idusuarios'=> '16'] );
        DB::table('cajas')->insert(['id'=> '3', 'fecha_apertura'=> '2025-11-05 02=>29=>59.886798', 'fecha_cierre'=> '2025-11-05 07=>15=>06', 'monto_inicial'=> '5000.00', 'monto_final'=> '-1000.00', 'estado'=> 'cerrada', 'idusuarios'=> '16'] );
        DB::table('cajas')->insert(['id'=> '4', 'fecha_apertura'=> '2025-11-05 03=>16=>33.444752', 'fecha_cierre'=> '2025-11-05 07=>16=>59', 'monto_inicial'=> '5000.00', 'monto_final'=> '3000.00', 'estado'=> 'cerrada', 'idusuarios'=> '16'] );
    }
}