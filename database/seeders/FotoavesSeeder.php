<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class FotoavesSeeder extends Seeder{
    public function run(){
        DB::table('fotoaves')->insert(['id'=> '15', 'nombrefoto'=> '1761287187_Captura de pantalla 2025-10-22 182806.png', 'idproductoaves'=> '1'] );
        DB::table('fotoaves')->insert(['id'=> '16', 'nombrefoto'=> '1761287187_foto2.png', 'idproductoaves'=> '1'] );
    }
}