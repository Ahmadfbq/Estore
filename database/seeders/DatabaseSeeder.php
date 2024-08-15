<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Product::factory(10)->create();
        Cart::factory(10)->create();
        Order::factory(10)->create()->each(function ($order) {
            OrderProduct::factory(3)->create(['order_id' => $order->id]);
        });
    }
}
