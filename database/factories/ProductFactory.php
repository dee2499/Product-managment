<?php

declare(strict_types=1);

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
            'title' => fake()->sentence(3),
            'description' => '<p>'.implode('</p><p>', fake()->paragraphs(3)).'</p>',
            'price' => fake()->randomFloat(2, 1, 9999),
            'date_available' => fake()->dateTimeBetween('-1 month', '+6 months')->format('Y-m-d'),
        ];
    }
}
