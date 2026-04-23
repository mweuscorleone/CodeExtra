<?php

namespace Database\Factories;

use App\Models\UserRating;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserRating>
 */
class UserRatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::pluck('id')->random(),
            'product_id' => \App\Models\Product::pluck('id')->random(),
            'rating' => fake()->numberBetween(1, 5),
            'rate_datetime' => fake()->datetimeBetween('-1 day', 'now')
         ];
    }
}
