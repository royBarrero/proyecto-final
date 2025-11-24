<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ClientesSeeder extends Seeder{
    public function run(){
        DB::table('clientes')->insert(['id'=> '22', 'nombre'=> 'saturnino mamani', 'direccion'=> 'La salle', 'telefono'=> '79632222', 'idusuarios'=> '24', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '24', 'nombre'=> 'Samuel Torrico', 'direccion'=> None, 'telefono'=> '74559621', 'idusuarios'=> '26', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '23', 'nombre'=> 'Belisario Landa', 'direccion'=> None, 'telefono'=> '66254417', 'idusuarios'=> '25', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '30', 'nombre'=> 'Josue Vargas', 'direccion'=> None, 'telefono'=> None, 'idusuarios'=> '32', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '10', 'nombre'=> 'Daniel Suárez', 'direccion'=> 'Av. Alemana 99', 'telefono'=> '7894570', 'idusuarios'=> None, 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '11', 'nombre'=> 'Cristian Huari', 'direccion'=> 'Av. Siempre Viva 123', 'telefono'=> '7133571', 'idusuarios'=> None, 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '28', 'nombre'=> 'Jose Aguirre', 'direccion'=> None, 'telefono'=> '66852470', 'idusuarios'=> '30', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '1', 'nombre'=> 'Ana López', 'direccion'=> 'Av. Libertad 123', 'telefono'=> '7894561', 'idusuarios'=> '2', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '2', 'nombre'=> 'Carlos Ramos', 'direccion'=> 'Calle 10 #45', 'telefono'=> '7458962', 'idusuarios'=> '3', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '3', 'nombre'=> 'María López', 'direccion'=> 'Av. Principal 22', 'telefono'=> '76543210', 'idusuarios'=> '4', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '4', 'nombre'=> 'Pedro Ortiz', 'direccion'=> 'Zona Norte', 'telefono'=> '7894564', 'idusuarios'=> '5', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '5', 'nombre'=> 'Lucía García', 'direccion'=> 'Zona Sur', 'telefono'=> '7894565', 'idusuarios'=> '6', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '6', 'nombre'=> 'Roberto Díaz', 'direccion'=> 'Calle Bolívar', 'telefono'=> '7894566', 'idusuarios'=> '7', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '7', 'nombre'=> 'Sofía Vargas', 'direccion'=> 'Av. Cañoto 77', 'telefono'=> '7894567', 'idusuarios'=> '8', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '8', 'nombre'=> 'Daniel Guzmán', 'direccion'=> 'Zona Central', 'telefono'=> '7894568', 'idusuarios'=> '9', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '9', 'nombre'=> 'Laura Torres', 'direccion'=> 'Barrio Jardín', 'telefono'=> '7894569', 'idusuarios'=> '10', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '15', 'nombre'=> 'Asher Bustillos', 'direccion'=> 'Barrio Los Pinos, Zona arroyito', 'telefono'=> '33449283', 'idusuarios'=> '15', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '16', 'nombre'=> 'Luis Huari Choque', 'direccion'=> 'Barrio San Martín, Zona Plan 3000, Sobre avenida Panamericana', 'telefono'=> '71336373', 'idusuarios'=> '17', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '17', 'nombre'=> 'Santiago Huari Choque', 'direccion'=> 'Barrio San Martín, Zona Plan 3000, Sobre avenida Panamericana', 'telefono'=> '71336373', 'idusuarios'=> '18', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '19', 'nombre'=> 'Daniela Belen Ancalle Sejas', 'direccion'=> 'Cotoca', 'telefono'=> '78632222', 'idusuarios'=> '20', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '18', 'nombre'=> 'Yenny Jallasa Mamani', 'direccion'=> 'Plan 3000', 'telefono'=> '67884712', 'idusuarios'=> '19', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '20', 'nombre'=> 'Melissa Sanchez', 'direccion'=> 'Barrio los Cañas', 'telefono'=> '77451269', 'idusuarios'=> '22', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '21', 'nombre'=> 'Toribia Gallego', 'direccion'=> 'La pampa', 'telefono'=> '78852246', 'idusuarios'=> '23', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '32', 'nombre'=> 'Wilber Ortiz', 'direccion'=> None, 'telefono'=> '68990086', 'idusuarios'=> '34', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '31', 'nombre'=> 'Santiago Justo Huari', 'direccion'=> None, 'telefono'=> '67791098', 'idusuarios'=> '33', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '29', 'nombre'=> 'Melquiades Ancalle', 'direccion'=> None, 'telefono'=> '78556200', 'idusuarios'=> '31', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '33', 'nombre'=> 'Luis Morales', 'direccion'=> None, 'telefono'=> None, 'idusuarios'=> '35', 'activo'=> '1'] );
        DB::table('clientes')->insert(['id'=> '37', 'nombre'=> 'Pepe12 Gonzales', 'direccion'=> None, 'telefono'=> None, 'idusuarios'=> '39', 'activo'=> '1'] );
    }
}