<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProductoavesSeeder extends Seeder{
    public function run(){
        DB::table('productoaves')->insert(['id'=> '2', 'nombre'=> 'pollo', 'precio'=> '45.00', 'idcategorias'=> '1', 'iddetalleaves'=> '2', 'cantidad'=> '200'] );
        DB::table('productoaves')->insert(['id'=> '3', 'nombre'=> 'pollo', 'precio'=> '50.00', 'idcategorias'=> '1', 'iddetalleaves'=> '3', 'cantidad'=> '50'] );
        DB::table('productoaves')->insert(['id'=> '4', 'nombre'=> 'pollo', 'precio'=> '80.00', 'idcategorias'=> '1', 'iddetalleaves'=> '4', 'cantidad'=> '300'] );
        DB::table('productoaves')->insert(['id'=> '5', 'nombre'=> 'pollo', 'precio'=> '25.00', 'idcategorias'=> '1', 'iddetalleaves'=> '5', 'cantidad'=> '120'] );
        DB::table('productoaves')->insert(['id'=> '6', 'nombre'=> 'pollo', 'precio'=> '100.00', 'idcategorias'=> '1', 'iddetalleaves'=> '6', 'cantidad'=> '90'] );
        DB::table('productoaves')->insert(['id'=> '7', 'nombre'=> 'pollo', 'precio'=> '45.00', 'idcategorias'=> '1', 'iddetalleaves'=> '7', 'cantidad'=> '60'] );
        DB::table('productoaves')->insert(['id'=> '8', 'nombre'=> 'pollo', 'precio'=> '60.00', 'idcategorias'=> '1', 'iddetalleaves'=> '8', 'cantidad'=> '110'] );
        DB::table('productoaves')->insert(['id'=> '9', 'nombre'=> 'pollo', 'precio'=> '55.00', 'idcategorias'=> '1', 'iddetalleaves'=> '9', 'cantidad'=> '150'] );
        DB::table('productoaves')->insert(['id'=> '10', 'nombre'=> 'pollo', 'precio'=> '65.00', 'idcategorias'=> '1', 'iddetalleaves'=> '10', 'cantidad'=> '75'] );
        DB::table('productoaves')->insert(['id'=> '11', 'nombre'=> 'pollo', 'precio'=> '85.50', 'idcategorias'=> '1', 'iddetalleaves'=> '11', 'cantidad'=> '0'] );
        DB::table('productoaves')->insert(['id'=> '14', 'nombre'=> 'pollo', 'precio'=> '85.50', 'idcategorias'=> '1', 'iddetalleaves'=> '13', 'cantidad'=> '0'] );
        DB::table('productoaves')->insert(['id'=> '1', 'nombre'=> 'pollo', 'precio'=> '40.00', 'idcategorias'=> '1', 'iddetalleaves'=> '1', 'cantidad'=> '100'] );
    }
}