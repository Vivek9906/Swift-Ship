

<?php $__env->startSection('title', 'Carriers'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5">
    <form method="GET" class="grid gap-3 sm:grid-cols-4">
        <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Search carrier" class="ops-input">
        <select name="type" class="ops-input">
            <option value="">All modes</option>
            <?php $__currentLoopData = ['air', 'ground', 'sea']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type); ?>" <?php if(request('type') === $type): echo 'selected'; endif; ?>><?php echo e(str($type)->headline()); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="ops-button">Filter</button>
    </form>
    <div class="ops-panel overflow-hidden rounded-lg">
        <table class="w-full min-w-[800px] text-left text-sm">
            <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Active Shipments</th>
                    <th class="px-4 py-3">On-Time %</th>
                    <th class="px-4 py-3">Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $carriers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b border-slate-800 hover:bg-slate-800/60">
                        <td class="px-4 py-3 font-semibold"><a href="<?php echo e(route('carriers.show', $carrier)); ?>" class="hover:text-blue-200"><?php echo e($carrier->name); ?></a></td>
                        <td class="px-4 py-3"><?php echo e(str($carrier->type)->headline()); ?></td>
                        <td class="px-4 py-3"><?php echo e($carrier->active_shipments); ?></td>
                        <td class="px-4 py-3">
                            <div class="h-2 w-44 rounded bg-slate-800"><div class="h-2 rounded bg-emerald-400" style="width: <?php echo e($carrier->on_time_rate); ?>%"></div></div>
                            <span class="mt-1 block text-xs text-slate-400"><?php echo e($carrier->on_time_rate); ?>%</span>
                        </td>
                        <td class="px-4 py-3"><?php echo e($carrier->rating); ?> / 5</td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="border-t border-slate-800 px-4 py-3"><?php echo e($carriers->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Swift-Ship\resources\views/carriers/index.blade.php ENDPATH**/ ?>