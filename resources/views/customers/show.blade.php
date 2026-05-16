@extends('layouts.app')

@section('title', $customer->name)

@section('content')
<div class="grid gap-6 xl:grid-cols-[360px_1fr]">
    <aside class="space-y-6">
        <div class="ops-panel rounded-lg p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-2xl font-bold">{{ $customer->name }}</h2>
                    <p class="mt-1 text-sm text-slate-400">{{ $customer->city }}</p>
                </div>
                <x-status-badge :status="$customer->status" />
            </div>
            <div class="mt-5 space-y-2 text-sm text-slate-300">
                <p>{{ $customer->email }}</p>
                <p>{{ $customer->phone }}</p>
                <p>{{ $customer->address }}</p>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <x-kpi-card label="Total" :value="$stats['total']" />
            <x-kpi-card label="Delivered" :value="$stats['delivered']" accent="emerald" />
            <x-kpi-card label="Open" :value="$stats['pending']" accent="amber" />
        </div>
        @if(auth()->user()?->canManage())
            <form method="POST" action="{{ route('customers.update', $customer) }}" class="ops-panel space-y-3 rounded-lg p-5">
                @csrf
                @method('PUT')
                <input type="hidden" name="name" value="{{ $customer->name }}">
                <input type="hidden" name="email" value="{{ $customer->email }}">
                <input type="hidden" name="phone" value="{{ $customer->phone }}">
                <input type="hidden" name="address" value="{{ $customer->address }}">
                <input type="hidden" name="city" value="{{ $customer->city }}">
                <input type="hidden" name="status" value="{{ $customer->status }}">
                <label class="space-y-1">
                    <span class="text-xs font-semibold uppercase text-slate-400">Ops Notes</span>
                    <textarea name="notes" rows="5" class="ops-input w-full">{{ $customer->notes }}</textarea>
                </label>
                <button class="ops-button w-full">Save Notes</button>
            </form>
        @endif
    </aside>

    <section class="ops-panel overflow-hidden rounded-lg">
        <div class="border-b border-slate-800 px-4 py-3">
            <h2 class="font-semibold">Shipment History</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left text-sm">
                <thead class="bg-slate-900 text-xs uppercase text-slate-400">
                    <tr>
                        <th class="px-4 py-3">Tracking</th>
                        <th class="px-4 py-3">Lane</th>
                        <th class="px-4 py-3">Carrier</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">ETA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customer->shipments as $shipment)
                        <tr class="border-b border-slate-800 hover:bg-slate-800/60">
                            <td class="px-4 py-3 font-mono text-blue-200"><a href="{{ route('shipments.show', $shipment) }}">{{ $shipment->tracking_number }}</a></td>
                            <td class="px-4 py-3">{{ $shipment->sender_city }} → {{ $shipment->receiver_city }}</td>
                            <td class="px-4 py-3">{{ $shipment->carrier->name }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$shipment->status" /></td>
                            <td class="px-4 py-3">{{ $shipment->estimated_delivery?->format('M d, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
