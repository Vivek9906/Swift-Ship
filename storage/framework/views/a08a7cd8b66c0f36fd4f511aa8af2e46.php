


<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Admin Login — <?php echo e(config('app.name', 'SwiftShip')); ?></title>
  <meta name="description" content="SwiftShip Admin & Staff Portal Login">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-12" style="background: linear-gradient(135deg, #0f172a 0%, #0c1a3a 50%, #0f172a 100%); font-family: Inter, ui-sans-serif, system-ui, sans-serif;">

  
  <div class="fixed inset-0 pointer-events-none" style="background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cpath d='M 80 0 L 0 0 0 80' fill='none' stroke='%231e3a5f' stroke-width='1'/%3E%3C/svg%3E\"); background-size: 80px 80px; opacity: 0.3;"></div>

  <div class="relative z-10 w-full max-w-md">

    
    <div class="text-center mb-8">
      <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-3 mb-4">
        <span class="grid h-11 w-11 place-items-center rounded-xl bg-amber-400 font-mono font-black text-slate-950 text-base shadow-lg shadow-amber-500/20">SS</span>
        <span class="text-2xl font-extrabold tracking-tight text-white">Swift<span class="text-amber-400">Ship</span></span>
      </a>
      <p class="text-sm text-slate-400 font-medium mt-1">Admin &amp; Staff Portal</p>
    </div>

    
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-black/50 backdrop-blur-sm">
      <h2 class="text-xl font-bold text-white mb-1">Welcome back</h2>
      <p class="text-xs text-slate-500 mb-6">Sign in with your logistics portal credentials</p>

      
      <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
        <?php echo csrf_field(); ?>

        
        <label class="block space-y-1.5">
          <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Email Address</span>
          <input
            name="email"
            type="email"
            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500/60 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            value="<?php echo e(old('email', 'admin@logistics.test')); ?>"
            required
            autofocus
            autocomplete="email"
            placeholder="you@example.com"
          >
        </label>

        
        <label class="block space-y-1.5">
          <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Password</span>
          <input
            name="password"
            type="password"
            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20"
            value="password"
            required
            autocomplete="current-password"
            placeholder="••••••••"
          >
        </label>

        
        <label class="flex items-center gap-2.5 text-sm text-slate-400 cursor-pointer select-none">
          <input
            name="remember"
            type="checkbox"
            class="rounded border-slate-600 bg-slate-950 text-amber-400 focus:ring-amber-400/20 w-4 h-4"
          >
          Keep me signed in
        </label>

        
        <?php if($errors->any()): ?>
          <div class="rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300 flex items-start gap-2">
            <svg class="flex-shrink-0 mt-0.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?php echo e($errors->first()); ?>

          </div>
        <?php endif; ?>

        
        <button type="submit" class="w-full rounded-xl bg-amber-400 py-3.5 text-sm font-bold text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
          Sign In to Portal
        </button>
      </form>

      <div class="mt-5 pt-5 border-t border-slate-800 text-xs text-slate-600 text-center">
        Demo: admin@logistics.test / password
      </div>
    </div>

    
    <div class="mt-5 text-center">
      <a href="<?php echo e(route('home')); ?>" class="text-sm text-slate-500 hover:text-slate-300 transition inline-flex items-center gap-1.5">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back to Homepage
      </a>
    </div>

  </div>
</body>
</html>
<?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/auth/login.blade.php ENDPATH**/ ?>