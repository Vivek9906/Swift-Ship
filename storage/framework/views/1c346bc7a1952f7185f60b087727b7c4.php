<!DOCTYPE html><html><head><meta charset="UTF-8"><title>New Sales Lead</title>
<style>body{margin:0;padding:0;background:#f1f5f9;font-family:Inter,Arial,sans-serif;}.wrap{max-width:600px;margin:32px auto;background:#fff;border-radius:12px;overflow:hidden;}.header{background:#0f172a;padding:24px 32px;text-align:center;color:#f59e0b;font-size:18px;font-weight:700;}.body{padding:32px;}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f1f5f9;font-size:14px;}.row-label{color:#64748b;}.row-value{color:#0f172a;font-weight:600;}.footer{background:#f8fafc;border-top:1px solid #e2e8f0;padding:16px;text-align:center;font-size:12px;color:#94a3b8;}</style>
</head><body>
<div class="wrap">
  <div class="header">🔔 New Sales Lead from SwiftShip Website</div>
  <div class="body">
    <div class="row"><span class="row-label">Name</span><span class="row-value"><?php echo e($lead->name); ?></span></div>
    <div class="row"><span class="row-label">Email</span><span class="row-value"><?php echo e($lead->email); ?></span></div>
    <div class="row"><span class="row-label">Company</span><span class="row-value"><?php echo e($lead->company); ?></span></div>
    <div class="row"><span class="row-label">Phone</span><span class="row-value"><?php echo e($lead->phone); ?></span></div>
    <div class="row"><span class="row-label">Business Type</span><span class="row-value"><?php echo e($lead->business_type); ?></span></div>
    <div class="row"><span class="row-label">Monthly Volume</span><span class="row-value"><?php echo e($lead->monthly_volume); ?></span></div>
    <?php if($lead->message): ?>
    <div style="margin-top:16px;"><p style="font-size:13px;color:#64748b;margin-bottom:6px;">Message:</p><p style="font-size:14px;color:#0f172a;background:#f8fafc;border-radius:6px;padding:12px;"><?php echo e($lead->message); ?></p></div>
    <?php endif; ?>
  </div>
  <div class="footer">Submitted <?php echo e($lead->created_at->format('M d, Y H:i')); ?> IST</div>
</div>
</body></html>
<?php /**PATH D:\Swift-Ship\resources\views/emails/contact-alert.blade.php ENDPATH**/ ?>