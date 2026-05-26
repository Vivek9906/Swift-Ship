

<?php $__env->startSection('page_title', 'Contact Leads'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
  
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-xl font-bold text-white">Contact Leads</h1>
      <p class="text-slate-400 text-sm mt-0.5">Sales inquiries from the public contact form</p>
    </div>
    <a href="<?php echo e(route('admin.leads.index', ['status' => ''])); ?>" class="text-xs text-slate-400 hover:text-amber-400 border border-slate-700 rounded-lg px-3 py-1.5 hover:border-amber-400/40 transition">
      All Leads
    </a>
  </div>

  
  <form method="GET" class="flex flex-wrap gap-3">
    <?php $__currentLoopData = ['new'=>'New','contacted'=>'Contacted','qualified'=>'Qualified','closed'=>'Closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('admin.leads.index', ['status' => $val])); ?>"
       class="rounded-lg px-4 py-1.5 text-xs font-semibold border transition <?php echo e(request('status') === $val ? 'bg-amber-400 text-slate-950 border-amber-400' : 'border-slate-700 text-slate-400 hover:border-amber-400/40 hover:text-amber-400'); ?>">
      <?php echo e($label); ?>

    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </form>

  
  <div class="rounded-2xl border border-slate-800 bg-slate-900/80 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full min-w-[900px] text-left text-sm">
        <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-500 border-b border-slate-800">
          <tr>
            <th class="px-5 py-3">Name / Company</th>
            <th class="px-5 py-3">Contact</th>
            <th class="px-5 py-3">Type</th>
            <th class="px-5 py-3">Volume</th>
            <th class="px-5 py-3">Date</th>
            <th class="px-5 py-3">Status</th>
            <th class="px-5 py-3">Message</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="border-b border-slate-800 hover:bg-slate-800/40 transition">
            <td class="px-5 py-3">
              <p class="font-semibold text-white"><?php echo e($lead->name); ?></p>
              <p class="text-xs text-slate-500"><?php echo e($lead->company); ?></p>
            </td>
            <td class="px-5 py-3">
              <p class="text-slate-300 text-xs"><?php echo e($lead->email); ?></p>
              <p class="text-slate-500 text-xs"><?php echo e($lead->phone); ?></p>
            </td>
            <td class="px-5 py-3 text-slate-400 text-xs"><?php echo e($lead->business_type); ?></td>
            <td class="px-5 py-3 text-slate-400 text-xs"><?php echo e($lead->monthly_volume); ?></td>
            <td class="px-5 py-3 text-slate-500 text-xs"><?php echo e($lead->created_at->format('M d, Y')); ?></td>
            <td class="px-5 py-3">
              <select onchange="updateLeadStatus('<?php echo e($lead->id); ?>', this.value)"
                class="rounded-lg border border-slate-700 bg-slate-800 text-xs px-2 py-1 text-slate-300 outline-none focus:border-amber-400 transition cursor-pointer">
                <?php $__currentLoopData = ['new'=>'New','contacted'=>'Contacted','qualified'=>'Qualified','closed'=>'Closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php echo e($lead->status === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </td>
            <td class="px-5 py-3">
              <?php if($lead->message): ?>
              <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-xs text-slate-500 hover:text-amber-400 transition underline decoration-dotted">View</button>
              <p class="hidden text-xs text-slate-400 mt-1 max-w-[200px]"><?php echo e($lead->message); ?></p>
              <?php else: ?>
              <span class="text-slate-700 text-xs">—</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="7" class="px-5 py-12 text-center text-slate-500">No leads yet. Contact form submissions will appear here.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if($leads->hasPages()): ?>
    <div class="px-5 py-4 border-t border-slate-800"><?php echo e($leads->links()); ?></div>
    <?php endif; ?>
  </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
async function updateLeadStatus(id, status) {
  const res = await fetch(`/admin/leads/${id}/status`, {
    method: 'PATCH',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
    body: JSON.stringify({ status })
  });
  const data = await res.json();
  if (data.success) {
    // Quick visual feedback
    const badge = event.target;
    badge.style.borderColor = '#f59e0b';
    setTimeout(() => badge.style.borderColor = '', 1500);
  }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Swift-Ship\resources\views/admin/leads/index.blade.php ENDPATH**/ ?>