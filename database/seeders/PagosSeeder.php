<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PagosSeeder extends Seeder{
    public function run(){
        DB::table('pagos')->insert(['id'=> '1', 'fecha'=> '2025-01-05', 'estado'=> '1', 'monto'=> '250.00', 'idpedidos'=> '1', 'idmetodopagos'=> '1', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '2', 'fecha'=> '2025-01-06', 'estado'=> '1', 'monto'=> '300.00', 'idpedidos'=> '2', 'idmetodopagos'=> '2', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '3', 'fecha'=> '2025-01-07', 'estado'=> '1', 'monto'=> '350.00', 'idpedidos'=> '3', 'idmetodopagos'=> '3', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '4', 'fecha'=> '2025-01-08', 'estado'=> '1', 'monto'=> '400.00', 'idpedidos'=> '4', 'idmetodopagos'=> '4', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '5', 'fecha'=> '2025-01-09', 'estado'=> '1', 'monto'=> '450.00', 'idpedidos'=> '5', 'idmetodopagos'=> '5', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '6', 'fecha'=> '2025-01-10', 'estado'=> '1', 'monto'=> '500.00', 'idpedidos'=> '6', 'idmetodopagos'=> '6', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '7', 'fecha'=> '2025-01-11', 'estado'=> '1', 'monto'=> '550.00', 'idpedidos'=> '7', 'idmetodopagos'=> '7', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '8', 'fecha'=> '2025-01-12', 'estado'=> '1', 'monto'=> '600.00', 'idpedidos'=> '8', 'idmetodopagos'=> '8', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '9', 'fecha'=> '2025-01-13', 'estado'=> '1', 'monto'=> '650.00', 'idpedidos'=> '9', 'idmetodopagos'=> '9', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '10', 'fecha'=> '2025-01-14', 'estado'=> '1', 'monto'=> '700.00', 'idpedidos'=> '10', 'idmetodopagos'=> '10', 'idcaja'=> None, 'tipo'=> None, 'descripcion'=> None, 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '16', 'fecha'=> '2025-11-04', 'estado'=> '1', 'monto'=> '200.00', 'idpedidos'=> None, 'idmetodopagos'=> '1', 'idcaja'=> '2', 'tipo'=> 'egreso', 'descripcion'=> 'comida', 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '19', 'fecha'=> '2025-11-05', 'estado'=> '1', 'monto'=> '6000.00', 'idpedidos'=> '1', 'idmetodopagos'=> '1', 'idcaja'=> '3', 'tipo'=> 'egreso', 'descripcion'=> 'comida', 'origen'=> None, 'idreferencia'=> None] );
        DB::table('pagos')->insert(['id'=> '20', 'fecha'=> '2025-11-05', 'estado'=> '1', 'monto'=> '2000.00', 'idpedidos'=> None, 'idmetodopagos'=> '1', 'idcaja'=> '4', 'tipo'=> 'egreso', 'descripcion'=> 'comida', 'origen'=> None, 'idreferencia'=> None] );
    }
}