<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'value', 'accent' => 'blue', 'trend' => null]));

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

foreach (array_filter((['label', 'value', 'accent' => 'blue', 'trend' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $accentClasses = [
        'blue' => 'text-blue-300 border-blue-500/30',
        'amber' => 'text-amber-300 border-amber-500/30',
        'emerald' => 'text-emerald-300 border-emerald-500/30',
        'red' => 'text-red-300 border-red-500/30',
    ];
?>

<article <?php echo e($attributes->merge(['class' => 'ops-panel rounded-lg p-4'])); ?>>
    <div class="flex items-start justify-between gap-3">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400"><?php echo e($label); ?></p>
        <span class="h-2 w-2 rounded-full bg-current <?php echo e($accentClasses[$accent] ?? $accentClasses['blue']); ?>"></span>
    </div>
    <div class="mt-3 flex items-end justify-between">
        <p class="text-3xl font-bold <?php echo e($accentClasses[$accent] ?? $accentClasses['blue']); ?>"><?php echo e($value); ?></p>
        <?php if($trend): ?>
            <p class="text-xs text-slate-400"><?php echo e($trend); ?></p>
        <?php endif; ?>
    </div>
</article>
<?php /**PATH D:\Swift-Ship\resources\views/components/kpi-card.blade.php ENDPATH**/ ?>