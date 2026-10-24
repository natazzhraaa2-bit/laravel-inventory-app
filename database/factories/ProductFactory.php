<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'sku' => fake()->unique()->bothify('PRD-###-????'),
            'name' => fake()->words(3, true),
            'price' => fake()->randomFloat(2, 10000, 1500000),
            'stock' => fake()->numberBetween(0, 50),
            'minimum_stock' => fake()->numberBetween(3, 10),
        ];
    }
}
