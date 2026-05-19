@extends('layouts.app')

@section('title', $user->name . ' — Customer Detail')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('customers.index') }}" class="ops-button-secondary text-xs">← Back</a>
                <div>
                    <h1 class="text-xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-xs text-slate-400">{{ $user->email }} · Member since {{ $user->created_at?->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="ops-panel rounded-lg p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Shipments</p>
                <p class="text-2xl font-black text-amber-400 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="ops-panel rounded-lg p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Delivered</p>
                <p class="text-2xl font-black text-emerald-400 mt-1">{{ $stats['delivered'] }}</p>
            </div>
            <div class="ops-panel rounded-lg p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pending / Active</p>
                <p class="text-2xl font-black text-blue-400 mt-1">{{ $stats['pending'] }}</p>
            </div>
        </div>

        {{-- Shipments --}}
        <div class="ops-panel overflow-hidden rounded-lg">
            <div class="border-b border-slate-800 px-4 py-3">
                <h2 class="font-semibold text-white">Shipments</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px] text-left text-sm">
                    <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-4 py-3">Tracking #</th>
                            <th class="px-4 py-3">Route</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Carrier</th>
                            <th class="px-4 py-3">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->shipments as $shipment)
                            <tr class="border-b border-slate-800 hover:bg-slate-800/50">
                                <td class="px-4 py-3 font-mono text-xs text-amber-400">
                                    <a href="{{ route('shipments.show', $shipment) }}" class="hover:underline">{{ $shipment->tracking_number }}</a>
                                </td>
                                <td class="px-4 py-3 text-slate-400">{{ $shipment->sender_city ?? '?' }} → {{ $shipment->receiver_city ?? '?' }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$shipment->status" /></td>
                                <td class="px-4 py-3 text-slate-400">{{ $shipment->carrier?->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-500 text-xs">{{ $shipment->created_at?->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-10 text-center text-slate-500">No shipments found for this customer.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection