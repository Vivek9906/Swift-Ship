@extends('layouts.public')

@section('content')
@if(! $shipment)
    <section class="mx-auto max-w-2xl ops-panel rounded-lg p-6">
        <p class="font-mono text-sm text-red-300">{{ $trackingNumber }}</p>
        <h1 class="mt-2 text-2xl font-bold">Shipment not found</h1>
        <p class="mt-2 text-slate-400">Check the tracking number and try again.</p>
        <form method="POST" action="{{ route('tracking.lookup.submit') }}" class="mt-5 flex flex-col gap-3 sm:flex-row">
            @csrf
            <input name="tracking_number" value="{{ $trackingNumber }}" class="ops-input flex-1 font-mono" required>
            <button class="ops-button">Search Again</button>
        </form>
    </section>
@else
    <div class="space-y-6">
        <section class="ops-panel rounded-lg p-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <p class="font-mono text-sm text-blue-200">{{ $shipment->tracking_number }}</p>
                    <h1 class="mt-1 text-3xl font-bold">{{ $shipment->sender_city }} -> {{ $shipment->receiver_city }}</h1>
                    <p class="mt-2 text-sm text-slate-400">For {{ $shipment->receiver_name }} - ETA {{ $shipment->estimated_delivery?->format('M d, Y H:i') }}</p>
                </div>
                <x-status-badge :status="$shipment->status" />
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="ops-panel overflow-hidden rounded-lg">
                <div id="customerTrackingMap" class="h-[430px]"></div>
            </div>

            <aside class="ops-panel rounded-lg p-5">
                <h2 class="font-semibold">Delivery Details</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div><dt class="text-xs uppercase text-slate-500">Carrier</dt><dd class="mt-1 font-semibold">{{ $shipment->carrier?->name ?? 'Assigning carrier' }}</dd></div>
                    <div><dt class="text-xs uppercase text-slate-500">Current Location</dt><dd class="mt-1 font-semibold">{{ $shipment->trackingEvents->last()?->location_name ?? $shipment->sender_city }}</dd></div>
                    <div><dt class="text-xs uppercase text-slate-500">Destination</dt><dd class="mt-1 font-semibold">{{ $shipment->receiver_address }}</dd></div>
                </dl>
            </aside>
        </section>

        <section class="ops-panel rounded-lg p-5">
            <h2 class="mb-5 font-semibold">Tracking Updates</h2>
            <ol class="relative space-y-6 border-l border-slate-700 pl-6">
                @foreach($shipment->trackingEvents->sortByDesc('occurred_at') as $event)
                    <li>
                        <span class="absolute -left-2.5 mt-1 h-5 w-5 rounded-full border-2 border-slate-950 bg-blue-400"></span>
                        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                            <p class="font-semibold">{{ str($event->status)->headline() }}</p>
                            <time class="font-mono text-xs text-slate-500">{{ $event->occurred_at?->format('M d, H:i') }}</time>
                        </div>
                        <p class="text-sm text-slate-400">{{ $event->location_name }} - {{ $event->description }}</p>
                    </li>
                @endforeach
            </ol>
        </section>
    </div>
@endif
@endsection

@if($shipment)
@push('scripts')
<script>
    const customerRoute = @json($route);
    const customerMap = L.map('customerTrackingMap', { zoomControl: true }).setView(customerRoute.current, 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(customerMap);
    const origin = L.latLng(customerRoute.origin[0], customerRoute.origin[1]);
    const destination = L.latLng(customerRoute.destination[0], customerRoute.destination[1]);
    const current = L.latLng(customerRoute.current[0], customerRoute.current[1]);
    L.polyline([origin, current, destination], { color: '#2563eb', weight: 4, dashArray: '8 10' }).addTo(customerMap);
    L.marker(origin).addTo(customerMap).bindPopup('Origin');
    L.marker(destination).addTo(customerMap).bindPopup('Destination');
    L.circleMarker(current, { radius: 9, color: '#f59e0b', fillColor: '#fbbf24', fillOpacity: 0.9 }).addTo(customerMap).bindPopup('Current package location').openPopup();
</script>
@endpush
@endif
