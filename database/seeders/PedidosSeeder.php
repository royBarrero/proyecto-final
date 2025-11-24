<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PedidosSeeder extends Seeder{
    public function run(){
        DB::table('pedidos')->insert({'id': '1', 'fecha': '2025-01-05', 'estado': '1', 'total': '250.00', 'idclientes': '1', 'idvendedors': '1'} );
        DB::table('pedidos')->insert({'id': '2', 'fecha': '2025-01-06', 'estado': '1', 'total': '300.00', 'idclientes': '2', 'idvendedors': '2'} );
        DB::table('pedidos')->insert({'id': '3', 'fecha': '2025-01-07', 'estado': '1', 'total': '350.00', 'idclientes': '3', 'idvendedors': '3'} );
        DB::table('pedidos')->insert({'id': '4', 'fecha': '2025-01-08', 'estado': '1', 'total': '400.00', 'idclientes': '4', 'idvendedors': '1'} );
        DB::table('pedidos')->insert({'id': '5', 'fecha': '2025-01-09', 'estado': '1', 'total': '450.00', 'idclientes': '5', 'idvendedors': '3'} );
        DB::table('pedidos')->insert({'id': '6', 'fecha': '2025-01-10', 'estado': '1', 'total': '500.00', 'idclientes': '6', 'idvendedors': '3'} );
        DB::table('pedidos')->insert({'id': '7', 'fecha': '2025-01-11', 'estado': '1', 'total': '550.00', 'idclientes': '7', 'idvendedors': '2'} );
        DB::table('pedidos')->insert({'id': '8', 'fecha': '2025-01-12', 'estado': '1', 'total': '600.00', 'idclientes': '8', 'idvendedors': '1'} );
        DB::table('pedidos')->insert({'id': '9', 'fecha': '2025-01-13', 'estado': '1', 'total': '650.00', 'idclientes': '9', 'idvendedors': '2'} );
        DB::table('pedidos')->insert({'id': '10', 'fecha': '2025-01-14', 'estado': '1', 'total': '700.00', 'idclientes': '10', 'idvendedors': '1'} );
    }
}