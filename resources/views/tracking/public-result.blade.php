@extends('layouts.public')

@section('page_title', $shipment ? 'Tracking '.$shipment->tracking_number : 'Shipment Not Found')
@section('page_subtitle', 'Track Your Shipment | SwiftShip')
@section('meta_description', 'Track your shipment in real-time with SwiftShip. Live map, timeline updates, and carrier details.')

@section('content')
{{-- CRITICAL: pt-20 fixes navbar overlap --}}
<div class="pt-20 pb-16 min-h-screen">
<div class="mx-auto max-w-5xl px-4 sm:px-6">

@if(! $shipment)
{{-- ===== NOT FOUND ===== --}}
<div class="mx-auto max-w-lg text-center py-20">
  <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2);">
    <span class="text-4xl font-black text-amber-400">?</span>
  </div>
  <h1 class="text-3xl font-black text-white mb-3">Shipment Not Found</h1>
  <p class="text-slate-400 mb-2 text-sm">The tracking number below doesn't exist or has been removed.</p>
  <p class="font-mono text-lg text-red-400 mb-8 bg-red-500/10 rounded-lg px-4 py-2 inline-block">{{ $trackingNumber }}</p>
  <p class="text-slate-500 text-sm mb-8">Double-check your tracking number from your confirmation email or receipt and try again.</p>
  <form method="GET" action="{{ route('tracking.lookup') }}" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
    <input name="tracking_number" value="{{ $trackingNumber }}" placeholder="Enter tracking number"
      class="flex-1 rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm text-slate-100 font-mono outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20" required>
    <button class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-950 hover:bg-amber-300 transition whitespace-nowrap">Try Again</button>
  </form>
  <a href="{{ route('home') }}" class="mt-6 inline-flex items-center gap-2 text-sm text-slate-500 hover:text-amber-400 transition">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Track Another Shipment
  </a>
</div>

