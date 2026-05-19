<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="{
          scrolled: false,
          mobileMenu: false,
          showTop: false
      }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40; showTop = window.scrollY > 500; })"
    class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>SwiftShip | <?php echo $__env->yieldContent('page_title', 'Real-Time Logistics'); ?></title>
    <meta name="description"
        content="<?php echo $__env->yieldContent('meta_description', 'Track shipments in real-time across India. SwiftShip delivers logistics precision with 50,000+ parcels shipped and 99.8% on-time rate.'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <?php echo $__env->yieldPushContent('head_scripts'); ?>
    <style>
        /* Public layout overrides */
        .pub-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .pub-nav.scrolled {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(51, 65, 85, 0.6);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
        }

        .pub-nav-link {
            color: #94a3b8;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
            padding: 0.25rem 0.125rem;
        }

        .pub-nav-link:hover {
            color: #f8fafc;
        }

        .pub-nav-link.active {
            color: #f8fafc;
        }

        .btn-outline-amber {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.45rem 1rem;
            border-radius: 0.375rem;
            border: 1.5px solid #f59e0b;
            color: #fbbf24;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-outline-amber:hover {
            background: #f59e0b;
            color: #0f172a;
        }

        .pub-footer {
            background: #020617;
            border-top: 1px solid #1e293b;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-950 text-slate-100"
    style="font-family: Inter, ui-sans-serif, system-ui, sans-serif;">

    
    <nav class="pub-nav" :class="{ 'scrolled': scrolled }">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3 flex-shrink-0">
                <span
                    class="grid h-9 w-9 place-items-center rounded-lg bg-amber-400 font-mono font-black text-slate-950 text-sm shadow-lg shadow-amber-500/20">SS</span>
                <span class="text-lg font-extrabold tracking-tight text-white">Swift<span
                        class="text-amber-400">Ship</span></span>
            </a>

            
            <div class="hidden md:flex items-center gap-7">
                <a href="<?php echo e(route('home')); ?>"
                    class="pub-nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Home</a>
                <a href="<?php echo e(route('tracking.lookup')); ?>"
                    class="pub-nav-link <?php echo e(request()->routeIs('tracking.*') ? 'active' : ''); ?>">Track Shipment</a>
                <a href="<?php echo e(route('home')); ?>#about" class="pub-nav-link">About</a>
                <a href="<?php echo e(route('home')); ?>#contact" class="pub-nav-link">Contact</a>
            </div>

            
            <div class="flex items-center gap-3">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-outline-amber">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('customer.dashboard')); ?>" class="btn-outline-amber">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            Dashboard
                        </a>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="text-sm font-semibold text-slate-300 hover:text-white transition ml-3">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>"
                        class="text-sm font-semibold text-slate-300 hover:text-white transition mr-2 hidden sm:block">Login</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn-outline-amber">Register</a>
                <?php endif; ?>

                <button class="md:hidden text-slate-400 hover:text-white transition p-1"
                    @click="mobileMenu = !mobileMenu" aria-label="Toggle menu">
                    <svg x-show="!mobileMenu" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <line x1="3" y1="12" x2="21" y2="12" />
                        <line x1="3" y1="18" x2="21" y2="18" />
                    </svg>
                    <svg x-show="mobileMenu" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
        </div>

        
        <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden border-t border-slate-800 bg-slate-950/98 backdrop-blur px-4 py-4 space-y-3"
            @click.away="mobileMenu = false">
            <a href="<?php echo e(route('home')); ?>"
                class="block py-2 text-sm font-medium text-slate-300 hover:text-white transition"
                @click="mobileMenu = false">Home</a>
            <a href="<?php echo e(route('tracking.lookup')); ?>"
                class="block py-2 text-sm font-medium text-slate-300 hover:text-white transition"
                @click="mobileMenu = false">Track Shipment</a>
            <a href="<?php echo e(route('home')); ?>#about"
                class="block py-2 text-sm font-medium text-slate-300 hover:text-white transition"
                @click="mobileMenu = false">About</a>
            <a href="<?php echo e(route('home')); ?>#contact"
                class="block py-2 text-sm font-medium text-slate-300 hover:text-white transition"
                @click="mobileMenu = false">Contact</a>
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff'): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                        class="block py-2 text-sm font-semibold text-amber-400 hover:text-amber-300 transition"
                        @click="mobileMenu = false">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('customer.dashboard')); ?>"
                        class="block py-2 text-sm font-semibold text-amber-400 hover:text-amber-300 transition"
                        @click="mobileMenu = false">Dashboard</a>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="block w-full text-left py-2 text-sm font-medium text-slate-300 hover:text-white transition">Logout</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                    class="block py-2 text-sm font-medium text-slate-300 hover:text-white transition"
                    @click="mobileMenu = false">Login</a>
                <a href="<?php echo e(route('register')); ?>"
                    class="block py-2 text-sm font-medium text-slate-300 hover:text-white transition"
                    @click="mobileMenu = false">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <footer class="pub-footer" id="contact">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
                
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span
                            class="grid h-9 w-9 place-items-center rounded-lg bg-amber-400 font-mono font-black text-slate-950 text-sm">SS</span>
                        <span class="text-lg font-extrabold text-white">Swift<span
                                class="text-amber-400">Ship</span></span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-xs">India's most reliable logistics
                        intelligence platform. Real-time tracking, multi-carrier support, and end-to-end visibility.</p>
                    <div class="mt-5 flex gap-3">
                        <a href="#"
                            class="w-8 h-8 rounded-full border border-slate-700 flex items-center justify-center text-slate-400 hover:text-white hover:border-slate-500 transition"
                            aria-label="Twitter">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.261 5.638L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-8 h-8 rounded-full border border-slate-700 flex items-center justify-center text-slate-400 hover:text-white hover:border-slate-500 transition"
                            aria-label="LinkedIn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-8 h-8 rounded-full border border-slate-700 flex items-center justify-center text-slate-400 hover:text-white hover:border-slate-500 transition"
                            aria-label="GitHub">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>

                
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-300 mb-4">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="<?php echo e(route('home')); ?>"
                                class="text-sm text-slate-400 hover:text-white transition">Home</a></li>
                        <li><a href="<?php echo e(route('tracking.lookup')); ?>"
                                class="text-sm text-slate-400 hover:text-white transition">Track Shipment</a></li>
                        <li><a href="<?php echo e(route('home')); ?>#how-it-works"
                                class="text-sm text-slate-400 hover:text-white transition">How It Works</a></li>
                        <li><a href="<?php echo e(route('home')); ?>#features"
                                class="text-sm text-slate-400 hover:text-white transition">Features</a></li>
                        <li><a href="<?php echo e(route('login')); ?>"
                                class="text-sm text-slate-400 hover:text-white transition">Admin Portal</a></li>
                    </ul>
                </div>

                
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-300 mb-4">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-slate-400">
                            <svg class="mt-0.5 flex-shrink-0 text-amber-400" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            ops@swiftship.in
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-400">
                            <svg class="mt-0.5 flex-shrink-0 text-amber-400" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.64 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.55 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            1800-SHIP-NOW (Toll Free)
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-400">
                            <svg class="mt-0.5 flex-shrink-0 text-amber-400" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            Mumbai HQ Â· Pan-India Network
                        </li>
                    </ul>
                </div>

                
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-300 mb-4">Partner Carriers</h3>
                    <ul class="space-y-3">
                        <li class="text-sm text-slate-400 flex items-center gap-2"><span
                                class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400"></span>BlueDart</li>
                        <li class="text-sm text-slate-400 flex items-center gap-2"><span
                                class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400"></span>DTDC Express</li>
                        <li class="text-sm text-slate-400 flex items-center gap-2"><span
                                class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400"></span>Delhivery</li>
                        <li class="text-sm text-slate-400 flex items-center gap-2"><span
                                class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400"></span>Ecom Express</li>
                        <li class="text-sm text-slate-400 flex items-center gap-2"><span
                                class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400"></span>India Post</li>
                    </ul>
                </div>
            </div>

            <div
                class="mt-10 pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500">Â© <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'SwiftShip')); ?>. All rights
                    reserved. Built with precision.</p>
                <div class="flex gap-5 text-xs text-slate-500">
                    <a href="#" class="hover:text-slate-300 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-300 transition">Terms of Service</a>
                    <a href="#" class="hover:text-slate-300 transition">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    
    <button x-show="showTop" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 translate-y-2" onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="fixed bottom-6 right-6 z-50 w-11 h-11 rounded-full bg-amber-400 text-slate-950 flex items-center justify-center shadow-lg shadow-amber-500/30 hover:bg-amber-300 transition-all duration-200"
        aria-label="Back to top">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15" />
        </svg>
    </button>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/layouts/public.blade.php ENDPATH**/ ?>