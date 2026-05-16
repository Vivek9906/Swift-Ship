<?php $__env->startSection('content'); ?>
<?php if(! $shipment): ?>
    <section class="mx-auto max-w-2xl ops-panel rounded-lg p-6">
        <p class="font-mono text-sm text-red-300"><?php echo e($trackingNumber); ?></p>
        <h1 class="mt-2 text-2xl font-bold">Shipment not found</h1>
        <p class="mt-2 text-slate-400">Check the tracking number and try again.</p>
        <form method="POST" action="<?php echo e(route('tracking.lookup.submit')); ?>" class="mt-5 flex flex-col gap-3 sm:flex-row">
            <?php echo csrf_field(); ?>
            <input name="tracking_number" value="<?php echo e($trackingNumber); ?>" class="ops-input flex-1 font-mono" required>
            <button class="ops-button">Search Again</button>
        </form>
    </section>
<?php else: ?>
    <div class="space-y-6">
        <section class="ops-panel rounded-lg p-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <p class="font-mono text-sm text-blue-200"><?php echo e($shipment->tracking_number); ?></p>
                    <h1 class="mt-1 text-3xl font-bold"><?php echo e($shipment->sender_city); ?> -> <?php echo e($shipment->receiver_city); ?></h1>
                    <p class="mt-2 text-sm text-slate-400">For <?php echo e($shipment->receiver_name); ?> - ETA <?php echo e($shipment->estimated_delivery?->format('M d, Y H:i')); ?></p>
                </div>
                <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
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
<?php endif; ?>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="ops-panel overflow-hidden rounded-lg">
                <div id="customerTrackingMap" class="h-[430px]"></div>
            </div>

            <aside class="ops-panel rounded-lg p-5">
                <h2 class="font-semibold">Delivery Details</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div><dt class="text-xs uppercase text-slate-500">Carrier</dt><dd class="mt-1 font-semibold"><?php echo e($shipment->carrier?->name ?? 'Assigning carrier'); ?></dd></div>
                    <div><dt class="text-xs uppercase text-slate-500">Current Location</dt><dd class="mt-1 font-semibold"><?php echo e($shipment->trackingEvents->last()?->location_name ?? $shipment->sender_city); ?></dd></div>
                    <div><dt class="text-xs uppercase text-slate-500">Destination</dt><dd class="mt-1 font-semibold"><?php echo e($shipment->receiver_address); ?></dd></div>
                </dl>
            </aside>
        </section>

        <section class="ops-panel rounded-lg p-5">
            <h2 class="mb-5 font-semibold">Tracking Updates</h2>
            <ol class="relative space-y-6 border-l border-slate-700 pl-6">
                <?php $__currentLoopData = $shipment->trackingEvents->sortByDesc('occurred_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <span class="absolute -left-2.5 mt-1 h-5 w-5 rounded-full border-2 border-slate-950 bg-blue-400"></span>
                        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                            <p class="font-semibold"><?php echo e(str($event->status)->headline()); ?></p>
                            <time class="font-mono text-xs text-slate-500"><?php echo e($event->occurred_at?->format('M d, H:i')); ?></time>
                        </div>
                        <p class="text-sm text-slate-400"><?php echo e($event->location_name); ?> - <?php echo e($event->description); ?></p>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>
        </section>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php if($shipment): ?>
<?php $__env->startPush('scripts'); ?>
<script>
    const customerRoute = <?php echo json_encode($route, 15, 512) ?>;
    const customerMap = L.map('customerTrackingMap', { zoomControl: true }).setView(customerRoute.current, 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(customerMap);
    const origin = L.latLng(customerRoute.origin[0], customerRoute.origin[1]);
    const destination = L.latLng(customerRoute.destination[0], customerRoute.destination[1]);
    const current = L.latLng(customerRoute.current[0], customerRoute.current[1]);
    L.polyline([origin, current, destination], { color: '#2563eb', weight: 4, dashArray: '8 10' }).addTo(customerMap);
    L.marker(origin).addTo(customerMap).bindPopup('Origin');
    L.marker(destination).addTo(customerMap).bindPopup('Destination');
    L.circleMarker(current, { radius: 9, color: '#f59e0b', fillColor: '#fbbf24', fillOpacity: 0.9 }).addTo(customerMap).bindPopup('Current package location').openPopup();
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/tracking/public-show.blade.php ENDPATH**/ ?>