@else
{{-- ===== FOUND ===== --}}
@php
  $statusSteps = ['pending','in_transit','arrived_at_city','out_for_delivery','delivered'];
  $currentIdx = in_array($shipment->status, $statusSteps) ? array_search($shipment->status, $statusSteps) : 1;
  if(in_array($shipment->status, ['delayed','failed'])) $currentIdx = 2;

  $progressStepsDisplay = [
    ['label' => 'Order Placed',     'icon' => 'M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2'],
    ['label' => 'Picked Up',        'icon' => 'M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v10a2 2 0 0 1-2 2h-3'],
    ['label' => 'In Transit',       'icon' => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z'],
    ['label' => 'Arrived at City',  'icon' => 'M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z'],
    ['label' => 'Out for Delivery', 'icon' => 'M1 3h15v13H1zM16 8l4 4-4 4'],
    ['label' => 'Delivered',        'icon' => 'M20 6L9 17l-5-5'],
  ];

  $mapStatuses = ['in_transit','arrived_at_city','out_for_delivery','delayed'];
  $showMap = in_array($shipment->status, $mapStatuses);

  $statusDotColors = [
    'pending'          => ['dot' => '#f59e0b', 'pulse' => true,  'label' => 'Pending'],
    'in_transit'       => ['dot' => '#3b82f6', 'pulse' => true,  'label' => 'In Transit'],
    'arrived_at_city'  => ['dot' => '#06b6d4', 'pulse' => true,  'label' => 'Arrived at City'],
    'out_for_delivery' => ['dot' => '#f59e0b', 'pulse' => true,  'label' => 'Out for Delivery'],
    'delivered'        => ['dot' => '#10b981', 'pulse' => false, 'label' => 'Delivered'],
    'delayed'          => ['dot' => '#f97316', 'pulse' => true,  'label' => 'Delayed'],
    'failed'           => ['dot' => '#ef4444', 'pulse' => false, 'label' => 'Failed'],
  ];
  $sInfo = $statusDotColors[$shipment->status] ?? ['dot' => '#64748b', 'pulse' => false, 'label' => ucfirst($shipment->status)];

  $progressPct = min(100, ($currentIdx / 5) * 100);
@endphp

<div class="space-y-5">

  {{-- === HEADER CARD === --}}
  <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
      <div>
        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">Tracking Number</p>
        <p class="font-mono text-2xl font-bold text-amber-400 tracking-wider mb-3">{{ $shipment->tracking_number }}</p>
        {{-- Route display --}}
        <div class="flex items-center gap-3 flex-wrap">
          <span class="text-xl font-bold text-white">{{ $shipment->sender_city }}</span>
          <span class="text-2xl animate-pulse">🚚</span>
          <svg class="animate-bounce-x hidden sm:block" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          <span class="text-xl font-bold text-white">{{ $shipment->receiver_city }}</span>
        </div>
        <p class="mt-2 text-xs text-slate-500">
          For <span class="text-slate-300 font-medium">{{ $shipment->receiver_name }}</span>
          @if($shipment->estimated_delivery)
            &nbsp;·&nbsp; ETA <span class="text-slate-300 font-medium">{{ $shipment->estimated_delivery->format('M d, Y') }}</span>
          @endif
        </p>
      </div>
      <div class="flex flex-col items-start md:items-end gap-3">
        {{-- Status badge --}}
        <div class="flex items-center gap-2 rounded-full px-4 py-2 text-sm font-bold border"
             style="background: {{ $sInfo['dot'] }}18; border-color: {{ $sInfo['dot'] }}40; color: {{ $sInfo['dot'] }};">
          <span class="w-2 h-2 rounded-full {{ $sInfo['pulse'] ? 'animate-pulse' : '' }}" style="background: {{ $sInfo['dot'] }};"></span>
          {{ $sInfo['label'] }}
        </div>
        <button id="copy-link-btn" onclick="copyTrackingLink()"
          class="text-xs text-slate-400 hover:text-amber-400 transition flex items-center gap-1.5 border border-slate-700 rounded-lg px-3 py-1.5 hover:border-amber-400/40">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
          Share Tracking Link
        </button>
      </div>
    </div>

    {{-- Progress bar --}}
    <div class="mt-5">
      <div class="flex justify-between text-xs text-slate-600 mb-2">
        <span>Journey progress</span>
        <span>{{ number_format($progressPct) }}%</span>
      </div>
      <div class="h-1.5 bg-slate-800 rounded-full overflow-hidden">
        <div class="h-full rounded-full transition-all duration-700" style="width: {{ $progressPct }}%; background: linear-gradient(90deg, #f59e0b, #3b82f6);"></div>
      </div>
    </div>
  </div>

  {{-- === PROGRESS STEPPER === --}}
  <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
    <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-5">Shipment Progress</h2>
    <div class="relative">
      <div class="hidden sm:block absolute top-5 left-5 right-5 h-0.5 bg-slate-800 z-0">
        <div class="h-full transition-all duration-700" style="width: {{ min(100, ($currentIdx/5)*100) }}%; background: linear-gradient(90deg, #f59e0b, #3b82f6);"></div>
      </div>
      <div class="relative z-10 grid grid-cols-3 sm:grid-cols-6 gap-4 sm:gap-0">
        @foreach($progressStepsDisplay as $idx => $step)
          @php $isComplete = $idx < $currentIdx; $isActive = $idx === $currentIdx; @endphp
          <div class="flex flex-col items-center gap-2 text-center {{ $isActive ? '' : ($isComplete ? '' : 'opacity-35') }}">
            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition-all duration-300
              {{ $isComplete ? 'border-emerald-400 bg-emerald-400/20' : ($isActive ? 'border-amber-400 bg-amber-400/20 ring-4 ring-amber-400/15' : 'border-slate-700 bg-slate-900') }}">
              @if($isComplete)
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              @else
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $isActive ? '#f59e0b' : '#475569' }}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $step['icon'] }}"/></svg>
              @endif
            </div>
            <p class="text-xs font-medium leading-tight {{ $isActive ? 'text-amber-400' : ($isComplete ? 'text-emerald-400' : 'text-slate-600') }}">{{ $step['label'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
    @if(in_array($shipment->status, ['delayed','failed']))
      <div class="mt-5 rounded-lg border border-orange-500/30 bg-orange-500/10 px-4 py-3 text-sm text-orange-300 flex items-center gap-2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ $shipment->status === 'delayed' ? 'This shipment is experiencing a delay. Our team is actively investigating.' : 'A delivery attempt failed. Please contact support for rebooking.' }}
      </div>
    @endif
  </div>

  {{-- === MAP + SIDEBAR GRID === --}}
  <div class="grid gap-5 lg:grid-cols-[1fr_300px]">
    {{-- MAP --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 overflow-hidden">
      <div class="px-5 py-3 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm font-semibold text-white">
          <span>📍</span> Live Location
        </div>
        @if($showMap)
        <span class="text-xs text-emerald-400 flex items-center gap-1.5">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> GPS Active
        </span>
        @endif
      </div>
      @if($showMap)
        <div id="publicTrackMap" style="height: 400px;"></div>
      @else
        <div class="h-48 flex flex-col items-center justify-center text-slate-600 text-sm gap-3">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          Map available once shipment is in transit
        </div>
      @endif
    </div>

    {{-- DETAILS SIDEBAR --}}
    <aside class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 flex flex-col gap-4">
      <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Delivery Details</h2>
      <dl class="space-y-4">
        <div class="flex items-start gap-3">
          <span class="text-base mt-0.5">🚚</span>
          <div>
            <dt class="text-xs uppercase text-slate-600 mb-0.5">Carrier</dt>
            <dd class="text-sm font-semibold text-white flex items-center gap-2">
              {{ $shipment->carrier?->name ?? 'Being assigned' }}
              @if($shipment->carrier)
              <span class="text-xs bg-blue-500/15 text-blue-400 border border-blue-500/20 rounded px-2 py-0.5 font-medium">{{ ucfirst($shipment->carrier->type ?? 'Standard') }}</span>
              @endif
            </dd>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <span class="text-base mt-0.5">📍</span>
          <div>
            <dt class="text-xs uppercase text-slate-600 mb-0.5">Current Location</dt>
            <dd class="text-sm font-semibold text-white">{{ $shipment->trackingEvents->sortByDesc('occurred_at')->first()?->location_name ?? $shipment->sender_city }}</dd>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <span class="text-base mt-0.5">🏁</span>
          <div>
            <dt class="text-xs uppercase text-slate-600 mb-0.5">Destination</dt>
            <dd class="text-sm font-semibold text-white">{{ $shipment->receiver_address ?? $shipment->receiver_city }}</dd>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <span class="text-base mt-0.5">⚖️</span>
          <div>
            <dt class="text-xs uppercase text-slate-600 mb-0.5">Package</dt>
            <dd class="text-sm font-semibold text-white">{{ $shipment->weight }} kg {{ $shipment->dimensions ? '· '.$shipment->dimensions : '' }}</dd>
          </div>
        </div>
      </dl>
      @if($shipment->estimated_delivery)
      <div class="mt-auto rounded-xl bg-amber-400/10 border border-amber-400/20 px-4 py-3 text-center">
        <p class="text-xs text-amber-400/70 mb-1">Estimated Delivery</p>
        <p class="text-sm font-bold text-amber-400">{{ $shipment->estimated_delivery->format('D, M d Y') }}</p>
        <p class="text-xs text-slate-500 mt-1">{{ $shipment->estimated_delivery->diffForHumans() }}</p>
      </div>
      @endif
    </aside>
  </div>

  {{-- === TRACKING TIMELINE === --}}
  @if($shipment->trackingEvents->isNotEmpty())
  <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
    <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-6">Tracking History</h2>
    <ol class="relative space-y-6 border-l-2 border-slate-800 pl-6 ml-2">
      @foreach($shipment->trackingEvents->sortByDesc('occurred_at') as $index => $event)
        @php
          $dotColors = [
            'pending'          => '#f59e0b',
            'in_transit'       => '#3b82f6',
            'arrived_at_city'  => '#06b6d4',
            'out_for_delivery' => '#f59e0b',
            'delivered'        => '#10b981',
            'delayed'          => '#f97316',
            'failed'           => '#ef4444',
          ];
          $dot = $dotColors[$event->status] ?? '#64748b';
          $isFirst = $index === 0;
        @endphp
        <li class="relative">
          <span class="absolute -left-[1.875rem] top-1 w-4 h-4 rounded-full border-2 border-slate-950 flex items-center justify-center" style="background: {{ $dot }};">
            @if($isFirst)
              <span class="w-2 h-2 rounded-full bg-white/60 animate-ping absolute"></span>
            @endif
          </span>
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-1">
            <p class="font-semibold text-sm {{ $isFirst ? 'text-white' : 'text-slate-300' }}">{{ str($event->status)->headline() }}</p>
            <time class="font-mono text-xs text-slate-500">{{ $event->occurred_at?->format('M d, Y · H:i') }}</time>
          </div>
          <p class="text-xs text-slate-500">
            <span class="text-slate-400 font-medium">{{ $event->location_name }}</span>
            @if($event->description) · {{ $event->description }} @endif
          </p>
        </li>
      @endforeach
    </ol>
    <p class="mt-6 text-xs text-slate-600 text-center">More updates will appear as your shipment moves.</p>
  </div>
  @endif

  {{-- === RE-TRACK === --}}
  <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5">
    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Track Another Shipment</p>
    <form method="GET" action="{{ route('tracking.lookup') }}" class="flex flex-col sm:flex-row gap-3">
      <input name="tracking_number" placeholder="Enter another tracking number"
        class="flex-1 rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 font-mono outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20" required>
      <button class="rounded-xl bg-slate-800 border border-slate-700 px-6 py-3 text-sm font-bold text-slate-100 hover:bg-slate-700 transition whitespace-nowrap">Track</button>
    </form>
  </div>

</div>
@endif

</div>
</div>
@endsection

@if($shipment && $showMap)
@push('scripts')
<script>
(function(){
  const route = @json($route);
  const map = L.map('publicTrackMap').setView(route.current, 6);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
  const origin = L.latLng(route.origin[0], route.origin[1]);
  const dest   = L.latLng(route.destination[0], route.destination[1]);
  const curr   = L.latLng(route.current[0], route.current[1]);
  L.polyline([origin, curr, dest], { color: '#f59e0b', weight: 3, dashArray: '8 4' }).addTo(map);

  const popupOpts = { className: 'custom-popup' };
  L.circleMarker(origin, { radius: 8, color: '#10b981', fillColor: '#34d399', fillOpacity: 0.9 })
    .addTo(map).bindPopup('📦 Origin: {{ $shipment->sender_city }}', popupOpts);
  L.circleMarker(dest, { radius: 8, color: '#ef4444', fillColor: '#f87171', fillOpacity: 0.9 })
    .addTo(map).bindPopup('🏁 Destination: {{ $shipment->receiver_city }}', popupOpts);

  const truckIcon = L.divIcon({
    html: '<div style="font-size:22px;filter:drop-shadow(0 0 6px #f59e0b);">🚚</div>',
    className: '', iconAnchor: [12, 12]
  });
  const truck = L.marker(curr, { icon: truckIcon }).addTo(map).bindPopup('📍 Current Location').openPopup();

  @if($shipment->status === 'out_for_delivery')
  let lat = route.current[0], lng = route.current[1];
  const dlat = (route.destination[0] - lat) / 120;
  const dlng = (route.destination[1] - lng) / 120;
  setInterval(() => {
    lat += dlat * (0.5 + Math.random());
    lng += dlng * (0.5 + Math.random());
    truck.setLatLng([lat, lng]);
  }, 2000);
  @endif
})();
</script>
<style>
.custom-popup .leaflet-popup-content-wrapper {
  background: #1e293b; color: #f8fafc; border: 1px solid rgba(245,158,11,0.4); border-radius: 8px;
  font-family: Inter, sans-serif; font-size: 12px;
}
.custom-popup .leaflet-popup-tip { background: #1e293b; }
</style>
@endpush
@endif

@push('scripts')
<script>
function copyTrackingLink() {
  navigator.clipboard.writeText(window.location.href).then(() => {
    const btn = document.getElementById('copy-link-btn');
    const orig = btn.innerHTML;
    btn.textContent = '✓ Copied!';
    btn.style.color = '#34d399';
    setTimeout(() => { btn.innerHTML = orig; btn.style.color = ''; }, 2000);
  });
}
</script>
@endpush
