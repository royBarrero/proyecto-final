<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MetodopagosSeeder extends Seeder{
    public function run(){
        DB::table('metodopagos')->insert(['id'=> '1', 'descripcion'=> 'Efectivo'] );
        DB::table('metodopagos')->insert(['id'=> '2', 'descripcion'=> 'Tarjeta de Débito'] );
        DB::table('metodopagos')->insert(['id'=> '3', 'descripcion'=> 'Tarjeta de Crédito'] );
        DB::table('metodopagos')->insert(['id'=> '4', 'descripcion'=> 'Transferencia Bancaria'] );
        DB::table('metodopagos')->insert(['id'=> '5', 'descripcion'=> 'Yape'] );
        DB::table('metodopagos')->insert(['id'=> '6', 'descripcion'=> 'QR'] );
        DB::table('metodopagos')->insert(['id'=> '7', 'descripcion'=> 'Cheque'] );
        DB::table('metodopagos')->insert(['id'=> '8', 'descripcion'=> 'Depósito'] );
        DB::table('metodopagos')->insert(['id'=> '9', 'descripcion'=> 'Crédito'] );
        DB::table('metodopagos')->insert(['id'=> '10', 'descripcion'=> 'Pago en línea'] );
    }
}