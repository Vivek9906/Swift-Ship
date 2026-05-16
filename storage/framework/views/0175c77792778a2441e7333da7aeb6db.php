<?php $__env->startSection('title', 'Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid gap-6 xl:grid-cols-3">
    <section class="ops-panel rounded-lg p-5 xl:col-span-2">
        <h2 class="mb-4 font-semibold">Company Profile</h2>
        <div class="grid gap-4 md:grid-cols-2">
            <label class="space-y-1"><span class="text-xs uppercase text-slate-400">Company</span><input class="ops-input w-full" value="Northstar Distribution Pvt Ltd"></label>
            <label class="space-y-1"><span class="text-xs uppercase text-slate-400">Control Email</span><input class="ops-input w-full" value="ops@northstar.example"></label>
            <label class="space-y-1"><span class="text-xs uppercase text-slate-400">Default SLA</span><input class="ops-input w-full" value="48 hours"></label>
            <label class="space-y-1"><span class="text-xs uppercase text-slate-400">Region</span><input class="ops-input w-full" value="India National"></label>
        </div>
        <button class="ops-button mt-5">Save Profile</button>
    </section>

    <section class="ops-panel rounded-lg p-5" x-data="{ email: true, broadcast: true, digest: false }">
        <h2 class="mb-4 font-semibold">Notification Preferences</h2>
        <div class="space-y-3">
            <label class="flex items-center justify-between gap-3"><span>Email alerts</span><input type="checkbox" x-model="email" class="rounded bg-slate-950 text-blue-500"></label>
            <label class="flex items-center justify-between gap-3"><span>Broadcast alerts</span><input type="checkbox" x-model="broadcast" class="rounded bg-slate-950 text-blue-500"></label>
            <label class="flex items-center justify-between gap-3"><span>Daily digest</span><input type="checkbox" x-model="digest" class="rounded bg-slate-950 text-blue-500"></label>
        </div>
    </section>

    <section class="ops-panel rounded-lg p-5 xl:col-span-3">
        <h2 class="mb-4 font-semibold">User Roles</h2>
        <div class="grid gap-4 md:grid-cols-3">
            <?php $__currentLoopData = ['Admin' => 'Full system control', 'Manager' => 'Create and update operations data', 'Viewer' => 'Read-only command-center access']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $description): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded border border-slate-800 p-4">
                    <p class="font-semibold"><?php echo e($role); ?></p>
                    <p class="mt-2 text-sm text-slate-400"><?php echo e($description); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/settings/index.blade.php ENDPATH**/ ?>