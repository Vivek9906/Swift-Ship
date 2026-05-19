@extends('layouts.public')

@section('page_title', $shipment ? 'Track ' . $shipment->tracking_number : 'Shipment Not Found')
@section('meta_description', 'Track your shipment in real-time with SwiftShip.')

@section('content')
  {{-- Fix navbar overlap --}}
  <div class="pt-20 pb-16 min-h-screen">
    <div class="mx-auto max-w-5xl px-4 sm:px-6">

      @if(!$shipment)
        <div class="mx-auto max-w-lg text-center py-20">
          <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6"
            style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2);">
            <span class="text-4xl font-black text-amber-400">?</span>
          </div>
          <h1 class="text-3xl font-black text-white mb-3">Shipment Not Found</h1>
          <p class="text-slate-400 mb-2 text-sm">The tracking number below doesn't exist or has been removed.</p>
          <p class="font-mono text-lg text-red-400 mb-8 bg-red-500/10 rounded-lg px-4 py-2 inline-block">
            {{ $trackingNumber }}</p>
          <form method="POST" action="{{ route('tracking.lookup.submit') }}"
            class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
            @csrf
            <input name="tracking_number" value="{{ $trackingNumber }}"
              class="flex-1 rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm text-slate-100 font-mono outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20"
              required>
            <button
              class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-950 hover:bg-amber-300 transition whitespace-nowrap">Search
              Again</button>
          </form>
          <a href="{{ route('home') }}"
            class="mt-6 inline-flex items-center gap-2 text-sm text-slate-500 hover:text-amber-400 transition">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
              stroke-linecap="round" stroke-linejoin="round">
              <line x1="19" y1="12" x2="5" y2="12" />
              <polyline points="12 19 5 12 12 5" />
            </svg>
            Back to Home
          </a>
        </div>

      @else
        <div class="space-y-5">
          {{-- Header --}}
          <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
              <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">Tracking Number</p>
                <p class="font-mono text-2xl font-bold text-amber-400 tracking-wider mb-3">{{ $shipment->tracking_number }}
                </p>
                <div class="flex items-center gap-3 flex-wrap">
                  <span class="text-xl font-bold text-white">{{ $shipment->sender_city }}</span>
                  <span class="text-2xl">🚚</span>
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                  </svg>
                  <span class="text-xl font-bold text-white">{{ $shipment->receiver_city }}</span>
                </div>
                <p class="mt-2 text-xs text-slate-500">
                  For <span class="text-slate-300 font-medium">{{ $shipment->receiver_name }}</span>
                  · ETA <span
                    class="text-slate-300 font-medium">{{ $shipment->estimated_delivery?->format('M d, Y H:i') }}</span>
                </p>
              </div>
              <x-status-badge :status="$shipment->status" class="text-sm px-3 py-1.5" />
            </div>
          </div>

          {{-- Map + Sidebar --}}
          <div class="grid gap-5 lg:grid-cols-[1fr_300px]">
            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 overflow-hidden">
              <div class="px-5 py-3 border-b border-slate-800 flex items-center gap-2 text-sm font-semibold text-white">
                <span>📍</span> Live Location
                <span class="ml-auto text-xs text-emerald-400 flex items-center gap-1.5">
                  <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> GPS Active
                </span>
              </div>
              <div id="userTrackingMap" style="height: 400px;"></div>
            </div>

            <aside class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 flex flex-col gap-4">
              <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Delivery Details</h2>
              <dl class="space-y-4">
                <div class="flex items-start gap-3">
                  <span class="text-base mt-0.5">🚚</span>
                  <div>
                    <dt class="text-xs uppercase text-slate-600 mb-0.5">Carrier</dt>
                    <dd class="text-sm font-semibold text-white">{{ $shipment->carrier?->name ?? 'Assigning carrier' }}</dd>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <span class="text-base mt-0.5">📍</span>
                  <div>
                    <dt class="text-xs uppercase text-slate-600 mb-0.5">Current Location</dt>
                    <dd class="text-sm font-semibold text-white">
                      {{ $shipment->trackingEvents->last()?->location_name ?? $shipment->sender_city }}</dd>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <span class="text-base mt-0.5">🏁</span>
                  <div>
                    <dt class="text-xs uppercase text-slate-600 mb-0.5">Destination</dt>
                    <dd class="text-sm font-semibold text-white">{{ $shipment->receiver_address }}</dd>
                  </div>
                </div>
              </dl>
            </aside>
          </div>

          {{-- Timeline --}}
          <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-6">Tracking Updates</h2>
            <ol class="relative space-y-6 border-l-2 border-slate-800 pl-6 ml-2">
              @foreach($shipment->trackingEvents->sortByDesc('occurred_at') as $index => $event)
                @php
                  $dots = ['pending' => '#f59e0b', 'in_transit' => '#3b82f6', 'arrived_at_city' => '#06b6d4', 'out_for_delivery' => '#f59e0b', 'delivered' => '#10b981', 'delayed' => '#f97316', 'failed' => '#ef4444'];
                  $dot = $dots[$event->status] ?? '#64748b';
                @endphp
                <li class="relative">
                  <span class="absolute -left-[1.875rem] top-1 w-4 h-4 rounded-full border-2 border-slate-950"
                    style="background:{{ $dot }};"></span>
                  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-1">
                    <p class="font-semibold text-sm text-white">{{ str($event->status)->headline() }}</p>
                    <time class="font-mono text-xs text-slate-500">{{ $event->occurred_at?->format('M d, Y · H:i') }}</time>
                  </div>
                  <p class="text-xs text-slate-500"><span
                      class="text-slate-400 font-medium">{{ $event->location_name }}</span>
                    @if($event->description) · {{ $event->description }} @endif</p>
                </li>
              @endforeach
            </ol>
            <p class="mt-6 text-xs text-slate-600 text-center">More updates will appear as your shipment moves.</p>
          </div>
        </div>
      @endif

    </div>
  </div>
@endsection

@if($shipment)
  @push('scripts')
    <script>
      const userRoute = @json($route);
      const userMap = L.map('userTrackingMap', { zoomControl: true }).setView(userRoute.current, 6);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(userMap);
      const origin = L.latLng(userRoute.origin[0], userRoute.origin[1]);
      const destination = L.latLng(userRoute.destination[0], userRoute.destination[1]);
      const current = L.latLng(userRoute.current[0], userRoute.current[1]);
      L.polyline([origin, current, destination], { color: '#f59e0b', weight: 3, dashArray: '8 4' }).addTo(userMap);
      L.circleMarker(origin, { radius: 8, color: '#10b981', fillColor: '#34d399', fillOpacity: 0.9 }).addTo(userMap).bindPopup('Origin');
      L.circleMarker(destination, { radius: 8, color: '#ef4444', fillColor: '#f87171', fillOpacity: 0.9 }).addTo(userMap).bindPopup('Destination');
      const truckIcon = L.divIcon({ html: '<div style="font-size:22px;filter:drop-shadow(0 0 6px #f59e0b);">🚚</div>', className: '', iconAnchor: [12, 12] });
      L.marker(current, { icon: truckIcon }).addTo(userMap).bindPopup('Current package location').openPopup();
    </script>
    <style>
      .leaflet-popup-content-wrapper {
        background: #1e293b !important;
        color: #f8fafc !important;
        border: 1px solid rgba(245, 158, 11, 0.4) !important;
        border-radius: 8px !important;
      }

      .leaflet-popup-tip {
        background: #1e293b !important;
      }
    </style>
  @endpush
@endif