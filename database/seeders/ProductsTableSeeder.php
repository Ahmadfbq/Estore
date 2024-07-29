<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Basic Tee',
                'href' => '#',
                'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg',
                'imageAlt' => "Front of men's Basic Tee in black.",
                'price' => 35.00,
                'color' => 'Black',
                'quantity' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more products as needed...
        ]);
    }
}
