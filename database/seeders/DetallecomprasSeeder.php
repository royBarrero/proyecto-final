<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DetallecomprasSeeder extends Seeder{
    public function run(){
        DB::table('detallecompras')->insert(['id'=> '1', 'idcompras'=> '1', 'idproductoalimentos'=> '1', 'cantidad'=> '10', 'preciounitario'=> '15.00', 'subtotal'=> '150.00'] );
        DB::table('detallecompras')->insert(['id'=> '2', 'idcompras'=> '2', 'idproductoalimentos'=> '2', 'cantidad'=> '20', 'preciounitario'=> '10.00', 'subtotal'=> '200.00'] );
        DB::table('detallecompras')->insert(['id'=> '3', 'idcompras'=> '3', 'idproductoalimentos'=> '3', 'cantidad'=> '25', 'preciounitario'=> '10.00', 'subtotal'=> '250.00'] );
        DB::table('detallecompras')->insert(['id'=> '4', 'idcompras'=> '4', 'idproductoalimentos'=> '4', 'cantidad'=> '30', 'preciounitario'=> '10.00', 'subtotal'=> '300.00'] );
        DB::table('detallecompras')->insert(['id'=> '5', 'idcompras'=> '5', 'idproductoalimentos'=> '5', 'cantidad'=> '35', 'preciounitario'=> '10.00', 'subtotal'=> '350.00'] );
        DB::table('detallecompras')->insert(['id'=> '6', 'idcompras'=> '6', 'idproductoalimentos'=> '6', 'cantidad'=> '40', 'preciounitario'=> '10.00', 'subtotal'=> '400.00'] );
        DB::table('detallecompras')->insert(['id'=> '7', 'idcompras'=> '7', 'idproductoalimentos'=> '7', 'cantidad'=> '45', 'preciounitario'=> '10.00', 'subtotal'=> '450.00'] );
        DB::table('detallecompras')->insert(['id'=> '8', 'idcompras'=> '8', 'idproductoalimentos'=> '8', 'cantidad'=> '50', 'preciounitario'=> '10.00', 'subtotal'=> '500.00'] );
        DB::table('detallecompras')->insert(['id'=> '9', 'idcompras'=> '9', 'idproductoalimentos'=> '9', 'cantidad'=> '55', 'preciounitario'=> '10.00', 'subtotal'=> '550.00'] );
        DB::table('detallecompras')->insert(['id'=> '10', 'idcompras'=> '10', 'idproductoalimentos'=> '10', 'cantidad'=> '60', 'preciounitario'=> '10.00', 'subtotal'=> '600.00'] );
    }
}