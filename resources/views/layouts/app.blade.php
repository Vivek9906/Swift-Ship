<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebar: false, theme: localStorage.getItem('theme') || 'dark' }" x-init="$watch('theme', value => localStorage.setItem('theme', value))" :class="{ 'light': theme === 'light' }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <aside class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r border-slate-800 bg-slate-950 p-4 transition lg:static lg:translate-x-0" :class="{ 'translate-x-0': sidebar }">
            <div class="mb-8 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded bg-amber-400 font-mono font-black text-slate-950">LX</span>
                    <span>
                        <span class="block text-sm font-bold uppercase tracking-wider">Logistics</span>
                        <span class="block text-xs text-slate-400">Control Tower</span>
                    </span>
                </a>
                <button class="lg:hidden" @click="sidebar = false">✕</button>
            </div>
            <x-sidebar-nav />
        </aside>

        <div class="min-w-0">
            <header class="sticky top-0 z-30 border-b border-slate-800 bg-slate-950/90 backdrop-blur">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <button class="ops-button-secondary lg:hidden" @click="sidebar = true">☰</button>
                        <div>
                            <h1 class="text-lg font-bold">@yield('title', 'Dashboard')</h1>
                            <p class="hidden text-xs text-slate-400 sm:block">Ops synchronized at {{ now()->format('H:i') }} IST</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('notifications.index') }}" class="relative ops-button-secondary">
                            <span>Alerts</span>
                            @auth
                                @if(auth()->user()->unreadNotifications()->count())
                                    <span class="absolute -right-2 -top-2 rounded-full bg-amber-400 px-2 py-0.5 text-xs font-bold text-slate-950">{{ auth()->user()->unreadNotifications()->count() }}</span>
                                @endif
                            @endauth
                        </a>
                        <a href="{{ route('tracking.lookup') }}" class="hidden ops-button-secondary sm:inline-flex">Track</a>
                        <button class="ops-button-secondary" @click="theme = theme === 'dark' ? 'light' : 'dark'" x-text="theme === 'dark' ? 'Light' : 'Dark'"></button>
                        @auth
                            <span class="hidden text-sm text-slate-300 md:inline">{{ auth()->user()->name }} · {{ str(auth()->user()->role)->headline() }}</span>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6">
                @if(session('status'))
                    <div class="mb-4 rounded border border-emerald-400/40 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">{{ session('status') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
