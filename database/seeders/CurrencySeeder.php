<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'code' => 'usd',
            'course' => 1
        ]);
        DB::table('currencies')->insert([
            'code' => 'rub',
            'course' => 1.2
        ]);
        DB::table('currencies')->insert([
            'code' => 'eur',
            'course' => 0.8
        ]);
    }
}
