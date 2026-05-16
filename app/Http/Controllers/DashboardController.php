<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Carbon\CarbonPeriod;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalShipments = Shipment::count();
        $inTransit = Shipment::whereIn('status', ['in_transit', 'arrived_at_city', 'out_for_delivery'])->count();
        $deliveredToday = Shipment::where('delivered_at', '>=', today()->startOfDay())
            ->where('delivered_at', '<', now()->addDay()->startOfDay())
            ->count();
        $delayed = Shipment::where('status', 'delayed')->count();
        $completed = Shipment::whereIn('status', ['delivered', 'delayed', 'failed'])->count();
        $onTimeRate = $completed > 0 ? round((Shipment::where('status', 'delivered')->count() / $completed) * 100) : 100;

        $period = CarbonPeriod::create(now()->subDays(6)->startOfDay(), now()->startOfDay());
        $lastSevenDays = collect($period)->map(function ($date) {
            return [
                'label' => $date->format('D'),
                'count' => Shipment::where('created_at', '>=', $date->copy()->startOfDay())
                    ->where('created_at', '<', $date->copy()->addDay()->startOfDay())
                    ->count(),
            ];
        });

        $statusBreakdown = collect(Shipment::STATUSES)->map(fn (string $status) => [
            'label' => str($status)->headline()->toString(),
            'count' => Shipment::where('status', $status)->count(),
        ]);

        $recentShipments = Shipment::with(['customer', 'carrier'])->latest()->take(5)->get();
        $activityFeed = Shipment::with(['customer', 'carrier', 'trackingEvents'])
            ->latest('updated_at')
            ->take(8)
            ->get();

        return view('dashboard.index', compact(
            'totalShipments',
            'inTransit',
            'deliveredToday',
            'delayed',
            'onTimeRate',
            'lastSevenDays',
            'statusBreakdown',
            'recentShipments',
            'activityFeed'
        ));
    }
}
