@extends('layouts.public')

@section('content')
<section class="grid min-h-[calc(100vh-112px)] items-center gap-8 lg:grid-cols-[1fr_420px]">
    <div>
        <p class="font-mono text-sm text-blue-200">CUSTOMER TRACKING</p>
        <h1 class="mt-3 text-4xl font-extrabold sm:text-5xl">Track your delivery update</h1>
        <p class="mt-4 max-w-2xl text-slate-400">Enter the tracking number from your confirmation message to see the current status, ETA, route position, and latest scan history.</p>
    </div>

    <form method="POST" action="{{ route('tracking.lookup.submit') }}" class="ops-panel rounded-lg p-5">
        @csrf
        <label class="space-y-2">
            <span class="text-xs font-semibold uppercase text-slate-400">Tracking Number</span>
            <input name="tracking_number" value="{{ old('tracking_number') }}" placeholder="IND2605AX91P" class="ops-input w-full font-mono" required autofocus>
        </label>
        @if($errors->any())
            <div class="mt-4 rounded border border-red-400/50 bg-red-400/10 p-3 text-sm text-red-100">{{ $errors->first() }}</div>
        @endif
        <button class="ops-button mt-5 w-full">Track Shipment</button>
    </form>
</section>
@endsection
