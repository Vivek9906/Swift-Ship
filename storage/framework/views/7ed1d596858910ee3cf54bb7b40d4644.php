
<?php $__env->startSection('title', 'Shipment Details'); ?>
<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="<?php echo e(route('customer.dashboard')); ?>" class="ops-button-secondary">← Back</a>
        <h2 class="text-xl font-bold text-white">Shipment #<?php echo e($shipment->tracking_number); ?></h2>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        
        <div class="ops-panel rounded-lg p-6 space-y-4">
            <h3 class="font-semibold text-white border-b border-slate-800 pb-3">Shipment Information</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-slate-400">Status</dt><dd><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
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
<?php endif; ?></dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Carrier</dt><dd class="text-white"><?php echo e($shipment->carrier?->name ?? 'N/A'); ?></dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Service</dt><dd class="text-white"><?php echo e(ucfirst($shipment->service_type)); ?></dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">From</dt><dd class="text-white"><?php echo e($shipment->pickup_city); ?>, <?php echo e($shipment->pickup_state); ?></dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">To</dt><dd class="text-white"><?php echo e($shipment->delivery_city); ?>, <?php echo e($shipment->delivery_state); ?></dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Weight</dt><dd class="text-white"><?php echo e($shipment->weight); ?> kg</dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">ETA</dt><dd class="text-white"><?php echo e($shipment->estimated_delivery ? \Carbon\Carbon::parse($shipment->estimated_delivery)->format('D, d M Y') : 'TBD'); ?></dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Total Fare</dt><dd class="text-amber-400 font-bold">₹<?php echo e(number_format($shipment->cost, 2)); ?></dd></div>
            </dl>

            <?php if($shipment->payment?->status === 'pending' || $shipment->status === 'pending'): ?>
                <div class="border-t border-slate-800 pt-4 mt-4 flex flex-col sm:flex-row gap-3">
                    <a href="<?php echo e(route('customer.shipments.resume-payment', $shipment->id)); ?>" 
                       class="flex-1 rounded-xl bg-amber-400 px-5 py-3.5 text-xs font-bold text-slate-950 hover:bg-amber-300 transition text-center shadow-lg shadow-amber-500/10">
                        💳 Proceed to Payment
                    </a>
                    <form action="<?php echo e(route('customer.shipments.delete', $shipment->id)); ?>" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this pending shipment?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="w-full rounded-xl border border-red-500/30 bg-red-500/5 px-5 py-3.5 text-xs font-bold text-red-400 hover:bg-red-500/10 hover:border-red-500/50 transition">
                            🗑️ Delete Shipment
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="ops-panel rounded-lg p-6">
            <h3 class="font-semibold text-white border-b border-slate-800 pb-3 mb-4">Tracking History</h3>
            <?php if($shipment->trackingEvents->isEmpty()): ?>
                <p class="text-slate-500 text-sm text-center py-8">No tracking events yet.</p>
            <?php else: ?>
                <ol class="relative border-l border-slate-700 space-y-5 ml-3">
                    <?php $__currentLoopData = $shipment->trackingEvents->reverse(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="ml-6">
                            <span class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full bg-amber-400 ring-4 ring-slate-950">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" class="text-slate-950"><circle cx="12" cy="12" r="8"/></svg>
                            </span>
                            <p class="text-sm font-semibold text-white"><?php echo e(ucwords(str_replace('_', ' ', $event->status))); ?></p>
                            <p class="text-xs text-slate-400"><?php echo e($event->location_name ?? $event->location ?? ''); ?></p>
                            <p class="text-xs text-slate-500"><?php echo e($event->description); ?></p>
                            <time class="text-xs text-slate-600"><?php echo e(\Carbon\Carbon::parse($event->occurred_at ?? $event->created_at)->format('d M Y, H:i')); ?></time>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Swift-Ship\resources\views/customer/shipment-detail.blade.php ENDPATH**/ ?>