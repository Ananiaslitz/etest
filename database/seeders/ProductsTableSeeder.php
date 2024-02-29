<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Celular 1', 'price' => 1800.00, 'description' => 'Lorenzo Ipsulum'],
            ['name' => 'Celular 2', 'price' => 3200.00, 'description' => 'Lorem ipsum dolor'],
            ['name' => 'Celular 3', 'price' => 9800.00, 'description' => 'Lorem ipsum dolor sit amet'],
        ]);
    }
}
