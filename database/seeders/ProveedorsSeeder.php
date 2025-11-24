<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProveedorsSeeder extends Seeder{
    public function run(){
        DB::table('proveedors')->insert({'id': '1', 'nombre': 'NutriAvicola S.R.L.', 'direccion': 'Av. Alemana 123', 'telefono': '7001111'} );
        DB::table('proveedors')->insert({'id': '2', 'nombre': 'Avícola Integral S.A.', 'direccion': 'Av. San Martín 45', 'telefono': '7002222'} );
        DB::table('proveedors')->insert({'id': '3', 'nombre': 'Balanceados Sofía', 'direccion': 'Av. Mutualista 10', 'telefono': '7003333'} );
        DB::table('proveedors')->insert({'id': '5', 'nombre': 'Alimentos Rico Ave', 'direccion': 'Av. Santos Dumont 55', 'telefono': '7005555'} );
        DB::table('proveedors')->insert({'id': '6', 'nombre': 'ProAgro Bolivia', 'direccion': 'Calle Ñuflo de Chávez 77', 'telefono': '7006666'} );
        DB::table('proveedors')->insert({'id': '7', 'nombre': 'AgroGrain Import', 'direccion': 'Av. Radial 10', 'telefono': '7007777'} );
        DB::table('proveedors')->insert({'id': '8', 'nombre': 'VitaMix Aves', 'direccion': 'Av. 3 Pasos al Frente 88', 'telefono': '7008888'} );
        DB::table('proveedors')->insert({'id': '9', 'nombre': 'Proteínas del Valle', 'direccion': 'Av. Grigotá 99', 'telefono': '7009999'} );
        DB::table('proveedors')->insert({'id': '10', 'nombre': 'AgroAvícola Santa Cruz', 'direccion': 'Zona Norte 11', 'telefono': '7010000'} );
        DB::table('proveedors')->insert({'id': '4', 'nombre': 'Granos del Oriente', 'direccion': 'Zona Plan 3001', 'telefono': '7004410'} );
    }
}