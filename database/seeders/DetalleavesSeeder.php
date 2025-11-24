<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DetalleavesSeeder extends Seeder{
    public function run(){
        DB::table('detalleaves')->insert(['id'=> '1', 'descripcion'=> 'Sussex', 'edad'=> '0-7'] );
        DB::table('detalleaves')->insert(['id'=> '2', 'descripcion'=> 'Sussex', 'edad'=> '8-14'] );
        DB::table('detalleaves')->insert(['id'=> '3', 'descripcion'=> 'Sussex', 'edad'=> '15-28'] );
        DB::table('detalleaves')->insert(['id'=> '4', 'descripcion'=> 'Sussex', 'edad'=> '28-*'] );
        DB::table('detalleaves')->insert(['id'=> '6', 'descripcion'=> 'Rhode Island Red', 'edad'=> '8-14'] );
        DB::table('detalleaves')->insert(['id'=> '7', 'descripcion'=> 'Rhode Island Red', 'edad'=> '15-28'] );
        DB::table('detalleaves')->insert(['id'=> '8', 'descripcion'=> 'Rhode Island Red', 'edad'=> '28-*'] );
        DB::table('detalleaves')->insert(['id'=> '9', 'descripcion'=> 'Plymouth Rock', 'edad'=> '0-7'] );
        DB::table('detalleaves')->insert(['id'=> '10', 'descripcion'=> 'Plymouth Rock', 'edad'=> '8-14'] );
        DB::table('detalleaves')->insert(['id'=> '11', 'descripcion'=> 'Plymouth Rock', 'edad'=> '15-28'] );
        DB::table('detalleaves')->insert(['id'=> '12', 'descripcion'=> 'Plymouth Rock', 'edad'=> '28-*'] );
        DB::table('detalleaves')->insert(['id'=> '13', 'descripcion'=> 'Orpington', 'edad'=> '0-7'] );
        DB::table('detalleaves')->insert(['id'=> '14', 'descripcion'=> 'Orpington', 'edad'=> '8-14'] );
        DB::table('detalleaves')->insert(['id'=> '15', 'descripcion'=> 'Orpington', 'edad'=> '15-28'] );
        DB::table('detalleaves')->insert(['id'=> '16', 'descripcion'=> 'Orpington', 'edad'=> '28-*'] );
        DB::table('detalleaves')->insert(['id'=> '17', 'descripcion'=> 'Australorp', 'edad'=> '0-7'] );
        DB::table('detalleaves')->insert(['id'=> '18', 'descripcion'=> 'Australorp', 'edad'=> '8-14'] );
        DB::table('detalleaves')->insert(['id'=> '19', 'descripcion'=> 'Australorp', 'edad'=> '15-28'] );
        DB::table('detalleaves')->insert(['id'=> '20', 'descripcion'=> 'Australorp', 'edad'=> '28-*'] );
        DB::table('detalleaves')->insert(['id'=> '21', 'descripcion'=> 'Brahma (gigante)', 'edad'=> '0-7'] );
        DB::table('detalleaves')->insert(['id'=> '22', 'descripcion'=> 'Brahma (gigante)', 'edad'=> '8-14'] );
        DB::table('detalleaves')->insert(['id'=> '23', 'descripcion'=> 'Brahma (gigante)', 'edad'=> '15-28'] );
        DB::table('detalleaves')->insert(['id'=> '24', 'descripcion'=> 'Brahma (gigante)', 'edad'=> '28-*'] );
        DB::table('detalleaves')->insert(['id'=> '25', 'descripcion'=> 'Leghorn', 'edad'=> '0-7'] );
        DB::table('detalleaves')->insert(['id'=> '26', 'descripcion'=> 'Leghorn', 'edad'=> '8-14'] );
        DB::table('detalleaves')->insert(['id'=> '27', 'descripcion'=> 'Leghorn', 'edad'=> '15-28'] );
        DB::table('detalleaves')->insert(['id'=> '28', 'descripcion'=> 'Leghorn', 'edad'=> '28-*'] );
        DB::table('detalleaves')->insert(['id'=> '5', 'descripcion'=> 'Rhode Islam Red', 'edad'=> '0-7'] );
    }
}