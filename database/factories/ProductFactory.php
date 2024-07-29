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
            'name' => fake()->word,
            'description' => fake()->paragraph,
            'price' => fake()->randomFloat(2, 1, 100),
            'quantity' => fake()->numberBetween(1, 100),
            'image' => fake()->imageUrl,
            'imageAlt' => fake()->sentence,
        ];
    }
}
