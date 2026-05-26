<?php $__env->startSection('title', 'Shipments'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5" x-data="{ addOpen: false }">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <form class="grid gap-3 sm:grid-cols-2 lg:grid-cols-6" method="GET">
            <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Search tracking, user, city" class="ops-input lg:col-span-2">
            <select name="status" class="ops-input">
                <option value="">All statuses</option>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php if(request('status') === $status): echo 'selected'; endif; ?>><?php echo e(str($status)->headline()); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="carrier_id" class="ops-input">
                <option value="">All carriers</option>
                <?php $__currentLoopData = $carriers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($carrier->id); ?>" <?php if(request('carrier_id') == $carrier->id): echo 'selected'; endif; ?>><?php echo e($carrier->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="city" class="ops-input">
                <option value="">All cities</option>
                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city); ?>" <?php if(request('city') === $city): echo 'selected'; endif; ?>><?php echo e($city); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button class="ops-button">Filter</button>
        </form>
        <button class="ops-button" @click="addOpen = true">Add New Shipment</button>
    </div>

    <form id="bulk-form" method="POST" action="<?php echo e(route('shipments.bulk')); ?>" class="ops-panel rounded-lg p-3">
        <?php echo csrf_field(); ?>
        <div class="flex flex-col gap-3 md:flex-row md:items-center">
            <select name="action" class="ops-input">
                <option value="export">Export CSV</option>
                <option value="delivered">Mark as Delivered</option>
                <option value="reassign">Reassign Carrier</option>
            </select>
            <select name="carrier_id" class="ops-input">
                <option value="">Carrier for reassignment</option>
                <?php $__currentLoopData = $carriers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($carrier->id); ?>"><?php echo e($carrier->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button class="ops-button-secondary">Apply Bulk Action</button>
        </div>
    </form>

    <div class="ops-panel overflow-hidden rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] text-left text-sm">
                <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-4 py-3"></th>
                        <?php $__currentLoopData = [
                            'tracking_number' => 'Tracking ID',
                            'user' => 'user',
                            'sender_city' => 'Origin',
                            'receiver_city' => 'Destination',
                            'status' => 'Status',
                            'carrier' => 'Carrier',
                            'estimated_delivery' => 'ETA',
                            'updated_at' => 'Last Update',
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sort => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="px-4 py-3">
                                <a href="<?php echo e(route('shipments.index', array_merge(request()->query(), ['sort' => $sort, 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>" class="hover:text-blue-200"><?php echo e($label); ?></a>
                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if (isset($component)) { $__componentOriginaled8253b00acc1e5928f9fe053d1ea740 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled8253b00acc1e5928f9fe053d1ea740 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.shipment-row','data' => ['shipment' => $shipment]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shipment-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['shipment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($shipment)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled8253b00acc1e5928f9fe053d1ea740)): ?>
<?php $attributes = $__attributesOriginaled8253b00acc1e5928f9fe053d1ea740; ?>
<?php unset($__attributesOriginaled8253b00acc1e5928f9fe053d1ea740); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled8253b00acc1e5928f9fe053d1ea740)): ?>
<?php $component = $__componentOriginaled8253b00acc1e5928f9fe053d1ea740; ?>
<?php unset($__componentOriginaled8253b00acc1e5928f9fe053d1ea740); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="9" class="px-4 py-8 text-center text-slate-400">No shipments match the current filters.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-800 px-4 py-3"><?php echo e($shipments->links()); ?></div>
    </div>

    <div x-show="addOpen" x-transition class="fixed inset-0 z-50 grid place-items-center bg-black/70 p-4" style="display:none">
        <div class="ops-panel max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-lg p-5" @click.outside="addOpen = false">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-lg font-bold">New Shipment</h2>
                <button class="ops-button-secondary" @click="addOpen = false" type="button">Close</button>
            </div>
            <form method="POST" action="<?php echo e(route('shipments.store')); ?>" class="space-y-6">
                <?php echo $__env->make('shipments._form', ['shipment' => new App\Models\Shipment], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/shipments/index.blade.php ENDPATH**/ ?>