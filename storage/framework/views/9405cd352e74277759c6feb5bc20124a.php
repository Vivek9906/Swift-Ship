<?php echo csrf_field(); ?>
<?php if($shipment?->exists): ?>
    <?php echo method_field('PUT'); ?>
<?php endif; ?>

<div class="grid gap-4 md:grid-cols-2">
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">user</span>
        <select name="user_id" class="ops-input w-full" required>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($user->id); ?>" <?php if(old('user_id', $shipment->user_id) == $user->id): echo 'selected'; endif; ?>><?php echo e($user->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Carrier</span>
        <select name="carrier_id" class="ops-input w-full" required>
            <?php $__currentLoopData = $carriers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($carrier->id); ?>" <?php if(old('carrier_id', $shipment->carrier_id) == $carrier->id): echo 'selected'; endif; ?>>
                    <?php echo e($carrier->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Sender</span>
        <input name="sender_name" value="<?php echo e(old('sender_name', $shipment->sender_name)); ?>" class="ops-input w-full"
            required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Receiver</span>
        <input name="receiver_name" value="<?php echo e(old('receiver_name', $shipment->receiver_name)); ?>"
            class="ops-input w-full" required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Origin City</span>
        <select name="sender_city" class="ops-input w-full" required>
            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($city); ?>" <?php if(old('sender_city', $shipment->sender_city) === $city): echo 'selected'; endif; ?>><?php echo e($city); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Destination City</span>
        <select name="receiver_city" class="ops-input w-full" required>
            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($city); ?>" <?php if(old('receiver_city', $shipment->receiver_city) === $city): echo 'selected'; endif; ?>><?php echo e($city); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Weight kg</span>
        <input type="number" step="0.1" name="weight" value="<?php echo e(old('weight', $shipment->weight)); ?>"
            class="ops-input w-full" required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Dimensions</span>
        <input name="dimensions" value="<?php echo e(old('dimensions', $shipment->dimensions)); ?>" class="ops-input w-full"
            required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Status</span>
        <select name="status" class="ops-input w-full" required>
            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($status); ?>" <?php if(old('status', $shipment->status ?: 'pending') === $status): echo 'selected'; endif; ?>>
                    <?php echo e(str($status)->headline()); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Cost INR</span>
        <input type="number" step="0.01" name="cost" value="<?php echo e(old('cost', $shipment->cost ?: 850)); ?>"
            class="ops-input w-full" required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">ETA</span>
        <input type="datetime-local" name="estimated_delivery"
            value="<?php echo e(old('estimated_delivery', optional($shipment->estimated_delivery)->format('Y-m-d\TH:i'))); ?>"
            class="ops-input w-full" required>
    </label>
    <label class="space-y-1 md:col-span-2">
        <span class="text-xs font-semibold uppercase text-slate-400">Receiver Address</span>
        <textarea name="receiver_address" rows="3" class="ops-input w-full"
            required><?php echo e(old('receiver_address', $shipment->receiver_address)); ?></textarea>
    </label>
</div>

<?php if($errors->any()): ?>
    <div class="rounded border border-red-400/50 bg-red-400/10 p-3 text-sm text-red-100">
        <?php echo e($errors->first()); ?>

    </div>
<?php endif; ?>

<div class="flex justify-end gap-3">
    <a href="<?php echo e(route('shipments.index')); ?>" class="ops-button-secondary">Cancel</a>
    <button class="ops-button">Save Shipment</button>
</div><?php /**PATH D:\Swift-Ship\resources\views/shipments/_form.blade.php ENDPATH**/ ?>