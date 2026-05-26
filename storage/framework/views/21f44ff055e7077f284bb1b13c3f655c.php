<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $colors = [
        'pending' => 'border-slate-600 bg-slate-700/40 text-slate-200',
        'confirmed' => 'border-sky-500/50 bg-sky-500/15 text-sky-200',
        'picked_up' => 'border-violet-500/50 bg-violet-500/15 text-violet-200',
        'in_transit' => 'border-blue-500/50 bg-blue-500/15 text-blue-200',
        'arrived_at_city' => 'border-cyan-400/50 bg-cyan-400/15 text-cyan-100',
        'out_for_delivery' => 'border-amber-400/60 bg-amber-400/15 text-amber-100',
        'delivered' => 'border-emerald-400/60 bg-emerald-400/15 text-emerald-100',
        'delayed' => 'border-orange-400/60 bg-orange-400/15 text-orange-100',
        'cancelled' => 'border-red-400/60 bg-red-500/15 text-red-200',
        'failed' => 'border-red-400/60 bg-red-400/15 text-red-100',
        'active' => 'border-emerald-400/60 bg-emerald-400/15 text-emerald-100',
        'inactive' => 'border-slate-600 bg-slate-700/40 text-slate-200',
    ];
?>

<span <?php echo e($attributes->merge([
    'class' => 'inline-flex items-center rounded border px-2 py-1 text-xs font-semibold uppercase tracking-wide ' .
    ($colors[$status] ?? $colors['inactive'])
])); ?>>
    <?php echo e(str($status ?: 'inactive')->headline()); ?>

</span>
<?php /**PATH D:\Swift-Ship\resources\views/components/status-badge.blade.php ENDPATH**/ ?>