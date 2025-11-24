<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class StocksSeeder extends Seeder{
    public function run(){
        DB::table('stocks')->insert({'id': '1', 'cantidad': '100', 'estado': 'n', 'fecha': '2025-01-10', 'idproductoaves': '1'} );
        DB::table('stocks')->insert({'id': '2', 'cantidad': '200', 'estado': 'n', 'fecha': '2025-01-15', 'idproductoaves': '2'} );
        DB::table('stocks')->insert({'id': '3', 'cantidad': '50', 'estado': 'n', 'fecha': '2025-01-20', 'idproductoaves': '3'} );
        DB::table('stocks')->insert({'id': '4', 'cantidad': '300', 'estado': 'n', 'fecha': '2025-01-22', 'idproductoaves': '4'} );
        DB::table('stocks')->insert({'id': '5', 'cantidad': '120', 'estado': 'n', 'fecha': '2025-01-25', 'idproductoaves': '5'} );
        DB::table('stocks')->insert({'id': '6', 'cantidad': '90', 'estado': 'n', 'fecha': '2025-01-27', 'idproductoaves': '6'} );
        DB::table('stocks')->insert({'id': '7', 'cantidad': '60', 'estado': 'n', 'fecha': '2025-01-30', 'idproductoaves': '7'} );
        DB::table('stocks')->insert({'id': '8', 'cantidad': '110', 'estado': 'n', 'fecha': '2025-02-01', 'idproductoaves': '8'} );
        DB::table('stocks')->insert({'id': '9', 'cantidad': '150', 'estado': 'n', 'fecha': '2025-02-05', 'idproductoaves': '9'} );
        DB::table('stocks')->insert({'id': '10', 'cantidad': '75', 'estado': 'n', 'fecha': '2025-02-08', 'idproductoaves': '10'} );
        DB::table('stocks')->insert({'id': '11', 'cantidad': '10', 'estado': 'n', 'fecha': '2025-09-12', 'idproductoaves': '11'} );
        DB::table('stocks')->insert({'id': '12', 'cantidad': '-10', 'estado': 'm', 'fecha': '2025-09-12', 'idproductoaves': '11'} );
    }
}