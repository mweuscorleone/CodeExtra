<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucwords($this->faker->words(3, true)),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 100, 5000)
        ];
    }
}
