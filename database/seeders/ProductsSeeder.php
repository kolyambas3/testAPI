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
            'name' => 'Samsung Galaxy S9',
            'cur' => 'usd',
            'price' => 698.88
        ]);
        DB::table('products')->insert([
            'name' => 'Apple iPhone X',
            'cur' => 'usd',
            'price' => 983.00
        ]);
        DB::table('products')->insert([
            'name' => 'Google Pixel 2 XL',
            'cur' => 'usd',
            'price' => 675.00
        ]);
        DB::table('products')->insert([
            'name' => 'LG V10 H900',
            'cur' => 'usd',
            'price' => 159.99
        ]);
        DB::table('products')->insert([
            'name' => 'Huawei Elate',
            'cur' => 'usd',
            'price' => 68.00
        ]);
        DB::table('products')->insert([
            'name' => 'HTC One M10',
            'cur' => 'usd',
            'price' => 129.99
        ]);
    }
}
