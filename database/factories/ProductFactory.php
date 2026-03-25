<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => fake()->numberBetween(1, 5),

            'name' => [
                'uz' => fake()->words(3, true),
                'ru' => fake()->words(3, true),
                'tj' => fake()->words(3, true),
            ],

            'price' => fake()->numberBetween(50, 10000),

            'description' => [
                'uz' => fake()->paragraph(),
                'ru' => fake()->paragraph(),
                'tj' => fake()->paragraph(),
            ],
        ];
    }
}