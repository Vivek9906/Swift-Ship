<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\User;
use App\Models\Shipment;
use App\Models\Payment;
use App\Models\TrackingEvent;
use App\Models\ContactLead;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Core stats — ALL from real database
        $stats = [
            'total_customers' => User::customers()->count(),
            'total_shipments' => Shipment::count(),
            'active_shipments' => Shipment::active()->count(),
            'delivered_shipments' => Shipment::where('status', 'delivered')->count(),
            'cancelled_shipments' => Shipment::where('status', 'cancelled')->count(),
            'pending_payment' => Shipment::where('payment_status', 'pending')->count(),
            'total_revenue' => (float) (string) Payment::paid()->sum('amount'),
            'revenue_today' => (float) (string) Payment::paid()
                ->where('paid_at', '>=', today())->sum('amount'),
            'revenue_this_month' => (float) (string) Payment::paid()
                ->where('paid_at', '>=', now()->startOfMonth())->sum('amount'),
            'new_leads' => ContactLead::where('status', 'new')->count(),
            'new_customers_today' => User::customers()
                ->where('created_at', '>=', today())->count(),
        ];

        // Recent shipments with eager loading
        $recent_shipments = Shipment::with(['user', 'carrier', 'payment'])
            ->latest()->take(10)->get();

        // Recent customers
        $recent_customers = User::customers()
            ->with('profile')->latest()->take(5)->get();

        // Activity feed
        $activity_feed = TrackingEvent::with('shipment.user')
            ->latest()->take(15)->get();

        // Revenue chart — Mongo-compatible grouping
        $payments = Payment::paid()
            ->where('created_at', '>=', now()->subDays(30))
            ->get();
        $revenue_chart = $payments->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function ($row) {
            return (object) [
                'date' => $row->first()->created_at->format('Y-m-d'),
                'total' => $row->sum('amount')
            ];
        })->values();

        // Status chart
        $status_chart = Shipment::get(['status'])->groupBy('status')->map(function ($row, $key) {
            return (object) ['status' => $key, 'count' => $row->count()];
        })->values();

        // Carrier performance
        $carrier_stats = Carrier::all()->map(function ($carrier) {
            $shipmentIds = Shipment::where('carrier_id', $carrier->id)->pluck('_id');
            $carrier->shipments_count = $shipmentIds->count();
            $carrier->revenue = (float) (string) Payment::whereIn('shipment_id', $shipmentIds)
                ->paid()->sum('amount');
            return $carrier;
        });

        return view('admin.dashboard', compact(
            'stats',
            'recent_shipments',
            'recent_customers',
            'activity_feed',
            'revenue_chart',
            'status_chart',
            'carrier_stats'
        ));
    }
}
