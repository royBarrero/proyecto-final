<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class VendedorsSeeder extends Seeder{
    public function run(){
        DB::table('vendedors')->insert({'id': '2', 'nombre': 'Roy Barrero', 'direccion': 'Av. Busch 21', 'telefono': '7422222', 'email': 'roybarrero@gmail.com', 'idusuarios': None, 'activo': '1'} );
        DB::table('vendedors')->insert({'id': '3', 'nombre': 'Melissa Sánchez', 'direccion': 'Calle Sucre 10', 'telefono': '7433333', 'email': 'melissasanchez@gmail.com', 'idusuarios': None, 'activo': '1'} );
        DB::table('vendedors')->insert({'id': '13', 'nombre': 'jonathan Chambi', 'direccion': None, 'telefono': None, 'email': 'jonathan@gmail.com', 'idusuarios': None, 'activo': '1'} );
        DB::table('vendedors')->insert({'id': '14', 'nombre': 'Alex Junior Ticona', 'direccion': None, 'telefono': None, 'email': 'alex.junior@gmail.com', 'idusuarios': None, 'activo': '1'} );
        DB::table('vendedors')->insert({'id': '15', 'nombre': 'Juan Padilla', 'direccion': None, 'telefono': None, 'email': 'juan@gmail.com', 'idusuarios': None, 'activo': '1'} );
        DB::table('vendedors')->insert({'id': '1', 'nombre': 'Limberg Huari', 'direccion': 'Zona Plan 3000', 'telefono': '7411111', 'email': 'limberg.huari@gmail.com', 'idusuarios': '1', 'activo': '1'} );
        DB::table('vendedors')->insert({'id': '17', 'nombre': 'Limberg Huari Choque', 'direccion': None, 'telefono': None, 'email': 'limberg6@gmail.com', 'idusuarios': '36', 'activo': '0'} );
        DB::table('vendedors')->insert({'id': '11', 'nombre': 'Cristian Huari', 'direccion': 'Barrio San Martín, Zona Plan 3000, Sobre avenida Panamericana', 'telefono': '71336373', 'email': 'cristoteam29@gmail.com', 'idusuarios': '16', 'activo': '1'} );
        DB::table('vendedors')->insert({'id': '12', 'nombre': 'Roy Barrero', 'direccion': 'Zona Norte, Barrio los norteños', 'telefono': '63224700', 'email': 'roy.barrero@gmail.com', 'idusuarios': '21', 'activo': '1'} );
    }
}