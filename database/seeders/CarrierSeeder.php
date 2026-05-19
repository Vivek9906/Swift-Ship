<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Illuminate\Database\Seeder;

class CarrierSeeder extends Seeder
{
    public function run(): void
    {
        $carriers = [
            ['BlueDart',     'air',    'ops@bluedart.example',       94, 4.7, 80.0, 25.0, 0.80, 1, 3,  ['standard','express','same_day']],
            ['DTDC',         'ground', 'control@dtdc.example',        89, 4.2, 50.0, 18.0, 0.45, 3, 6,  ['standard','economy']],
            ['Delhivery',    'ground', 'network@delhivery.example',   92, 4.5, 60.0, 20.0, 0.55, 2, 5,  ['standard','express','economy']],
            ['Ecom Express', 'ground', 'support@ecomexpress.example', 87, 4.0, 45.0, 16.0, 0.40, 3, 7,  ['standard','economy']],
            ['India Post',   'ground', 'parcel@indiapost.example',    84, 3.9, 35.0, 12.0, 0.30, 5, 10, ['standard','economy']],
            ['FedEx India',  'air',    'ops@fedex.example',           96, 4.8, 100.0, 30.0, 1.00, 1, 2, ['standard','express','same_day']],
            ['Xpressbees',   'ground', 'ops@xpressbees.example',      90, 4.3, 55.0, 19.0, 0.50, 2, 5, ['standard','express']],
            ['Shadowfax',    'ground', 'ops@shadowfax.example',       91, 4.4, 58.0, 22.0, 0.52, 1, 3, ['standard','express','same_day']],
        ];

        foreach ($carriers as [$name, $type, $email, $rate, $rating, $base, $perKg, $perKm, $dMin, $dMax, $services]) {
            Carrier::updateOrCreate(['name' => $name], [
                'type'             => $type,
                'contact_email'    => $email,
                'on_time_rate'     => $rate,
                'rating'           => $rating,
                'active_shipments' => 0,
                'base_rate'        => $base,
                'per_kg_rate'      => $perKg,
                'per_km_rate'      => $perKm,
                'est_days_min'     => $dMin,
                'est_days_max'     => $dMax,
                'services'         => json_encode($services),
                'is_active'        => true,
            ]);
        }
    }
}
