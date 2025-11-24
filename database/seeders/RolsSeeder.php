<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RolsSeeder extends Seeder{
    public function run(){
        DB::table('rols')->insert(['id'=> '2', 'descripcion'=> 'Cliente'] );
        DB::table('rols')->insert(['id'=> '1', 'descripcion'=> 'Vendedor'] );
        DB::table('rols')->insert(['id'=> '3', 'descripcion'=> 'Dueño del negocio'] );
    }
}