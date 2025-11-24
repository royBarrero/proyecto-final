<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MigrationsSeeder extends Seeder{
    public function run(){
        DB::table('migrations')->insert({'id': ''} );
    }
}