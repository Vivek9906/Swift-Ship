@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <x-kpi-card label="Total Shipments" :value="$totalShipments" accent="blue" trend="+12% WoW" />
        <x-kpi-card label="In Transit" :value="$inTransit" accent="amber" trend="Live lanes" />
        <x-kpi-card label="Delivered Today" :value="$deliveredToday" accent="emerald" trend="{{ now()->format('M d') }}" />
        <x-kpi-card label="Delayed" :value="$delayed" accent="red" trend="Escalate" />
        <x-kpi-card label="On-Time Rate" value="{{ $onTimeRate }}%" accent="blue" trend="SLA health" />
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.4fr_.8fr]">
        <div class="ops-panel rounded-lg p-4">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-semibold">Shipments Last 7 Days</h2>
                <span class="font-mono text-xs text-blue-200">DAILY_VOLUME</span>
            </div>
            <div class="chart-frame h-72">
                <canvas id="shipmentTrend"></canvas>
            </div>
        </div>
        <div class="ops-panel rounded-lg p-4">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-semibold">Status Breakdown</h2>
                <span class="font-mono text-xs text-amber-200">STATUS_MIX</span>
            </div>
            <div class="chart-frame h-72">
                <canvas id="statusDonut"></canvas>
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1fr_.65fr]">
        <div class="ops-panel overflow-hidden rounded-lg">
            <div class="flex items-center justify-between border-b border-slate-800 px-4 py-3">
                <h2 class="font-semibold">Recent Shipments</h2>
                <a href="{{ route('shipments.index') }}" class="text-sm font-semibold text-blue-300 hover:text-blue-200">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-4 py-3">Tracking</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Lane</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Carrier</th>
                            <th class="px-4 py-3">ETA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentShipments as $shipment)
                            <tr class="border-b border-slate-800 hover:bg-slate-800/50">
                                <td class="px-4 py-3 font-mono text-blue-200"><a href="{{ route('shipments.show', $shipment) }}">{{ $shipment->tracking_number }}</a></td>
                                <td class="px-4 py-3">{{ $shipment->customer->name }}</td>
                                <td class="px-4 py-3">{{ $shipment->sender_city }} → {{ $shipment->receiver_city }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$shipment->status" /></td>
                                <td class="px-4 py-3">{{ $shipment->carrier->name }}</td>
                                <td class="px-4 py-3">{{ $shipment->estimated_delivery?->format('M d, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ops-panel rounded-lg p-4" x-data="activityFeed({{ Js::from($activityFeed->map(fn($shipment) => [
            'tracking' => $shipment->tracking_number,
            'message' => $shipment->customer->name.' shipment '.$shipment->status_label,
            'time' => $shipment->updated_at->diffForHumans(),
        ])) }})" x-init="start()">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-semibold">Live Activity</h2>
                <span class="flex items-center gap-2 text-xs text-emerald-300"><span class="h-2 w-2 animate-pulse rounded-full bg-emerald-300"></span> Streaming</span>
            </div>
            <div class="space-y-3">
                <template x-for="item in items" :key="item.tracking + item.time">
                    <div class="rounded border border-slate-800 bg-slate-950/60 p-3">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-mono text-xs text-blue-200" x-text="item.tracking"></p>
                            <p class="text-xs text-slate-500" x-text="item.time"></p>
                        </div>
                        <p class="mt-1 text-sm text-slate-300" x-text="item.message"></p>
                    </div>
                </template>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const trendData = @json($lastSevenDays);
    const statusData = @json($statusBreakdown);

    window.opsCharts = window.opsCharts || {};
    Object.values(window.opsCharts).forEach(chart => chart?.destroy?.());

    const dashboardChartColors = document.documentElement.classList.contains('light')
        ? { grid: '#dbe3ef', text: '#475569', legend: '#334155' }
        : { grid: '#1e293b', text: '#cbd5e1', legend: '#cbd5e1' };

    window.opsCharts.shipmentTrend = new Chart(document.getElementById('shipmentTrend'), {
        type: 'bar',
        data: {
            labels: trendData.map(item => item.label),
            datasets: [{
                label: 'Shipments',
                data: trendData.map(item => item.count),
                backgroundColor: '#3b82f6',
                borderRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, resizeDelay: 120, plugins: { legend: { display: false } }, scales: { x: { ticks: { color: dashboardChartColors.text }, grid: { color: dashboardChartColors.grid } }, y: { ticks: { color: dashboardChartColors.text }, grid: { color: dashboardChartColors.grid }, beginAtZero: true } } }
    });

    window.opsCharts.statusDonut = new Chart(document.getElementById('statusDonut'), {
        type: 'doughnut',
        data: {
            labels: statusData.map(item => item.label),
            datasets: [{
                data: statusData.map(item => item.count),
                backgroundColor: ['#64748b', '#3b82f6', '#22d3ee', '#f59e0b', '#10b981', '#fb923c', '#ef4444']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, resizeDelay: 120, plugins: { legend: { labels: { color: dashboardChartColors.legend } } } }
    });

    function activityFeed(initialItems) {
        const verbs = ['scanned at hub', 'route ETA recalculated', 'carrier handoff confirmed', 'exception cleared', 'city arrival scan received'];
        const ids = ['IND2605AX91P', 'IND2605QK44Z', 'IND2605LM20C', 'IND2605TR78N'];
        return {
            items: initialItems,
            start() {
                setInterval(() => {
                    this.items.unshift({
                        tracking: ids[Math.floor(Math.random() * ids.length)],
                        message: verbs[Math.floor(Math.random() * verbs.length)],
                        time: 'just now'
                    });
                    this.items = this.items.slice(0, 8);
                }, 5000);
            }
        }
    }
</script>
@endpush
