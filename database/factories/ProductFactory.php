<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            'name' => $this->fake()->word,
            'description' => $this->fake()->paragraph,
            'price' => $this->fake()->randomFloat(2, 1, 100),
            'quantity' => $this->fake()->numberBetween(1, 100),
            'image' => $this->fake()->imageUrl,
        ];
    }
}
