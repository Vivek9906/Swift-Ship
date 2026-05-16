@extends('layouts.public')

@section('page_title', 'Track Shipment')
@section('page_subtitle', 'Enter your tracking number')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-28" style="background: linear-gradient(135deg, #0f172a 0%, #0c1a3a 60%, #0f172a 100%);">
  <div class="w-full max-w-lg">
    <div class="text-center mb-8">
      <p class="text-xs font-semibold uppercase tracking-widest text-amber-400 mb-4">SwiftShip · Shipment Lookup</p>
      <h1 class="text-3xl sm:text-4xl font-black text-white mb-3">Track Your Delivery</h1>
      <p class="text-slate-400 text-sm leading-relaxed">Enter your tracking number from your confirmation message or receipt to see live status, route, and ETA.</p>
    </div>

    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-black/40">
      <form method="GET" action="{{ route('tracking.lookup') }}" class="space-y-5" id="track-form">
        <div>
          <label for="tracking_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Tracking Number</label>
          <input
            id="tracking_number"
            name="tracking_number"
            type="text"
            value="{{ old('tracking_number', request('tracking_number')) }}"
            placeholder="e.g. IND250512ABCDEF"
            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3.5 text-sm text-slate-100 font-mono outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 placeholder-slate-600"
            required
            autofocus
            autocomplete="off"
          >
          @if($errors->any())
            <p class="mt-2 text-xs text-red-400">{{ $errors->first() }}</p>
          @endif
        </div>
        <button type="submit" class="w-full rounded-xl bg-amber-400 py-3.5 text-sm font-bold text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Track Shipment
        </button>
      </form>

      <div class="mt-6 pt-6 border-t border-slate-800 flex flex-wrap gap-4 justify-center text-xs text-slate-500">
        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Real-time updates</span>
        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>15+ carriers</span>
        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>No login required</span>
      </div>
    </div>

    <div class="mt-6 text-center">
      <a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-slate-300 transition">← Back to Homepage</a>
    </div>
  </div>
</div>
@endsection
