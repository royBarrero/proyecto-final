<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DetallepedidosSeeder extends Seeder{
    public function run(){
        DB::table('detallepedidos')->insert(['id'=> '1', 'idpedidos'=> '1', 'idproductoaves'=> '1', 'cantidad'=> '5', 'preciounitario'=> '50.00', 'subtotal'=> '250.00'] );
        DB::table('detallepedidos')->insert(['id'=> '2', 'idpedidos'=> '2', 'idproductoaves'=> '2', 'cantidad'=> '6', 'preciounitario'=> '50.00', 'subtotal'=> '300.00'] );
        DB::table('detallepedidos')->insert(['id'=> '3', 'idpedidos'=> '3', 'idproductoaves'=> '3', 'cantidad'=> '7', 'preciounitario'=> '50.00', 'subtotal'=> '350.00'] );
        DB::table('detallepedidos')->insert(['id'=> '4', 'idpedidos'=> '4', 'idproductoaves'=> '4', 'cantidad'=> '8', 'preciounitario'=> '50.00', 'subtotal'=> '400.00'] );
        DB::table('detallepedidos')->insert(['id'=> '5', 'idpedidos'=> '5', 'idproductoaves'=> '5', 'cantidad'=> '9', 'preciounitario'=> '50.00', 'subtotal'=> '450.00'] );
        DB::table('detallepedidos')->insert(['id'=> '6', 'idpedidos'=> '6', 'idproductoaves'=> '6', 'cantidad'=> '10', 'preciounitario'=> '50.00', 'subtotal'=> '500.00'] );
        DB::table('detallepedidos')->insert(['id'=> '7', 'idpedidos'=> '7', 'idproductoaves'=> '7', 'cantidad'=> '11', 'preciounitario'=> '50.00', 'subtotal'=> '550.00'] );
        DB::table('detallepedidos')->insert(['id'=> '8', 'idpedidos'=> '8', 'idproductoaves'=> '8', 'cantidad'=> '12', 'preciounitario'=> '50.00', 'subtotal'=> '600.00'] );
        DB::table('detallepedidos')->insert(['id'=> '9', 'idpedidos'=> '9', 'idproductoaves'=> '9', 'cantidad'=> '13', 'preciounitario'=> '50.00', 'subtotal'=> '650.00'] );
        DB::table('detallepedidos')->insert(['id'=> '10', 'idpedidos'=> '10', 'idproductoaves'=> '10', 'cantidad'=> '14', 'preciounitario'=> '50.00', 'subtotal'=> '700.00'] );
    }
}