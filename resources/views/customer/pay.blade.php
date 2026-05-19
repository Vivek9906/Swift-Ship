@extends('layouts.app')

@section('content')
<div class="pt-20 pb-12 min-h-screen">
<div class="mx-auto max-w-xl px-4 sm:px-6">
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6 space-y-5">
        <h2 class="text-lg font-bold text-white">Complete Payment</h2>
        
        <div id="payment-section">
          <div class="rounded-xl bg-slate-950/60 p-4 border border-slate-800 text-sm space-y-2 mb-6">
            <h3 class="text-xs font-semibold uppercase text-slate-500 tracking-wider mb-3">Order Summary</h3>
            <div class="flex justify-between text-slate-300">
              <span>Base Fare</span>
              <span>₹{{ number_format($shipment->base_fare, 2) }}</span>
            </div>
            <div class="flex justify-between text-slate-300">
              <span>Weight Charges</span>
              <span>₹{{ number_format($shipment->weight_charge, 2) }}</span>
            </div>
            <div class="flex justify-between text-slate-300">
              <span>Distance Charges</span>
              <span>₹{{ number_format($shipment->distance_charge, 2) }}</span>
            </div>
            <div class="flex justify-between text-slate-300">
              <span>GST (18%)</span>
              <span>₹{{ number_format($shipment->gst_amount, 2) }}</span>
            </div>
            <div class="border-t border-slate-800 pt-3 mt-3 flex justify-between text-base font-bold">
              <span class="text-white">Total Amount</span>
              <span class="text-amber-400">₹{{ number_format($shipment->cost, 2) }}</span>
            </div>
          </div>

          <form action="{{ route('customer.shipments.stripe-checkout') }}" method="POST">
            @csrf
            <button type="submit" id="pay-now-btn" 
                    class="w-full rounded-xl bg-amber-400 px-8 py-3 text-sm font-bold text-slate-950 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
              Pay ₹{{ number_format($shipment->cost, 2) }} Securely
            </button>
          </form>

          <p class="text-center text-xs text-slate-500 mt-4 flex items-center justify-center gap-1">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            256-bit SSL encrypted · Powered by Stripe
          </p>
        </div>
    </div>
</div>
</div>
@endsection
