<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarrierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'type' => fake()->randomElement(['air', 'ground', 'sea']),
            'contact_email' => fake()->companyEmail(),
            'on_time_rate' => fake()->numberBetween(82, 98),
            'rating' => fake()->randomFloat(1, 3.5, 4.9),
            'active_shipments' => 0,
        ];
    }
}
