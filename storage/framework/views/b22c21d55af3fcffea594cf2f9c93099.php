

<?php $__env->startSection('title', 'Notifications & Alerts'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5" x-data="alertFeed()" x-init="start()">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold">Alert Queue</h2>
            <p class="text-sm text-slate-400">Delays, failed attempts, and approaching deadlines</p>
        </div>
        <form method="POST" action="<?php echo e(route('notifications.read-all')); ?>">
            <?php echo csrf_field(); ?>
            <button class="ops-button-secondary">Resolve All</button>
        </form>
    </div>

    <div class="grid gap-4 xl:grid-cols-[1fr_360px]">
        <section class="ops-panel rounded-lg">
            <div class="divide-y divide-slate-800">
                <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex flex-col gap-3 p-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="font-semibold"><?php echo e($notification->data['message'] ?? 'Shipment alert'); ?></p>
                            <p class="mt-1 font-mono text-xs text-blue-200"><?php echo e($notification->data['tracking_number'] ?? 'N/A'); ?></p>
                            <p class="mt-1 text-xs text-slate-500"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                        </div>
                        <div class="flex gap-2">
                            <form method="POST" action="<?php echo e(route('notifications.read', $notification->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="ops-button">Resolve</button>
                            </form>
                            <form method="POST" action="<?php echo e(route('notifications.snooze', $notification->id)); ?>" class="flex gap-2">
                                <?php echo csrf_field(); ?>
                                <select name="minutes" class="ops-input py-1">
                                    <option value="30">30m</option>
                                    <option value="120">2h</option>
                                    <option value="1440">1d</option>
                                </select>
                                <button class="ops-button-secondary">Snooze</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-8 text-center text-slate-400">No database alerts are open.</div>
                <?php endif; ?>
            </div>
            <div class="border-t border-slate-800 px-4 py-3"><?php echo e($notifications->links()); ?></div>
        </section>

        <aside class="ops-panel rounded-lg p-4">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-semibold">Simulated Feed</h3>
                <span class="h-2 w-2 animate-pulse rounded-full bg-amber-400"></span>
            </div>
            <div class="space-y-3">
                <template x-for="alert in alerts" :key="alert.id">
                    <div class="rounded border border-slate-800 bg-slate-950/60 p-3">
                        <p class="font-mono text-xs text-amber-200" x-text="alert.code"></p>
                        <p class="mt-1 text-sm" x-text="alert.message"></p>
                        <p class="mt-1 text-xs text-slate-500" x-text="alert.time"></p>
                    </div>
                </template>
            </div>
        </aside>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function alertFeed() {
        const messages = ['Deadline approaching on metro lane', 'Failed delivery attempt logged', 'Delay threshold crossed at sorting hub', 'Carrier capacity warning issued'];
        return {
            alerts: [],
            start() {
                setInterval(() => {
                    this.alerts.unshift({
                        id: Date.now(),
                        code: `ALRT-${Math.floor(Math.random() * 9000 + 1000)}`,
                        message: messages[Math.floor(Math.random() * messages.length)],
                        time: 'just now'
                    });
                    this.alerts = this.alerts.slice(0, 8);
                }, 12000);
            }
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Swift-Ship\resources\views/notifications/index.blade.php ENDPATH**/ ?>