<?php

namespace Database\Seeders;

use App\Models\Carrier;
use App\Models\user;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        $users = user::all();
        $carriers = Carrier::all();
        $cities = array_keys(Shipment::CITY_COORDINATES);
        $statuses = ['pending', 'in_transit', 'arrived_at_city', 'out_for_delivery', 'delivered', 'delayed', 'failed'];
        $milestones = ['pending', 'in_transit', 'arrived_at_city', 'out_for_delivery', 'delivered'];

        for ($i = 0; $i < 30; $i++) {
            $origin = $cities[$i % count($cities)];
            $destination = $cities[($i + 4) % count($cities)];
            $status = $statuses[$i % count($statuses)];
            $progress = match ($status) {
                'pending' => 0.05,
                'in_transit' => 0.45,
                'arrived_at_city' => 0.88,
                'out_for_delivery' => 0.96,
                'delivered' => 1,
                'delayed' => 0.55,
                'failed' => 0.8,
            };
            $originPoint = Shipment::CITY_COORDINATES[$origin];
            $destinationPoint = Shipment::CITY_COORDINATES[$destination];
            $lat = $originPoint[0] + (($destinationPoint[0] - $originPoint[0]) * $progress);
            $lng = $originPoint[1] + (($destinationPoint[1] - $originPoint[1]) * $progress);

            $shipment = Shipment::create([
                'user_id' => $users[$i % $users->count()]->id,
                'carrier_id' => $carriers[$i % $carriers->count()]->id,
                'sender_name' => 'Northstar FC ' . ($i + 1),
                'sender_city' => $origin,
                'receiver_name' => $users[$i % $users->count()]->name,
                'receiver_city' => $destination,
                'receiver_address' => (100 + $i) . ', Industrial Link Road, ' . $destination,
                'weight' => random_int(5, 750) / 10,
                'dimensions' => random_int(20, 80) . 'x' . random_int(20, 70) . 'x' . random_int(10, 60) . ' cm',
                'status' => $status,
                'current_lat' => $lat,
                'current_lng' => $lng,
                'cost' => random_int(25000, 950000) / 100,
                'estimated_delivery' => now()->addHours(random_int(4, 120)),
                'delivered_at' => $status === 'delivered' ? now()->subHours(random_int(2, 36)) : null,
                'created_at' => now()->subDays(random_int(0, 9))->subHours(random_int(1, 12)),
            ]);

            $lastMilestone = array_search($status === 'failed' || $status === 'delayed' ? 'in_transit' : $status, $milestones, true);
            $lastMilestone = $lastMilestone === false ? 1 : $lastMilestone;

            foreach (array_slice($milestones, 0, $lastMilestone + 1) as $step => $eventStatus) {
                $point = $step < 2 ? $originPoint : $destinationPoint;
                TrackingEvent::create([
                    'shipment_id' => $shipment->id,
                    'status' => $eventStatus,
                    'location_name' => $step < 2 ? $origin : $destination,
                    'lat' => $point[0],
                    'lng' => $point[1],
                    'description' => str($eventStatus)->headline() . ' scan recorded.',
                    'occurred_at' => $shipment->created_at->copy()->addHours($step * 9),
                ]);
            }

            if (in_array($status, ['delayed', 'failed'], true)) {
                TrackingEvent::create([
                    'shipment_id' => $shipment->id,
                    'status' => $status,
                    'location_name' => 'Network exception desk',
                    'lat' => $lat,
                    'lng' => $lng,
                    'description' => $status === 'delayed' ? 'Delay investigation opened.' : 'Delivery attempt failed.',
                    'occurred_at' => now()->subHours(random_int(1, 8)),
                ]);
            }
        }

        Carrier::query()->each(function (Carrier $carrier) {
            $carrier->update([
                'active_shipments' => $carrier->shipments()->whereIn('status', ['in_transit', 'arrived_at_city', 'out_for_delivery'])->count(),
            ]);
        });
    }
}
