<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class CartsTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Cart::factory(5)->create();
    }
}
