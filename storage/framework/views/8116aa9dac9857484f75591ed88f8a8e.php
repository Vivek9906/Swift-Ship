<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="{ sidebar: false, theme: localStorage.getItem('theme') || 'dark' }" x-init="$watch('theme', value => localStorage.setItem('theme', value))" :class="{ 'light': theme === 'light' }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name')); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <aside class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r border-slate-800 bg-slate-950 p-4 transition lg:static lg:translate-x-0" :class="{ 'translate-x-0': sidebar }">
            <div class="mb-8 flex items-center justify-between">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded bg-amber-400 font-mono font-black text-slate-950">LX</span>
                    <span>
                        <span class="block text-sm font-bold uppercase tracking-wider">Logistics</span>
                        <span class="block text-xs text-slate-400">Control Tower</span>
                    </span>
                </a>
                <button class="lg:hidden" @click="sidebar = false">✕</button>
            </div>
            <?php if (isset($component)) { $__componentOriginala84898f20479e38f2bc0cbb2808b7dee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala84898f20479e38f2bc0cbb2808b7dee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala84898f20479e38f2bc0cbb2808b7dee)): ?>
<?php $attributes = $__attributesOriginala84898f20479e38f2bc0cbb2808b7dee; ?>
<?php unset($__attributesOriginala84898f20479e38f2bc0cbb2808b7dee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala84898f20479e38f2bc0cbb2808b7dee)): ?>
<?php $component = $__componentOriginala84898f20479e38f2bc0cbb2808b7dee; ?>
<?php unset($__componentOriginala84898f20479e38f2bc0cbb2808b7dee); ?>
<?php endif; ?>
        </aside>

        <div class="min-w-0">
            <header class="sticky top-0 z-30 border-b border-slate-800 bg-slate-950/90 backdrop-blur">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <button class="ops-button-secondary lg:hidden" @click="sidebar = true">☰</button>
                        <div>
                            <h1 class="text-lg font-bold"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
                            <p class="hidden text-xs text-slate-400 sm:block">Ops synchronized at <?php echo e(now()->format('H:i')); ?> IST</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="<?php echo e(route('notifications.index')); ?>" class="relative ops-button-secondary">
                            <span>Alerts</span>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->unreadNotifications()->count()): ?>
                                    <span class="absolute -right-2 -top-2 rounded-full bg-amber-400 px-2 py-0.5 text-xs font-bold text-slate-950"><?php echo e(auth()->user()->unreadNotifications()->count()); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>
                        <a href="<?php echo e(route('tracking.lookup')); ?>" class="hidden ops-button-secondary sm:inline-flex">Track</a>
                        <button class="ops-button-secondary" @click="theme = theme === 'dark' ? 'light' : 'dark'" x-text="theme === 'dark' ? 'Light' : 'Dark'"></button>
                        <?php if(auth()->guard()->check()): ?>
                            <span class="hidden text-sm text-slate-300 md:inline"><?php echo e(auth()->user()->name); ?> · <?php echo e(str(auth()->user()->role)->headline()); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6">
                <?php if(session('status')): ?>
                    <div class="mb-4 rounded border border-emerald-400/40 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100"><?php echo e(session('status')); ?></div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/layouts/app.blade.php ENDPATH**/ ?>