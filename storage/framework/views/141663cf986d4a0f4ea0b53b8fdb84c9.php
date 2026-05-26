<?php
    $isAdmin = auth()->check() && auth()->user()->isAdminOrStaff();

    $adminItems = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z'],
        ['route' => 'shipments.index', 'label' => 'Shipments', 'icon' => 'M4 7h11v10H4V7Zm11 3h3l2 3v4h-5v-7ZM7 19a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm10 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'],
        ['route' => 'tracking.live-map', 'label' => 'Live Map', 'icon' => 'M12 2 5 5v17l7-3 7 3V5l-7-3Zm0 2.2 5 2.1v12.6l-5-2.1V4.2Z'],
        ['route' => 'customers.index', 'label' => 'Customers', 'icon' => 'M16 11a4 4 0 1 0-8 0 4 4 0 0 0 8 0ZM4 21a8 8 0 0 1 16 0H4Z'],
        ['route' => 'carriers.index', 'label' => 'Carriers', 'icon' => 'M3 6h18v4H3V6Zm2 6h14v6H5v-6Zm3 8h8v2H8v-2Z'],
        ['route' => 'admin.leads.index', 'label' => 'Contact Leads', 'icon' => 'M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z'],
        ['route' => 'notifications.index', 'label' => 'Alerts', 'icon' => 'M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22Zm7-6V11a7 7 0 0 0-14 0v5l-2 2v1h18v-1l-2-2Z'],
        ['route' => 'settings', 'label' => 'Settings', 'icon' => 'M19.4 13.5a7.7 7.7 0 0 0 0-3l2-1.5-2-3.5-2.4 1a8 8 0 0 0-2.6-1.5L14 2h-4l-.4 3a8 8 0 0 0-2.6 1.5l-2.4-1-2 3.5 2 1.5a7.7 7.7 0 0 0 0 3l-2 1.5 2 3.5 2.4-1a8 8 0 0 0 2.6 1.5l.4 3h4l.4-3a8 8 0 0 0 2.6-1.5l2.4 1 2-3.5-2-1.5ZM12 15.5A3.5 3.5 0 1 1 12 8a3.5 3.5 0 0 1 0 7.5Z'],
    ];

    $customerItems = [
        ['route' => 'customer.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z'],
        ['route' => 'customer.shipments', 'label' => 'My Shipments', 'icon' => 'M4 7h11v10H4V7Zm11 3h3l2 3v4h-5v-7ZM7 19a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm10 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'],
        ['route' => 'customer.shipments.new', 'label' => 'Book Shipment', 'icon' => 'M12 4v16m8-8H4'],
        ['route' => 'tracking.lookup', 'label' => 'Track Shipment', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
        ['route' => 'customer.profile', 'label' => 'My Profile', 'icon' => 'M12 14a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4 20c0-3.3 3.6-6 8-6s8 2.7 8 6'],
    ];

    $items = $isAdmin ? $adminItems : $customerItems;
?>

<nav class="space-y-1">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $active = request()->routeIs($item['route'].'*'); ?>
        <a href="<?php echo e(route($item['route'])); ?>" class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition-all duration-200
                      <?php echo e($active
            ? 'bg-amber-400/15 text-amber-400 border border-amber-400/20'
            : 'text-slate-400 hover:bg-slate-800 hover:text-white border border-transparent'); ?>">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="<?php echo e(str_contains($item['icon'], 'M12 4v16') ? 'none' : 'currentColor'); ?>"
                 stroke="<?php echo e(str_contains($item['icon'], 'M12 4v16') || str_contains($item['icon'], 'M21 21') || str_contains($item['icon'], 'M12 14') ? 'currentColor' : 'none'); ?>"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="<?php echo e($item['icon']); ?>" />
            </svg>
            <span><?php echo e($item['label']); ?></span>
            <?php if($active): ?>
                <span class="ml-auto w-1.5 h-1.5 rounded-full bg-amber-400"></span>
            <?php endif; ?>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
<?php /**PATH D:\Swift-Ship\resources\views/components/sidebar-nav.blade.php ENDPATH**/ ?>