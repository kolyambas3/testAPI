<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            [
                'cur' => 'usd',
                'price' => 1400.88,
                'products' => json_encode([
                    'name' => 'Samsung Galaxy S9',
                    'cur' => 'usd',
                    'qty' => '2',
                    'sum' => '1400.88'
                ])
            ],
            [
                'cur' => 'usd',
                'price' => 3401.76,
                'products' => json_encode(
                    [
                        'name' => 'Samsung Galaxy S9',
                        'cur' => 'usd',
                        'qty' => 2,
                        'sum' => 1400.88
                    ],
                    [
                        'name' => 'Apple iPhone X',
                        'cur' => 'usd',
                        'qty' => 2,
                        'sum' => 2000.88
                    ]
                )
            ]

        ]);
    }
}
