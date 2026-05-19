@extends('layouts.public')

@section('page_title', 'Track Shipment')
@section('meta_description', 'Track your SwiftShip shipment in real-time. Enter your tracking number to get live GPS location, delivery ETA, and status updates.')

@section('content')
{{-- Fix: pt-20 removes navbar overlap, rest centers content in viewport --}}
<div class="pt-20 min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
  {{-- Background particle canvas --}}
  <canvas id="trackCanvas" class="absolute inset-0 w-full h-full pointer-events-none opacity-50"></canvas>

  <div class="relative z-10 w-full max-w-5xl mx-auto px-4 sm:px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_460px] gap-12 items-center">

      {{-- Left: Heading --}}
      <div>
        <div class="inline-flex items-center gap-2 rounded-full border border-amber-400/30 bg-amber-400/10 px-4 py-1.5 text-xs font-semibold text-amber-300 mb-6 uppercase tracking-wider">
          <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
          Real-Time GPS Tracking
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-white leading-tight mb-4">
          Track Your<br><span class="text-amber-400">Delivery</span>
        </h1>
        <p class="text-slate-400 text-base leading-relaxed max-w-md mb-6">
          Enter your tracking number from your confirmation email or SMS to see live GPS location, delivery ETA, carrier updates, and complete shipment history.
        </p>
        <div class="flex flex-wrap gap-4 text-sm text-slate-500">
          <span class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            15+ carriers tracked
          </span>
          <span class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
            Pan-India coverage
          </span>
          <span class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
            No login required
          </span>
        </div>
      </div>

      {{-- Right: Tracking input card --}}
      <div class="rounded-2xl border border-slate-800 bg-slate-900/80 backdrop-blur p-7 shadow-2xl shadow-black/30">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-amber-400/15 border border-amber-400/30 flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          </div>
          <div>
            <h2 class="text-sm font-bold text-white">Track a Shipment</h2>
            <p class="text-xs text-slate-500">Enter your tracking number below</p>
          </div>
        </div>

        <form method="GET" action="{{ route('tracking.lookup') }}" id="track-form"
              onsubmit="return validateTrack()">
          @csrf
          <div class="mb-3">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Tracking Number</label>
            <input
              id="track-input"
              name="tracking_number"
              type="text"
              value="{{ old('tracking_number', request('tracking_number')) }}"
              placeholder="e.g. IND260518ABCDEF"
              class="w-full rounded-xl border border-slate-700 bg-slate-950/80 px-4 py-3.5 text-sm text-slate-100 font-mono outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 placeholder-slate-600"
              autocomplete="off"
              autofocus
            >
          </div>

          {{-- Inline error --}}
          <div id="track-error" class="hidden mb-3 rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-xs text-red-300">
            Please enter a tracking number before searching.
          </div>

          @if($errors->any())
          <div class="mb-3 rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-xs text-red-300">
            {{ $errors->first() }}
          </div>
          @endif

          <button type="submit"
            class="w-full rounded-xl bg-amber-400 py-3.5 text-sm font-bold text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Track Shipment
          </button>
        </form>

        {{-- Example hint --}}
        <div class="mt-5 pt-5 border-t border-slate-800">
          <p class="text-xs text-slate-500 mb-2 font-medium">Example tracking numbers (demo):</p>
          <div class="flex flex-wrap gap-2">
            @php
              $examples = \App\Models\Shipment::orderByDesc('created_at')->take(3)->pluck('tracking_number');
            @endphp
            @foreach($examples as $ex)
            <button type="button" onclick="document.getElementById('track-input').value='{{ $ex }}'"
              class="font-mono text-xs rounded-lg border border-slate-700 bg-slate-900 px-3 py-1.5 text-slate-400 hover:border-amber-400/40 hover:text-amber-400 transition">
              {{ $ex }}
            </button>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function validateTrack() {
  const val = document.getElementById('track-input')?.value?.trim();
  const err = document.getElementById('track-error');
  if (!val) {
    err?.classList.remove('hidden');
    setTimeout(() => err?.classList.add('hidden'), 4000);
    return false;
  }
  return true;
}

// Canvas particle network (same as home hero)
(function () {
  const canvas = document.getElementById('trackCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  let W, H, nodes = [];
  const N = 45, MAX_DIST = 120;

  function resize() { W = canvas.width = canvas.offsetWidth; H = canvas.height = canvas.offsetHeight; }
  function init() {
    nodes = Array.from({ length: N }, () => ({
      x: Math.random() * W, y: Math.random() * H,
      vx: (Math.random() - 0.5) * 0.35, vy: (Math.random() - 0.5) * 0.35,
      r: Math.random() * 2 + 1,
    }));
  }
  function draw() {
    ctx.clearRect(0, 0, W, H);
    nodes.forEach(n => {
      n.x += n.vx; n.y += n.vy;
      if (n.x < 0 || n.x > W) n.vx *= -1;
      if (n.y < 0 || n.y > H) n.vy *= -1;
      ctx.beginPath(); ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(148,163,184,0.4)'; ctx.fill();
    });
    for (let i = 0; i < N; i++) for (let j = i + 1; j < N; j++) {
      const dx = nodes[i].x - nodes[j].x, dy = nodes[i].y - nodes[j].y;
      const d = Math.hypot(dx, dy);
      if (d < MAX_DIST) {
        ctx.beginPath(); ctx.moveTo(nodes[i].x, nodes[i].y); ctx.lineTo(nodes[j].x, nodes[j].y);
        ctx.strokeStyle = `rgba(100,130,200,${0.12 * (1 - d / MAX_DIST)})`; ctx.lineWidth = 0.8; ctx.stroke();
      }
    }
    requestAnimationFrame(draw);
  }
  resize(); init(); draw();
  window.addEventListener('resize', () => { resize(); init(); });
})();
</script>
@endpush
