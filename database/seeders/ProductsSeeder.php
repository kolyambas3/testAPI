<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Samsung Galaxy S9',
                'cur' => 'usd',
                'price' => 698.88
            ],
            [
                'name' => 'Apple iPhone X',
                'cur' => 'usd',
                'price' => 983.00
            ],
            [
                'name' => 'Google Pixel 2 XL',
                'cur' => 'usd',
                'price' => 675.00
            ],
            [
                'name' => 'LG V10 H900',
                'cur' => 'usd',
                'price' => 159.99
            ],
            [
                'name' => 'Huawei Elate',
                'cur' => 'usd',
                'price' => 68.00
            ],
            [
                'name' => 'HTC One M10',
                'cur' => 'usd',
                'price' => 129.99
            ]
        ]);
    }
}
