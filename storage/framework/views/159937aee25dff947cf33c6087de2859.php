<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">

        
        <section class="grid gap-4 grid-cols-2 sm:grid-cols-3 xl:grid-cols-5">
            <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Customers','value' => $stats['total_customers'],'accent' => 'blue','trend' => 'All registered']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Customers','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['total_customers']),'accent' => 'blue','trend' => 'All registered']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Total Shipments','value' => $stats['total_shipments'],'accent' => 'amber','trend' => 'All time']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Shipments','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['total_shipments']),'accent' => 'amber','trend' => 'All time']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Active Shipments','value' => $stats['active_shipments'],'accent' => 'emerald','trend' => 'In progress']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Active Shipments','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['active_shipments']),'accent' => 'emerald','trend' => 'In progress']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Delivered','value' => $stats['delivered_shipments'],'accent' => 'indigo','trend' => 'Completed']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Delivered','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['delivered_shipments']),'accent' => 'indigo','trend' => 'Completed']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Pending Payment','value' => $stats['pending_payment'],'accent' => 'red','trend' => 'Awaiting']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Pending Payment','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['pending_payment']),'accent' => 'red','trend' => 'Awaiting']); ?>
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

        
        <section class="grid gap-4 grid-cols-1 sm:grid-cols-3">
            <div class="ops-panel rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Revenue</p>
                    <p class="text-2xl font-black text-amber-400 mt-1">₹<?php echo e(number_format($stats['total_revenue'], 0)); ?></p>
                </div>
                <svg class="w-8 h-8 text-amber-400/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.94s4.18 1.36 4.18 3.85c0 1.91-1.46 2.97-3.12 3.19z"/></svg>
            </div>
            <div class="ops-panel rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Revenue Today</p>
                    <p class="text-2xl font-black text-emerald-400 mt-1">₹<?php echo e(number_format($stats['revenue_today'], 0)); ?></p>
                </div>
                <svg class="w-8 h-8 text-emerald-400/30" fill="currentColor" viewBox="0 0 24 24"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/></svg>
            </div>
            <div class="ops-panel rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Revenue This Month</p>
                    <p class="text-2xl font-black text-blue-400 mt-1">₹<?php echo e(number_format($stats['revenue_this_month'], 0)); ?></p>
                </div>
                <svg class="w-8 h-8 text-blue-400/30" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
            </div>
        </section>

        
        <section class="grid gap-6 grid-cols-1 xl:grid-cols-[1.4fr_.8fr]">
            <div class="ops-panel rounded-lg p-4">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-semibold">Revenue (Last 30 Days)</h2>
                </div>
                <div class="chart-frame h-72">
                    <canvas id="revenueTrend"></canvas>
                </div>
            </div>
            <div class="ops-panel rounded-lg p-4">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-semibold">Status Breakdown</h2>
                </div>
                <div class="chart-frame h-72">
                    <canvas id="statusDonut"></canvas>
                </div>
            </div>
        </section>

        
        <section class="grid gap-6 grid-cols-1 xl:grid-cols-[1fr_.65fr]">
            <div class="ops-panel overflow-hidden rounded-lg">
                <div class="flex items-center justify-between border-b border-slate-800 px-4 py-3">
                    <h2 class="font-semibold">Recent Shipments</h2>
                    <a href="<?php echo e(route('shipments.index')); ?>"
                        class="text-sm font-semibold text-amber-400 hover:text-amber-300">View all →</a>
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
                                <th class="px-4 py-3">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recent_shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="border-b border-slate-800 hover:bg-slate-800/50">
                                    <td class="px-4 py-3 font-mono text-amber-400 text-xs">
                                        <a href="<?php echo e(route('shipments.show', $shipment)); ?>"
                                            class="hover:underline"><?php echo e($shipment->tracking_number); ?></a>
                                    </td>
                                    <td class="px-4 py-3 text-slate-300"><?php echo e($shipment->user?->name ?? '—'); ?></td>
                                    <td class="px-4 py-3 text-slate-400">
                                        <?php echo e($shipment->pickup_city ?? $shipment->sender_city ?? '?'); ?> → <?php echo e($shipment->delivery_city ?? $shipment->receiver_city ?? '?'); ?>

                                    </td>
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
                                    <td class="px-4 py-3 text-slate-400"><?php echo e($shipment->carrier?->name ?? '—'); ?></td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="text-xs px-2 py-1 rounded-full <?php echo e($shipment->payment?->status === 'paid' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400'); ?>">
                                            <?php echo e(ucfirst($shipment->payment?->status ?? 'unpaid')); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                        <svg class="mx-auto mb-2 w-10 h-10 text-slate-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                                        <p>No shipments yet. Data will appear once customers book shipments.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="ops-panel rounded-lg p-4">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-semibold">Recent Tracking Events</h2>
                </div>
                <div class="space-y-2 max-h-72 overflow-y-auto">
                    <?php $__empty_1 = true; $__currentLoopData = $activity_feed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="rounded border border-slate-800 bg-slate-950/60 p-3">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-mono text-xs text-amber-400"><?php echo e($event->shipment?->tracking_number ?? '—'); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e($event->created_at?->diffForHumans()); ?></p>
                            </div>
                            <p class="mt-1 text-sm text-slate-300"><?php echo e($event->description); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center text-slate-500 text-sm py-6">
                            <svg class="mx-auto mb-2 w-8 h-8 text-slate-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            No activity yet.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        
        <?php if($recent_customers->count()): ?>
        <section class="ops-panel overflow-hidden rounded-lg">
            <div class="flex items-center justify-between border-b border-slate-800 px-4 py-3">
                <h2 class="font-semibold">New Customers</h2>
                <a href="<?php echo e(route('customers.index')); ?>" class="text-sm font-semibold text-amber-400 hover:text-amber-300">View all →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[500px] text-left text-sm">
                    <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $recent_customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-slate-800 hover:bg-slate-800/50">
                                <td class="px-4 py-3 font-semibold text-white"><?php echo e($customer->name); ?></td>
                                <td class="px-4 py-3 text-slate-400"><?php echo e($customer->email); ?></td>
                                <td class="px-4 py-3 text-xs text-slate-500"><?php echo e($customer->created_at?->diffForHumans()); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        const revData = <?php echo json_encode($revenue_chart, 15, 512) ?>;
        const statusData = <?php echo json_encode($status_chart, 15, 512) ?>;

        const C = { grid: '#1e293b', text: '#cbd5e1', legend: '#cbd5e1' };

        if (revData.length > 0) {
            new Chart(document.getElementById('revenueTrend'), {
                type: 'bar',
                data: {
                    labels: revData.map(i => i.date),
                    datasets: [{
                        label: 'Revenue',
                        data: revData.map(i => i.total),
                        backgroundColor: '#f59e0b',
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { ticks: { color: C.text, maxRotation: 45 }, grid: { color: C.grid } },
                        y: { ticks: { color: C.text }, grid: { color: C.grid }, beginAtZero: true, precision: 0 }
                    }
                }
            });
        }

        if (statusData.length > 0) {
            new Chart(document.getElementById('statusDonut'), {
                type: 'doughnut',
                data: {
                    labels: statusData.map(i => i.status.replace(/_/g, ' ').toUpperCase()),
                    datasets: [{
                        data: statusData.map(i => i.count),
                        backgroundColor: ['#64748b', '#3b82f6', '#22d3ee', '#f59e0b', '#10b981', '#fb923c', '#ef4444', '#8b5cf6', '#f472b6'],
                        borderWidth: 2,
                        borderColor: '#0f172a',
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { labels: { color: C.legend, boxWidth: 12 } } }
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>