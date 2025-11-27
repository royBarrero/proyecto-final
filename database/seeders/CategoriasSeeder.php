<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategoriasSeeder extends Seeder{
    public function run(){
        DB::table('categorias')->insert(['id'=> '2', 'nombre'=> 'Alimentos', 'descripcion'=> 'Comida balanceada para aves'] );
        DB::table('categorias')->insert(['id'=> '3', 'nombre'=> 'Accesorios', 'descripcion'=> 'Jaulas, bebederos, comederos'] );
        DB::table('categorias')->insert(['id'=> '4', 'nombre'=> 'Medicinas', 'descripcion'=> 'Vitaminas y vacunas'] );
        DB::table('categorias')->insert(['id'=> '5', 'nombre'=> 'Carnes', 'descripcion'=> 'Carne de aves'] );
        DB::table('categorias')->insert(['id'=> '7', 'nombre'=> 'Servicios', 'descripcion'=> 'Servicios adicionales'] );
        DB::table('categorias')->insert(['id'=> '1', 'nombre'=> 'Aves', 'descripcion'=> 'Productos de aves vivos'] );
        DB::table('categorias')->insert(['id'=> '11', 'nombre'=> 'Alimento de engorde', 'descripcion'=> 'Balanceado para ponedoras'] );
        DB::table('categorias')->insert(['id'=> '8', 'nombre'=> 'Transporte', 'descripcion'=> 'Envío y logística'] );
        DB::table('categorias')->insert(['id'=> '13', 'nombre'=> 'Huevos', 'descripcion'=> 'Produccion de huevos'] );
    }
}