<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarrierController extends Controller
{
    public function index(Request $request): View
    {
        $carriers = Carrier::filter($request->only(['search', 'type']))
            ->orderByDesc('on_time_rate')
            ->paginate(15)
            ->withQueryString();

        return view('carriers.index', compact('carriers'));
    }

    public function show(Carrier $carrier): View
    {
        $carrier->load(['shipments.user']);
        $metrics = [
            'total' => $carrier->shipments->count(),
            'active' => $carrier->shipments->whereIn('status', ['in_transit', 'arrived_at_city', 'out_for_delivery'])->count(),
            'delayed' => $carrier->shipments->where('status', 'delayed')->count(),
            'delivered' => $carrier->shipments->where('status', 'delivered')->count(),
        ];

        return view('carriers.show', compact('carrier', 'metrics'));
    }
}
