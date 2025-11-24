<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ComprasSeeder extends Seeder{
    public function run(){
        DB::table('compras')->insert(['id'=> '1', 'fecha'=> '2025-01-02', 'estado'=> '1', 'total'=> '150.00', 'idproveedors'=> '1', 'idvendedors'=> '1'] );
        DB::table('compras')->insert(['id'=> '2', 'fecha'=> '2025-01-03', 'estado'=> '1', 'total'=> '200.00', 'idproveedors'=> '2', 'idvendedors'=> '2'] );
        DB::table('compras')->insert(['id'=> '3', 'fecha'=> '2025-01-04', 'estado'=> '1', 'total'=> '250.00', 'idproveedors'=> '3', 'idvendedors'=> '2'] );
        DB::table('compras')->insert(['id'=> '4', 'fecha'=> '2025-01-05', 'estado'=> '1', 'total'=> '300.00', 'idproveedors'=> '3', 'idvendedors'=> '1'] );
        DB::table('compras')->insert(['id'=> '5', 'fecha'=> '2025-01-06', 'estado'=> '1', 'total'=> '350.00', 'idproveedors'=> '3', 'idvendedors'=> '3'] );
        DB::table('compras')->insert(['id'=> '6', 'fecha'=> '2025-01-07', 'estado'=> '1', 'total'=> '400.00', 'idproveedors'=> '2', 'idvendedors'=> '1'] );
        DB::table('compras')->insert(['id'=> '7', 'fecha'=> '2025-01-08', 'estado'=> '1', 'total'=> '450.00', 'idproveedors'=> '1', 'idvendedors'=> '3'] );
        DB::table('compras')->insert(['id'=> '8', 'fecha'=> '2025-01-09', 'estado'=> '1', 'total'=> '500.00', 'idproveedors'=> '1', 'idvendedors'=> '3'] );
        DB::table('compras')->insert(['id'=> '9', 'fecha'=> '2025-01-10', 'estado'=> '1', 'total'=> '550.00', 'idproveedors'=> '2', 'idvendedors'=> '2'] );
        DB::table('compras')->insert(['id'=> '10', 'fecha'=> '2025-01-11', 'estado'=> '1', 'total'=> '600.00', 'idproveedors'=> '3', 'idvendedors'=> '1'] );
    }
}