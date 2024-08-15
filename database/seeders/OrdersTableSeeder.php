<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Order::factory(10)->create();
    }
}
