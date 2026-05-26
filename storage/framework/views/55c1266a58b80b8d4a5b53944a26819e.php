<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['shipment']));

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

foreach (array_filter((['shipment']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<tr class="border-b border-slate-800 transition hover:bg-slate-800/60">
    <td class="px-4 py-3">
        <input form="bulk-form" type="checkbox" name="shipment_ids[]" value="<?php echo e($shipment->id); ?>"
            class="rounded border-slate-600 bg-slate-950 text-blue-500">
    </td>
    <td class="px-4 py-3 font-mono text-blue-200">
        <a href="<?php echo e(route('shipments.show', $shipment)); ?>"
            class="hover:text-blue-100"><?php echo e($shipment->tracking_number); ?></a>
    </td>
    <td class="px-4 py-3"><?php echo e($shipment->user?->name ?? 'No user'); ?></td>
    <td class="px-4 py-3"><?php echo e($shipment->sender_city); ?></td>
    <td class="px-4 py-3"><?php echo e($shipment->receiver_city); ?></td>
    <td class="px-4 py-3"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
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
<?php endif; ?></td>
    <td class="px-4 py-3"><?php echo e($shipment->carrier->name ?? 'No Carrier'); ?></td>
    <td class="px-4 py-3"><?php echo e($shipment->estimated_delivery?->format('M d, H:i')); ?></td>
    <td class="px-4 py-3 text-slate-400"><?php echo e($shipment->updated_at->diffForHumans()); ?></td>
</tr><?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/components/shipment-row.blade.php ENDPATH**/ ?>