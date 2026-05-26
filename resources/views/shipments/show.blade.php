@extends('layouts.app')

@section('title', 'Shipment ' . $shipment->tracking_number)

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1fr_380px]">
        <section class="space-y-6">
            <div class="ops-panel rounded-lg p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <p class="font-mono text-sm text-blue-200">{{ $shipment->tracking_number }}</p>
                        <h2 class="mt-1 text-2xl font-bold">{{ $shipment->sender_city }} → {{ $shipment->receiver_city }}
                        </h2>
                        <p class="mt-2 text-sm text-slate-400">{{ $shipment->sender_name }} to
                            {{ $shipment->receiver_name }}</p>
                    </div>
                    <div class="flex gap-2">
                        <x-status-badge :status="$shipment->status" />
                        @can('update', $shipment)
                            <a href="{{ route('shipments.edit', $shipment) }}" class="ops-button-secondary">Edit</a>
                        @endcan
                    </div>
                </div>

                <dl class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <dt class="text-xs uppercase text-slate-500">Carrier</dt>
                        <dd class="mt-1 font-semibold">{{ $shipment->carrier->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-slate-500">Weight</dt>
                        <dd class="mt-1 font-semibold">{{ $shipment->weight }} kg</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-slate-500">Dimensions</dt>
                        <dd class="mt-1 font-semibold">{{ $shipment->dimensions }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-slate-500">Cost</dt>
                        <dd class="mt-1 font-semibold">₹{{ number_format($shipment->cost, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-slate-500">ETA</dt>
                        <dd class="mt-1 font-semibold">{{ $shipment->estimated_delivery?->format('M d, Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-slate-500">Coordinates</dt>
                        <dd class="mt-1 font-mono text-sm">{{ $shipment->current_lat }}, {{ $shipment->current_lng }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs uppercase text-slate-500">Receiver Address</dt>
                        <dd class="mt-1 font-semibold">{{ $shipment->receiver_address }}</dd>
                    </div>
                </dl>
            </div>

            <div class="ops-panel rounded-lg p-5">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-semibold">Live Route</h2>
                    <span
                        class="font-mono text-xs text-amber-200">{{ $shipment->status === 'out_for_delivery' || $shipment->status === 'arrived_at_city' ? 'CITY_ZOOM' : 'INDIA_ROUTE' }}</span>
                </div>
                <div id="shipmentMap" class="h-[420px] rounded border border-slate-800"></div>
            </div>

            <div class="ops-panel rounded-lg p-5">
                <h2 class="mb-5 font-semibold">Milestone Timeline</h2>
                <ol class="relative space-y-6 border-l border-slate-700 pl-6">
                    @foreach($shipment->trackingEvents as $event)
                        <li>
                            <span
                                class="absolute -left-2.5 mt-1 h-5 w-5 rounded-full border-2 border-slate-950 bg-blue-400"></span>
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <p class="font-semibold">{{ str($event->status)->headline() }}</p>
                                <time
                                    class="font-mono text-xs text-slate-500">{{ $event->occurred_at->format('M d, H:i') }}</time>
                            </div>
                            <p class="text-sm text-slate-400">{{ $event->location_name }} · {{ $event->description }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="ops-panel rounded-lg p-5">
                <h2 class="font-semibold">user</h2>
                <div class="mt-4 space-y-2 text-sm">
                    <p class="text-lg font-bold">{{ $shipment->user->name }}</p>
                    <p class="text-slate-400">{{ $shipment->user->email }}</p>
                    <p class="text-slate-400">{{ $shipment->user->phone }}</p>
                    <p class="text-slate-400">{{ $shipment->user->city }}</p>
                </div>
                <a href="{{ route('customers.show', $shipment->user) }}"
                    class="mt-4 inline-flex text-sm font-semibold text-blue-300 hover:text-blue-200">Open profile</a>
            </div>

            <div class="ops-panel rounded-lg p-5">
                <h2 class="mb-4 font-semibold">Order History</h2>
                <div class="space-y-3">
                    @foreach($shipment->user->shipments->take(6) as $order)
                        <a href="{{ route('shipments.show', $order) }}"
                            class="block rounded border border-slate-800 p-3 hover:bg-slate-800/50">
                            <span class="font-mono text-xs text-blue-200">{{ $order->tracking_number }}</span>
                            <span class="mt-1 block text-sm">{{ $order->sender_city }} → {{ $order->receiver_city }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        const route = @json($route);
        const status = @json($shipment->status);
        const shipmentId = @json($shipment->id);
        const map = L.map('shipmentMap', { zoomControl: true }).setView(route.current, ['arrived_at_city', 'out_for_delivery'].includes(status) ? 12 : 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
        const origin = L.latLng(route.origin[0], route.origin[1]);
        const destination = L.latLng(route.destination[0], route.destination[1]);
        const current = L.latLng(route.current[0], route.current[1]);
        L.polyline([origin, current, destination], { color: '#3b82f6', weight: 4, dashArray: '8 10' }).addTo(map);
        L.marker(origin).addTo(map).bindPopup('Origin: {{ $shipment->sender_city }}');
        L.marker(destination).addTo(map).bindPopup('Destination: {{ $shipment->receiver_city }}');
        const truck = L.marker(current).addTo(map).bindPopup('{{ $shipment->tracking_number }}');

        if (['arrived_at_city', 'out_for_delivery'].includes(status)) {
            setInterval(() => {
                const drift = [truck.getLatLng().lat + ((Math.random() - 0.5) / 700), truck.getLatLng().lng + ((Math.random() - 0.5) / 700)];
                truck.setLatLng(drift);
            }, 2200);
        }

        if (window.Echo) {
            window.Echo.channel(`shipment.${shipmentId}`).listen('.ShipmentStatusUpdated', (event) => {
                truck.setLatLng([event.lat, event.lng]).bindPopup(`${event.tracking_number}<br>${event.status_label}`);
                map.panTo([event.lat, event.lng]);
            });
        }
    </script>
@endpush
