<!doctype html>
<html lang="en" x-data="{ mobileMenu: false, userMenu: false }">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SwiftShip | My Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-100">

  {{-- user NAVBAR --}}
  <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur border-b border-slate-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 flex h-16 items-center justify-between">
      <a href="{{ route('home') }}" class="flex items-center gap-2.5">
        <span
          class="grid h-8 w-8 place-items-center rounded-lg bg-amber-400 font-mono font-black text-slate-950 text-xs">SS</span>
        <span class="text-base font-extrabold text-white">Swift<span class="text-amber-400">Ship</span></span>
      </a>

      {{-- Desktop nav --}}
      <div class="hidden md:flex items-center gap-6 text-sm font-medium">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-white transition">Home</a>
        <a href="{{ route('customer.dashboard') }}" class="text-white border-b-2 border-amber-400 pb-0.5">My Dashboard</a>
        <a href="{{ route('customer.shipments.new') }}" class="text-slate-400 hover:text-white transition">Book Shipment</a>
        <a href="{{ route('tracking.lookup') }}" class="text-slate-400 hover:text-white transition">Track</a>
      </div>

      <div class="flex items-center gap-3">
        {{-- Book CTA --}}
        <a href="{{ route('customer.shipments.new') }}"
          class="hidden sm:inline-flex items-center gap-1.5 rounded-lg bg-amber-400 px-4 py-2 text-xs font-bold text-slate-950 hover:bg-amber-300 transition">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
          </svg>
          Book Shipment
        </a>

        {{-- User dropdown --}}
        <div class="relative" x-data="{ open: false }">
          <button @click="open = !open"
            class="flex items-center gap-2 rounded-lg border border-slate-700 px-3 py-1.5 text-sm hover:border-slate-600 transition">
            <div
              class="w-6 h-6 rounded-full bg-gradient-to-br from-amber-400 to-blue-500 flex items-center justify-center text-xs font-bold text-slate-950">
              {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <span class="hidden sm:block text-slate-300 max-w-[120px] truncate">{{ auth()->user()->name }}</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
              :class="open ? 'rotate-180' : ''" class="transition-transform text-slate-500">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </button>
          <div x-show="open" @click.away="open=false" x-transition
            class="absolute right-0 mt-2 w-48 rounded-xl border border-slate-700 bg-slate-900 shadow-xl py-1 z-50">
            <a href="{{ route('customer.dashboard') }}"
              class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-800 hover:text-white transition">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" />
                <rect x="14" y="3" width="7" height="7" />
                <rect x="14" y="14" width="7" height="7" />
                <rect x="3" y="14" width="7" height="7" />
              </svg>
              My Dashboard
            </a>
            <a href="{{ route('customer.shipments.new') }}"
              class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-800 hover:text-white transition">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="3" width="15" height="13" />
                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
                <circle cx="5.5" cy="18.5" r="2.5" />
                <circle cx="18.5" cy="18.5" r="2.5" />
              </svg>
              My Shipments
            </a>
            <div class="border-t border-slate-800 mt-1 pt-1">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                  class="flex w-full items-center gap-2.5 px-4 py-2.5 text-sm text-red-400 hover:bg-slate-800 transition">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                  </svg>
                  Sign Out
                </button>
              </form>
            </div>
          </div>
        </div>

        {{-- Mobile hamburger --}}
        <button @click="mobileMenu = !mobileMenu" class="md:hidden text-slate-400 hover:text-white p-1">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6" />
            <line x1="3" y1="12" x2="21" y2="12" />
            <line x1="3" y1="18" x2="21" y2="18" />
          </svg>
        </button>
      </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileMenu" @click.away="mobileMenu=false" x-transition
      class="md:hidden border-t border-slate-800 bg-slate-900 px-4 py-3 space-y-2">
      <a href="{{ route('home') }}" class="block py-2 text-sm text-slate-300">Home</a>
      <a href="{{ route('customer.dashboard') }}" class="block py-2 text-sm text-amber-400 font-semibold">My Dashboard</a>
      <a href="{{ route('customer.shipments.new') }}" class="block py-2 text-sm text-slate-300">Book Shipment</a>
      <a href="{{ route('tracking.lookup') }}" class="block py-2 text-sm text-slate-300">Track</a>
    </div>
  </nav>

  {{-- PAGE CONTENT --}}
  <div class="pt-20 pb-12 min-h-screen">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">

      {{-- Toast from session --}}
      @if(session('success'))
        <div id="toast-success"
          class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-5 py-3 text-sm text-emerald-300">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12" />
          </svg>
          {{ session('success') }}
        </div>
      @endif

      @if($justBooked ?? false)
        <div
          class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-5 py-3 text-sm text-emerald-300"
          id="booking-success">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12" />
          </svg>
          <div>
            <strong>Shipment Booked Successfully!</strong>
            <p>Your tracking number is <strong>{{ $justBooked->tracking_number }}</strong>. A confirmation email has been
              sent to your inbox.</p>
          </div>
          <button onclick="this.parentElement.remove()"
            class="ml-auto text-emerald-300 hover:text-emerald-100">&times;</button>
        </div>
      @endif

      {{-- Header --}}
      <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-2xl font-black text-white">Welcome back, {{ auth()->user()->name }}! 👋</h1>
          <p class="text-slate-400 text-sm mt-1">Here's an overview of your shipments</p>
        </div>
        <a href="{{ route('customer.shipments.new') }}"
          class="inline-flex items-center gap-2 rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-950 hover:bg-amber-300 transition shadow-lg shadow-amber-500/20">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
          </svg>
          Book New Shipment
        </a>
      </div>

      {{-- Stats cards --}}
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
          $statCards = [
            ['label' => 'Total Shipments', 'value' => $stats['total'], 'color' => 'amber', 'icon' => 'M4 7h11v10H4V7Zm11 3h3l2 3v4h-5v-7ZM7 19a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm10 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'],
            ['label' => 'Active Shipments', 'value' => $stats['active'], 'color' => 'blue', 'icon' => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z'],
            ['label' => 'Delivered', 'value' => $stats['delivered'], 'color' => 'emerald', 'icon' => 'M20 6L9 17l-5-5'],
            ['label' => 'Pending Payment', 'value' => $stats['pending'], 'color' => 'red', 'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z'],
          ];
          $statColors = [
            'amber' => ['bg' => 'bg-amber-400/10', 'border' => 'border-amber-400/20', 'text' => 'text-amber-400', 'stroke' => '#f59e0b'],
            'blue' => ['bg' => 'bg-blue-500/10', 'border' => 'border-blue-500/20', 'text' => 'text-blue-400', 'stroke' => '#3b82f6'],
            'emerald' => ['bg' => 'bg-emerald-500/10', 'border' => 'border-emerald-500/20', 'text' => 'text-emerald-400', 'stroke' => '#10b981'],
            'red' => ['bg' => 'bg-red-500/10', 'border' => 'border-red-500/20', 'text' => 'text-red-400', 'stroke' => '#ef4444'],
          ];
        @endphp
        @foreach($statCards as $card)
          @php $c = $statColors[$card['color']]; @endphp
          <div class="rounded-2xl border {{ $c['border'] }} {{ $c['bg'] }} p-5">
            <div class="flex items-center justify-between mb-3">
              <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $card['label'] }}</p>
              <div class="w-8 h-8 rounded-lg {{ $c['bg'] }} flex items-center justify-center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $c['stroke'] }}" stroke-width="1.8"
                  stroke-linecap="round" stroke-linejoin="round">
                  <path d="{{ $card['icon'] }}" />
                </svg>
              </div>
            </div>
            <p class="text-3xl font-black {{ $c['text'] }}">{{ $card['value'] }}</p>
          </div>
        @endforeach
      </div>

      {{-- Recent Shipments --}}
      <div class="rounded-2xl border border-slate-800 bg-slate-900/80 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
          <h2 class="font-semibold text-white">Recent Shipments</h2>
          <span class="text-xs text-slate-500">{{ $shipments->total() }} total</span>
        </div>

        @if($shipments->isEmpty())
          <div class="py-20 text-center">
            <svg class="mx-auto mb-4 text-slate-700" width="48" height="48" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <rect x="1" y="3" width="15" height="13" />
              <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
              <circle cx="5.5" cy="18.5" r="2.5" />
              <circle cx="18.5" cy="18.5" r="2.5" />
            </svg>
            <p class="text-slate-400 mb-4">No shipments yet.</p>
            <a href="{{ route('customer.shipments.new') }}"
              class="inline-flex items-center gap-2 rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-slate-950 hover:bg-amber-300 transition">
              Book Your First Shipment →
            </a>
          </div>
        @else
          <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
              <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                  <th class="px-5 py-3">Shipment ID</th>
                  <th class="px-5 py-3">Route</th>
                  <th class="px-5 py-3">Carrier</th>
                  <th class="px-5 py-3">Status</th>
                  <th class="px-5 py-3">ETA</th>
                  <th class="px-5 py-3">Fare</th>
                  <th class="px-5 py-3">Payment</th>
                  <th class="px-5 py-3">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($shipments as $shipment)
                          <tr class="border-b border-slate-800 hover:bg-slate-800/40 transition">
                            <td class="px-5 py-3 font-mono text-amber-400 text-xs">
                              <code>{{ $shipment->tracking_number }}</code>
                              <button onclick="navigator.clipboard.writeText('{{ $shipment->tracking_number }}')" title="Copy ID"
                                class="ml-2 text-slate-500 hover:text-amber-400">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                  <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                              </button>
                            </td>
                            <td class="px-5 py-3 text-slate-300">{{ $shipment->pickup_city }} → {{ $shipment->delivery_city }}</td>
                            <td class="px-5 py-3 text-slate-400">{{ $shipment->carrier?->name ?? 'N/A' }}</td>
                            <td class="px-5 py-3">
                              <span
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $shipment->status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucwords(str_replace('_', ' ', $shipment->status)) }}
                              </span>
                            </td>
                            <td class="px-5 py-3 text-slate-400 text-xs">
                              {{ $shipment->estimated_delivery
                  ? \Carbon\Carbon::parse($shipment->estimated_delivery)->format('d M Y')
                  : 'Calculating...' }}
                            </td>
                            <td class="px-5 py-3 text-slate-300">₹{{ number_format($shipment->cost, 2) }}</td>
                            <td class="px-5 py-3">
                              <span
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $shipment->payment?->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                {{ $shipment->payment?->status === 'paid' ? 'Paid' : 'Pending' }}
                              </span>
                            </td>
                            <td class="px-5 py-3 flex gap-2">
                              <a href="{{ route('customer.shipment.detail', $shipment->id) }}"
                                class="inline-flex items-center gap-1 rounded-lg bg-slate-800 border border-slate-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-700 transition">
                                View
                              </a>
                              <a href="{{ route('tracking.public.show', $shipment->tracking_number) }}"
                                class="inline-flex items-center gap-1 rounded-lg bg-amber-400/15 border border-amber-400/30 px-3 py-1.5 text-xs font-semibold text-amber-400 hover:bg-amber-400/25 transition">
                                Track
                              </a>
                            </td>
                          </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          @if($shipments->hasPages())
            <div class="px-5 py-4 border-t border-slate-800">
              {{ $shipments->links() }}
            </div>
          @endif
        @endif
      </div>

    </div>
  </div>

</body>

</html>

