<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ sidebar: false, theme: localStorage.getItem('theme') || 'dark' }"
    x-init="$watch('theme', value => localStorage.setItem('theme', value))" :class="{ 'light': theme === 'light' }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SwiftShip | @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        {{-- Sidebar overlay on mobile --}}
        <div x-show="sidebar" class="fixed inset-0 z-30 bg-black/60 lg:hidden" @click="sidebar = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r border-slate-800 bg-slate-950 flex flex-col transition-transform duration-300 lg:static lg:translate-x-0"
            :class="{ 'translate-x-0': sidebar }">
            {{-- Logo --}}
            <div class="px-4 py-5 border-b border-slate-800 flex items-center justify-between">
                @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'staff'))
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                @else
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3">
                    @endif
                        <span
                            class="grid h-9 w-9 place-items-center rounded-lg bg-amber-400 font-mono font-black text-slate-950 text-sm shadow-lg shadow-amber-500/20">SS</span>
                        <span class="text-base font-extrabold tracking-tight text-white">Swift<span
                                class="text-amber-400">Ship</span></span>
                    </a>
                    <button class="lg:hidden text-slate-400 hover:text-white transition p-1" @click="sidebar = false">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
            </div>

            {{-- Nav --}}
            <div class="flex-1 overflow-y-auto p-4">
                <x-sidebar-nav />
            </div>

            {{-- User info at bottom --}}
            @auth
                <div class="p-4 border-t border-slate-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-blue-500 flex items-center justify-center text-xs font-bold text-slate-950 flex-shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-amber-400 font-medium">{{ str(auth()->user()->role)->headline() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="mt-3 w-full flex items-center gap-2 text-xs text-slate-500 hover:text-red-400 transition py-1">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
            @endauth
        </aside>

        <div class="min-w-0">
            <header class="sticky top-0 z-30 border-b border-slate-800 bg-slate-950/90 backdrop-blur">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <button class="ops-button-secondary lg:hidden" @click="sidebar = true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="3" y1="6" x2="21" y2="6" />
                                <line x1="3" y1="12" x2="21" y2="12" />
                                <line x1="3" y1="18" x2="21" y2="18" />
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-lg font-bold text-white">@yield('title', 'Dashboard')</h1>
                            <p class="hidden text-xs text-slate-400 sm:block">SwiftShip · Synced at
                                {{ now()->format('H:i') }} IST</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @auth
                            @if(auth()->user()->isAdminOrStaff())
                            <a href="{{ route('notifications.index') }}" class="relative ops-button-secondary">
                            <span>Alerts</span>
                            @if(auth()->user()->unreadNotifications()->count())
                                <span
                                    class="absolute -right-2 -top-2 rounded-full bg-amber-400 px-2 py-0.5 text-xs font-bold text-slate-950">{{ auth()->user()->unreadNotifications()->count() }}</span>
                            @endif
                        </a>
                            @endif
                        @endauth
                        <a href="{{ route('tracking.lookup') }}"
                            class="hidden ops-button-secondary sm:inline-flex">Track</a>
                        <button class="ops-button-secondary" @click="theme = theme === 'dark' ? 'light' : 'dark'"
                            x-text="theme === 'dark' ? '☀️ Light' : '🌙 Dark'"></button>
                        @auth
                            <span class="hidden text-sm text-slate-300 md:inline">{{ auth()->user()->name }}</span>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6">
                @if(session('status'))
                    <div
                        class="mb-4 rounded border border-emerald-400/40 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
                        {{ session('status') }}</div>
                @endif
                @if(session('success'))
                    <div
                        class="mb-4 rounded border border-emerald-400/40 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
                        {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div
                        class="mb-4 rounded border border-red-400/40 bg-red-400/10 px-4 py-3 text-sm text-red-100">
                        {{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
