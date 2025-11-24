<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProductoalimentosSeeder extends Seeder{
    public function run(){
        DB::table('productoalimentos')->insert({'id': '1', 'nombre': 'Maíz molido', 'precio': '50.00'} );
        DB::table('productoalimentos')->insert({'id': '2', 'nombre': 'Trigo', 'precio': '45.00'} );
        DB::table('productoalimentos')->insert({'id': '3', 'nombre': 'Sorgo', 'precio': '55.00'} );
        DB::table('productoalimentos')->insert({'id': '4', 'nombre': 'Afrecho', 'precio': '60.00'} );
        DB::table('productoalimentos')->insert({'id': '5', 'nombre': 'Balanceado 10kg', 'precio': '70.00'} );
        DB::table('productoalimentos')->insert({'id': '6', 'nombre': 'Balanceado 25kg', 'precio': '150.00'} );
        DB::table('productoalimentos')->insert({'id': '7', 'nombre': 'Vitaminas A', 'precio': '40.00'} );
        DB::table('productoalimentos')->insert({'id': '8', 'nombre': 'Vitaminas B', 'precio': '45.00'} );
        DB::table('productoalimentos')->insert({'id': '9', 'nombre': 'Vitaminas C', 'precio': '60.00'} );
        DB::table('productoalimentos')->insert({'id': '10', 'nombre': 'Mezcla Premium', 'precio': '200.00'} );
    }
}