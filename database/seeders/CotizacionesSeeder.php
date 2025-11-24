<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CotizacionesSeeder extends Seeder{
    public function run(){
        DB::table('cotizaciones')->insert({'id': '1', 'fecha': '2025-01-05', 'total': '500.00', 'validez': '10', 'idclientes': '1'} );
        DB::table('cotizaciones')->insert({'id': '2', 'fecha': '2025-01-06', 'total': '600.00', 'validez': '10', 'idclientes': '2'} );
        DB::table('cotizaciones')->insert({'id': '3', 'fecha': '2025-01-07', 'total': '700.00', 'validez': '10', 'idclientes': '3'} );
        DB::table('cotizaciones')->insert({'id': '4', 'fecha': '2025-01-08', 'total': '800.00', 'validez': '10', 'idclientes': '4'} );
        DB::table('cotizaciones')->insert({'id': '5', 'fecha': '2025-01-09', 'total': '900.00', 'validez': '10', 'idclientes': '5'} );
        DB::table('cotizaciones')->insert({'id': '6', 'fecha': '2025-01-10', 'total': '1000.00', 'validez': '10', 'idclientes': '6'} );
        DB::table('cotizaciones')->insert({'id': '7', 'fecha': '2025-01-11', 'total': '1100.00', 'validez': '10', 'idclientes': '7'} );
        DB::table('cotizaciones')->insert({'id': '8', 'fecha': '2025-01-12', 'total': '1200.00', 'validez': '10', 'idclientes': '8'} );
        DB::table('cotizaciones')->insert({'id': '9', 'fecha': '2025-01-13', 'total': '1300.00', 'validez': '10', 'idclientes': '9'} );
        DB::table('cotizaciones')->insert({'id': '10', 'fecha': '2025-01-14', 'total': '1400.00', 'validez': '10', 'idclientes': '10'} );
    }
}