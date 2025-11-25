<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DetallecotizacionesSeeder extends Seeder{
    public function run(){
        DB::table('detallecotizaciones')->insert(['id'=> '1', 'idcotizaciones'=> '1', 'idproductoaves'=> '1', 'cantidad'=> '10', 'preciounitario'=> '50.00', 'subtotal'=> '500.00'] );
        DB::table('detallecotizaciones')->insert(['id'=> '2', 'idcotizaciones'=> '2', 'idproductoaves'=> '2', 'cantidad'=> '12', 'preciounitario'=> '50.00', 'subtotal'=> '600.00'] );
        DB::table('detallecotizaciones')->insert(['id'=> '3', 'idcotizaciones'=> '3', 'idproductoaves'=> '3', 'cantidad'=> '14', 'preciounitario'=> '50.00', 'subtotal'=> '700.00'] );
        DB::table('detallecotizaciones')->insert(['id'=> '4', 'idcotizaciones'=> '4', 'idproductoaves'=> '4', 'cantidad'=> '16', 'preciounitario'=> '50.00', 'subtotal'=> '800.00'] );
        DB::table('detallecotizaciones')->insert(['id'=> '5', 'idcotizaciones'=> '5', 'idproductoaves'=> '5', 'cantidad'=> '18', 'preciounitario'=> '50.00', 'subtotal'=> '900.00'] );
        DB::table('detallecotizaciones')->insert(['id'=> '6', 'idcotizaciones'=> '6', 'idproductoaves'=> '6', 'cantidad'=> '20', 'preciounitario'=> '50.00', 'subtotal'=> '1000.00'] );
        DB::table('detallecotizaciones')->insert(['id'=> '7', 'idcotizaciones'=> '7', 'idproductoaves'=> '7', 'cantidad'=> '22', 'preciounitario'=> '50.00', 'subtotal'=> '1100.00'] );
        DB::table('detallecotizaciones')->insert(['id'=> '8', 'idcotizaciones'=> '8', 'idproductoaves'=> '8', 'cantidad'=> '24', 'preciounitario'=> '50.00', 'subtotal'=> '1200.00'] );
        DB::table('detallecotizaciones')->insert(['id'=> '9', 'idcotizaciones'=> '9', 'idproductoaves'=> '9', 'cantidad'=> '26', 'preciounitario'=> '50.00', 'subtotal'=> '1300.00'] );
        DB::table('detallecotizaciones')->insert(['id'=> '10', 'idcotizaciones'=> '10', 'idproductoaves'=> '10', 'cantidad'=> '28', 'preciounitario'=> '50.00', 'subtotal'=> '1400.00'] );
    }
}