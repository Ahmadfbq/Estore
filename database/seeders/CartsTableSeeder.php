<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CartsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('carts')->insert([
            [
                'product_id' => 1,
                'quantity' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more cart items as needed...
        ]);
    }
}
