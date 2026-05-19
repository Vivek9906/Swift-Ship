<?php

namespace Database\Factories;

use App\Models\Carrier;
use App\Models\user;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    public function definition(): array
    {
        $cities = array_keys(Shipment::CITY_COORDINATES);
        $origin = fake()->randomElement($cities);
        $destination = fake()->randomElement(array_values(array_diff($cities, [$origin])));
        $status = fake()->randomElement(Shipment::STATUSES);
        [$lat, $lng] = Shipment::CITY_COORDINATES[$origin];

        return [
            'user_id' => user::factory(),
            'carrier_id' => Carrier::factory(),
            'sender_name' => fake()->company(),
            'sender_city' => $origin,
            'receiver_name' => fake()->name(),
            'receiver_city' => $destination,
            'receiver_address' => fake()->streetAddress() . ', ' . $destination,
            'weight' => fake()->randomFloat(2, 0.5, 90),
            'dimensions' => fake()->numberBetween(20, 90) . 'x' . fake()->numberBetween(20, 90) . 'x' . fake()->numberBetween(10, 80) . ' cm',
            'status' => $status,
            'current_lat' => $lat,
            'current_lng' => $lng,
            'cost' => fake()->randomFloat(2, 180, 9400),
            'estimated_delivery' => now()->addHours(fake()->numberBetween(4, 96)),
            'delivered_at' => $status === 'delivered' ? now()->subHours(fake()->numberBetween(1, 48)) : null,
        ];
    }
}
