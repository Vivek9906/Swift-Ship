<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Total Shipments','value' => $totalShipments,'accent' => 'blue','trend' => '+12% WoW']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Shipments','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalShipments),'accent' => 'blue','trend' => '+12% WoW']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $attributes = $__attributesOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__attributesOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $component = $__componentOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__componentOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'In Transit','value' => $inTransit,'accent' => 'amber','trend' => 'Live lanes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'In Transit','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($inTransit),'accent' => 'amber','trend' => 'Live lanes']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $attributes = $__attributesOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__attributesOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $component = $__componentOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__componentOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Delivered Today','value' => $deliveredToday,'accent' => 'emerald','trend' => ''.e(now()->format('M d')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Delivered Today','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($deliveredToday),'accent' => 'emerald','trend' => ''.e(now()->format('M d')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $attributes = $__attributesOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__attributesOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $component = $__componentOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__componentOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Delayed','value' => $delayed,'accent' => 'red','trend' => 'Escalate']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Delayed','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($delayed),'accent' => 'red','trend' => 'Escalate']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $attributes = $__attributesOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__attributesOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $component = $__componentOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__componentOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'On-Time Rate','value' => ''.e($onTimeRate).'%','accent' => 'blue','trend' => 'SLA health']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'On-Time Rate','value' => ''.e($onTimeRate).'%','accent' => 'blue','trend' => 'SLA health']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $attributes = $__attributesOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__attributesOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $component = $__componentOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__componentOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
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
                <a href="<?php echo e(route('shipments.index')); ?>" class="text-sm font-semibold text-blue-300 hover:text-blue-200">View all</a>
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
                        <?php $__currentLoopData = $recentShipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-slate-800 hover:bg-slate-800/50">
                                <td class="px-4 py-3 font-mono text-blue-200"><a href="<?php echo e(route('shipments.show', $shipment)); ?>"><?php echo e($shipment->tracking_number); ?></a></td>
                                <td class="px-4 py-3"><?php echo e($shipment->customer->name); ?></td>
                                <td class="px-4 py-3"><?php echo e($shipment->sender_city); ?> → <?php echo e($shipment->receiver_city); ?></td>
                                <td class="px-4 py-3"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $shipment->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($shipment->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></td>
                                <td class="px-4 py-3"><?php echo e($shipment->carrier->name); ?></td>
                                <td class="px-4 py-3"><?php echo e($shipment->estimated_delivery?->format('M d, H:i')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ops-panel rounded-lg p-4" x-data="activityFeed(<?php echo e(Js::from($activityFeed->map(fn($shipment) => [
            'tracking' => $shipment->tracking_number,
            'message' => $shipment->customer->name.' shipment '.$shipment->status_label,
            'time' => $shipment->updated_at->diffForHumans(),
        ]))); ?>)" x-init="start()">
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const trendData = <?php echo json_encode($lastSevenDays, 15, 512) ?>;
    const statusData = <?php echo json_encode($statusBreakdown, 15, 512) ?>;

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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/dashboard/index.blade.php ENDPATH**/ ?>