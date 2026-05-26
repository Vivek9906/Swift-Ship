

<?php $__env->startSection('title', 'customers'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-5" x-data="{ addOpen: false, edit: null }">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" class="grid gap-3 sm:grid-cols-3">
                <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Search user" class="ops-input">
                <select name="status" class="ops-input">
                    <option value="">All statuses</option>
                    <option value="active" <?php if(request('status') === 'active'): echo 'selected'; endif; ?>>Active</option>
                    <option value="inactive" <?php if(request('status') === 'inactive'): echo 'selected'; endif; ?>>Inactive</option>
                </select>
                <button class="ops-button">Filter</button>
            </form>
            <?php if(auth()->user()?->canManage()): ?>
                <button class="ops-button" @click="addOpen = true">Add user</button>
            <?php endif; ?>
        </div>

        <div class="ops-panel overflow-hidden rounded-lg">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left text-sm">
                    <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone</th>
                            <th class="px-4 py-3">City</th>
                            <th class="px-4 py-3">Total Shipments</th>
                            <th class="px-4 py-3">Last Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-slate-800 hover:bg-slate-800/60">
                                <td class="px-4 py-3 font-semibold"><span class="hover:text-blue-200"><?php echo e($user->name); ?></span></td>
                                <td class="px-4 py-3"><?php echo e($user->email); ?></td>
                                <td class="px-4 py-3"><?php echo e($user->phone); ?></td>
                                <td class="px-4 py-3"><?php echo e($user->city); ?></td>
                                <td class="px-4 py-3"><?php echo e($user->shipments_count); ?></td>
                                <td class="px-4 py-3">
                                    <?php echo e(optional($user->shipments()->latest()->first())->created_at?->format('M d, Y') ?? 'No orders'); ?>

                                </td>
                                <td class="px-4 py-3"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $user->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user->status)]); ?>
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
                                <td class="px-4 py-3 text-right">
                                    <?php if(auth()->user()?->canManage()): ?>
                                        <button class="text-sm font-semibold text-blue-300"
                                            @click='edit = <?php echo json_encode($user, 15, 512) ?>'>Edit</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-800 px-4 py-3"><?php echo e($customers->links()); ?></div>
        </div>

        <div x-show="addOpen || edit" x-transition class="fixed inset-0 z-50 grid place-items-center bg-black/70 p-4"
            style="display:none">
            <form method="POST" :action="edit ? `/admin/customers/${edit.id}` : '<?php echo e(route('customers.store')); ?>'"
                class="ops-panel w-full max-w-2xl space-y-4 rounded-lg p-5" @click.outside="addOpen = false; edit = null">
                <?php echo csrf_field(); ?>
                <template x-if="edit"><input type="hidden" name="_method" value="PUT"></template>
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold" x-text="edit ? 'Edit user' : 'Add user'"></h2>
                    <button type="button" class="ops-button-secondary" @click="addOpen = false; edit = null">Close</button>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <input name="name" class="ops-input" placeholder="Name" :value="edit?.name" required>
                    <input name="email" type="email" class="ops-input" placeholder="Email" :value="edit?.email" required>
                    <input name="phone" class="ops-input" placeholder="Phone" :value="edit?.phone" required>
                    <input name="city" class="ops-input" placeholder="City" :value="edit?.city" required>
                    <select name="status" class="ops-input">
                        <option value="active" :selected="edit?.status === 'active'">Active</option>
                        <option value="inactive" :selected="edit?.status === 'inactive'">Inactive</option>
                    </select>
                    <textarea name="address" class="ops-input md:col-span-2" rows="3" placeholder="Address"
                        x-text="edit?.address" required></textarea>
                    <textarea name="notes" class="ops-input md:col-span-2" rows="3" placeholder="Notes"
                        x-text="edit?.notes"></textarea>
                </div>
                <div class="flex justify-end"><button class="ops-button">Save user</button></div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Swift-Ship\resources\views/customers/index.blade.php ENDPATH**/ ?>