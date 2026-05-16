<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Illuminate\Database\Seeder;

class CarrierSeeder extends Seeder
{
    public function run(): void
    {
        $carriers = [
            ['BlueDart', 'air', 'ops@bluedart.example', 94, 4.7],
            ['DTDC', 'ground', 'control@dtdc.example', 89, 4.2],
            ['Delhivery', 'ground', 'network@delhivery.example', 92, 4.5],
            ['Ecom Express', 'ground', 'support@ecomexpress.example', 87, 4.0],
            ['India Post', 'ground', 'parcel@indiapost.example', 84, 3.9],
        ];

        foreach ($carriers as [$name, $type, $email, $rate, $rating]) {
            Carrier::updateOrCreate(['name' => $name], [
                'type' => $type,
                'contact_email' => $email,
                'on_time_rate' => $rate,
                'rating' => $rating,
                'active_shipments' => 0,
            ]);
        }
    }
}
