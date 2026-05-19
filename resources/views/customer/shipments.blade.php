@extends('layouts.app')
@section('title', 'My Shipments')
@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-white">My Shipments</h2>
        <a href="{{ route('customer.shipments.new') }}" class="ops-button">+ Book New</a>
    </div>
    <div class="ops-panel overflow-hidden rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-5 py-3">Shipment ID</th>
                        <th class="px-5 py-3">Route</th>
                        <th class="px-5 py-3">Carrier</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">ETA</th>
                        <th class="px-5 py-3">Fare</th>
                        <th class="px-5 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                        <tr class="border-b border-slate-800 hover:bg-slate-800/40 transition">
                            <td class="px-5 py-3 font-mono text-amber-400 text-xs">{{ $shipment->tracking_number }}</td>
                            <td class="px-5 py-3 text-slate-300">{{ $shipment->pickup_city }} → {{ $shipment->delivery_city }}</td>
                            <td class="px-5 py-3 text-slate-400">{{ $shipment->carrier?->name ?? 'N/A' }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucwords(str_replace('_', ' ', $shipment->status)) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-400 text-xs">
                                {{ $shipment->estimated_delivery ? \Carbon\Carbon::parse($shipment->estimated_delivery)->format('d M Y') : '—' }}
                            </td>
                            <td class="px-5 py-3 text-slate-300">₹{{ number_format($shipment->cost, 2) }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('customer.shipment.detail', $shipment->id) }}"
                                    class="inline-flex items-center rounded-lg bg-slate-800 border border-slate-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-700 transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">
                            <div class="text-center py-12 text-slate-500">
                                <p class="mt-2">No shipments found.</p>
                                <a href="{{ route('customer.shipments.new') }}" class="mt-4 inline-block ops-button">Book Your First Shipment</a>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($shipments->hasPages())
            <div class="border-t border-slate-800 px-5 py-4">{{ $shipments->links() }}</div>
        @endif
    </div>
</div>
@endsection
