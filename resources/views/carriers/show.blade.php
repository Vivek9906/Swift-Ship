@extends('layouts.app')

@section('title', $carrier->name)

@section('content')
<div class="space-y-6">
    <div class="ops-panel rounded-lg p-5">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold">{{ $carrier->name }}</h2>
                <p class="text-sm text-slate-400">{{ str($carrier->type)->headline() }} partner · {{ $carrier->contact_email }}</p>
            </div>
            <div class="font-mono text-blue-200">RATING {{ $carrier->rating }}</div>
        </div>
    </div>
    <section class="grid gap-4 sm:grid-cols-4">
        <x-kpi-card label="Total" :value="$metrics['total']" />
        <x-kpi-card label="Active" :value="$metrics['active']" accent="amber" />
        <x-kpi-card label="Delivered" :value="$metrics['delivered']" accent="emerald" />
        <x-kpi-card label="Delayed" :value="$metrics['delayed']" accent="red" />
    </section>
    <div class="ops-panel rounded-lg p-5">
        <h2 class="mb-4 font-semibold">Performance</h2>
        <div class="chart-frame h-72">
            <canvas id="carrierChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.opsCharts = window.opsCharts || {};
    window.opsCharts.carrierChart?.destroy?.();
    const carrierChartColors = document.documentElement.classList.contains('light')
        ? { grid: '#dbe3ef', text: '#475569' }
        : { grid: '#1e293b', text: '#cbd5e1' };

    window.opsCharts.carrierChart = new Chart(document.getElementById('carrierChart'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{ label: 'On-time %', data: [91, 93, 92, {{ $carrier->on_time_rate }}, 95, 94, {{ $carrier->on_time_rate }}], borderColor: '#3b82f6', backgroundColor: '#3b82f633', tension: .35, fill: true }]
        },
        options: { responsive: true, maintainAspectRatio: false, resizeDelay: 120, scales: { y: { min: 70, max: 100, ticks: { color: carrierChartColors.text }, grid: { color: carrierChartColors.grid } }, x: { ticks: { color: carrierChartColors.text }, grid: { color: carrierChartColors.grid } } } }
    });
</script>
@endpush
