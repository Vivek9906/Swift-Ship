<?php $__env->startSection('content'); ?>
<section class="grid min-h-[calc(100vh-112px)] items-center gap-8 lg:grid-cols-[1fr_420px]">
    <div>
        <p class="font-mono text-sm text-blue-200">CUSTOMER TRACKING</p>
        <h1 class="mt-3 text-4xl font-extrabold sm:text-5xl">Track your delivery update</h1>
        <p class="mt-4 max-w-2xl text-slate-400">Enter the tracking number from your confirmation message to see the current status, ETA, route position, and latest scan history.</p>
    </div>

    <form method="POST" action="<?php echo e(route('tracking.lookup.submit')); ?>" class="ops-panel rounded-lg p-5">
        <?php echo csrf_field(); ?>
        <label class="space-y-2">
            <span class="text-xs font-semibold uppercase text-slate-400">Tracking Number</span>
            <input name="tracking_number" value="<?php echo e(old('tracking_number')); ?>" placeholder="IND2605AX91P" class="ops-input w-full font-mono" required autofocus>
        </label>
        <?php if($errors->any()): ?>
            <div class="mt-4 rounded border border-red-400/50 bg-red-400/10 p-3 text-sm text-red-100"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>
        <button class="ops-button mt-5 w-full">Track Shipment</button>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/tracking/lookup.blade.php ENDPATH**/ ?>