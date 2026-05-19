<?php

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class userFactory extends Factory
{
    public function definition(): array
    {
        $city = fake()->randomElement(array_keys(Shipment::CITY_COORDINATES));

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+91 ' . fake()->numerify('9#########'),
            'address' => fake()->streetAddress() . ', ' . $city,
            'city' => $city,
            'status' => fake()->randomElement(['active', 'active', 'inactive']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
