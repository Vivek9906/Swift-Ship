<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SwiftShip | Booking Confirmed</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body {
      font-family: Inter, ui-sans-serif, sans-serif;
    }

    @keyframes checkPop {
      0% {
        transform: scale(0) rotate(-10deg);
        opacity: 0;
      }

      70% {
        transform: scale(1.15) rotate(3deg);
        opacity: 1;
      }

      100% {
        transform: scale(1) rotate(0);
        opacity: 1;
      }
    }

    .check-anim {
      animation: checkPop .5s cubic-bezier(.22, 1, .36, 1) forwards;
    }
  </style>
</head>

<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4">

  <div class="max-w-lg w-full mx-auto text-center">
    {{-- Checkmark animation --}}
    <div
      class="w-24 h-24 rounded-full bg-emerald-400/15 border-2 border-emerald-400/40 flex items-center justify-center mx-auto mb-6 check-anim">
      <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5"
        stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12" />
      </svg>
    </div>

    <h1 class="text-3xl font-black text-white mb-2">Booking Confirmed! 🎉</h1>
    <p class="text-slate-400 mb-6">Your shipment has been successfully registered.</p>

    {{-- Tracking ID --}}
    <div class="rounded-2xl border border-amber-400/30 bg-amber-400/8 p-5 mb-6">
      <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Your Tracking Number</p>
      <p class="font-mono text-2xl font-black text-amber-400 tracking-wider mb-2">{{ $shipment->tracking_number }}</p>
      <button
        onclick="navigator.clipboard.writeText('{{ $shipment->tracking_number }}').then(()=>this.textContent='Copied!')"
        class="text-xs text-slate-400 hover:text-amber-400 transition border border-slate-700 rounded px-3 py-1 hover:border-amber-400/40">
        Copy Tracking ID
      </button>
    </div>

    {{-- Summary --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 mb-6 text-left">
      <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-4">Booking Summary</p>
      <div class="space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-slate-400">Route</span><span
            class="text-white font-medium">{{ $shipment->sender_city }} → {{ $shipment->receiver_city }}</span></div>
        <div class="flex justify-between"><span class="text-slate-400">Carrier</span><span
            class="text-white font-medium">{{ $shipment->carrier?->name ?? 'TBD' }}</span></div>
        <div class="flex justify-between"><span class="text-slate-400">Service</span><span
            class="text-white font-medium capitalize">{{ $shipment->service_type }}</span></div>
        <div class="flex justify-between"><span class="text-slate-400">Package</span><span
            class="text-white font-medium">{{ $shipment->package_type }} · {{ $shipment->weight }} kg</span></div>
        <div class="flex justify-between"><span class="text-slate-400">Est. Delivery</span><span
            class="text-white font-medium">{{ $shipment->estimated_delivery?->format('D, M d Y') ?? 'TBD' }}</span>
        </div>
        <div class="flex justify-between border-t border-slate-800 pt-2 mt-2">
          <span class="text-slate-400">Total Charged</span>
          <span class="text-amber-400 font-bold text-base">₹{{ number_format($shipment->cost, 2) }}</span>
        </div>
      </div>
    </div>

    <p class="text-xs text-slate-500 mb-6">📧 Confirmation sent to <span
        class="text-slate-300">{{ auth()->user()->email }}</span></p>

    <div class="flex flex-col sm:flex-row gap-3">
      <a href="{{ route('tracking.public.show', $shipment->tracking_number) }}"
        class="flex-1 rounded-xl bg-amber-400 px-6 py-3.5 text-sm font-bold text-slate-950 hover:bg-amber-300 transition text-center">
        Track Your Shipment →
      </a>
      <a href="{{ route('customer.shipments.new') }}"
        class="flex-1 rounded-xl border border-slate-700 px-6 py-3.5 text-sm font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition text-center">
        Book Another
      </a>
    </div>
    <a href="{{ route('customer.dashboard') }}"
      class="mt-4 inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-300 transition">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
        stroke-linecap="round" stroke-linejoin="round">
        <line x1="19" y1="12" x2="5" y2="12" />
        <polyline points="12 19 5 12 12 5" />
      </svg>
      Back to Dashboard
    </a>
  </div>

  <script>
    // Clear booking session storage on confirmation
    sessionStorage.removeItem('booking_step');
  </script>
</body>

</html>

