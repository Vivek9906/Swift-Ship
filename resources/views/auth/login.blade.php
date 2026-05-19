{{-- SwiftShip Login Page — Split Screen Layout --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ showPass: false, loading: false }">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SwiftShip | Login</title>
  <meta name="description" content="SwiftShip Admin & Staff Portal — Secure Login">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body { font-family: Inter, ui-sans-serif, system-ui, sans-serif; }
    .login-grid { display: grid; grid-template-columns: 1fr; min-height: 100vh; }
    @media (min-width: 768px) { .login-grid { grid-template-columns: 1fr 1fr; } }
    .float-label-wrap { position: relative; }
    .float-label-wrap input { padding-top: 1.4rem; padding-bottom: 0.6rem; }
    .float-label-wrap label {
      position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
      font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
      letter-spacing: 0.05em; color: #64748b; pointer-events: none;
      transition: all 0.2s; white-space: nowrap;
    }
    .float-label-wrap input:focus ~ label,
    .float-label-wrap input:not(:placeholder-shown) ~ label {
      top: 0.6rem; transform: none; font-size: 0.65rem; color: #f59e0b;
    }
    .india-map { opacity: 0.12; }
    @keyframes gridPulse {
      0%, 100% { opacity: 0.08; } 50% { opacity: 0.14; }
    }
    .grid-bg { animation: gridPulse 4s ease-in-out infinite; }
    .pill { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.35rem 0.75rem; border-radius: 99px; font-size: 0.72rem; font-weight: 600; }
    .custom-checkbox { appearance: none; width: 1rem; height: 1rem; border: 1.5px solid #475569; border-radius: 0.25rem; background: #0f172a; cursor: pointer; position: relative; flex-shrink: 0; transition: all 0.15s; }
    .custom-checkbox:checked { background: #f59e0b; border-color: #f59e0b; }
    .custom-checkbox:checked::after { content: ''; position: absolute; left: 4px; top: 1px; width: 5px; height: 8px; border: 2px solid #0f172a; border-top: none; border-left: none; transform: rotate(45deg); }
    .custom-checkbox:focus { outline: 2px solid #f59e0b40; outline-offset: 2px; }
  </style>
</head>
<body class="bg-slate-950 text-slate-100">
<div class="login-grid">

  {{-- LEFT: Form Panel --}}
  <div class="flex flex-col justify-center px-8 py-12 sm:px-12 lg:px-16 bg-slate-950 relative overflow-hidden">

    {{-- Subtle grid bg --}}
    <div class="grid-bg absolute inset-0 pointer-events-none" style="background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cpath d='M 60 0 L 0 0 0 60' fill='none' stroke='%231e3a5f' stroke-width='0.8'/%3E%3C/svg%3E\"); background-size: 60px 60px;"></div>

    <div class="relative z-10 max-w-sm w-full mx-auto">

      {{-- Logo + subtitle --}}
      <div class="mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-3">
          <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-400 font-mono font-black text-slate-950 text-sm shadow-lg shadow-amber-500/20">SS</span>
          <span class="text-xl font-extrabold tracking-tight text-white">Swift<span class="text-amber-400">Ship</span></span>
        </a>
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Admin & Staff Portal</p>
      </div>

      <h2 class="text-2xl font-black text-white mb-1">Welcome back</h2>
      <p class="text-sm text-slate-400 mb-8">Sign in to your SwiftShip portal account</p>

      {{-- Form --}}
      <form method="POST" action="{{ route('login') }}" class="space-y-4" @submit="loading = true">
        @csrf

        {{-- Email --}}
        <div class="float-label-wrap">
          <input
            id="email"
            name="email"
            type="email"
            placeholder=" "
            value="{{ old('email', 'admin@logistics.test') }}"
            required
            autofocus
            autocomplete="email"
            class="w-full rounded-xl border px-4 py-3 text-sm text-slate-100 outline-none transition-all bg-slate-900/80 {{ $errors->has('email') ? 'border-red-500/60 focus:ring-2 focus:ring-red-500/20' : 'border-slate-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20' }}"
          >
          <label for="email">Email Address</label>
        </div>

        {{-- Password --}}
        <div class="float-label-wrap relative">
          <input
            id="password"
            name="password"
            :type="showPass ? 'text' : 'password'"
            placeholder=" "
            value="password"
            required
            autocomplete="current-password"
            class="w-full rounded-xl border border-slate-700 bg-slate-900/80 px-4 py-3 pr-11 text-sm text-slate-100 outline-none transition-all focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20"
          >
          <label for="password">Password</label>
          <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-amber-400 transition" @click="showPass = !showPass" tabindex="-1">
            <svg x-show="!showPass" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            <svg x-show="showPass" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
          </button>
        </div>

        {{-- Remember + Forgot row --}}
        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2.5 text-sm text-slate-400 cursor-pointer select-none">
            <input type="checkbox" name="remember" class="custom-checkbox">
            Keep me signed in
          </label>
          <a href="#" class="text-xs text-amber-400 hover:text-amber-300 transition">Forgot password?</a>
        </div>

        {{-- Error --}}
        @if($errors->any())
          <div class="rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300 flex items-start gap-2">
            <svg class="flex-shrink-0 mt-0.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
          </div>
        @endif

        {{-- Submit --}}
        <button type="submit" :disabled="loading"
          class="w-full rounded-xl bg-amber-400 py-3.5 text-sm font-bold text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
          <svg x-show="!loading" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
          <svg x-show="loading" class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
          <span x-text="loading ? 'Signing in...' : 'Sign In to Portal'">Sign In to Portal</span>
        </button>
      </form>

      {{-- Demo credentials --}}
      <div x-data="{ open: false }" class="mt-4">
        <button @click="open = !open" class="text-xs text-slate-600 hover:text-slate-400 transition flex items-center gap-1.5 w-full justify-center">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          Use demo credentials
          <svg :class="open ? 'rotate-180' : ''" class="transition-transform" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div x-show="open" x-transition class="mt-2 rounded-lg border border-slate-800 bg-slate-900/60 px-4 py-3 text-xs text-slate-400 text-center">
          <p><span class="text-slate-500">Email:</span> <span class="font-mono text-amber-400">admin@logistics.test</span></p>
          <p class="mt-1"><span class="text-slate-500">Password:</span> <span class="font-mono text-amber-400">password</span></p>
        </div>
      </div>

      {{-- Security badge --}}
      <div class="mt-5 flex items-center justify-center gap-1.5 text-xs text-slate-600">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        256-bit SSL Encrypted
      </div>

      {{-- Feature pills --}}
      <div class="mt-4 flex flex-wrap gap-2 justify-center">
        <span class="pill bg-slate-900 border border-slate-800 text-slate-400">🔒 Secure</span>
        <span class="pill bg-slate-900 border border-slate-800 text-slate-400">⚡ Real-Time</span>
        <span class="pill bg-slate-900 border border-slate-800 text-slate-400">📦 Multi-Carrier</span>
      </div>

      {{-- Register link --}}
      <div class="mt-5 text-center border-t border-slate-800 pt-4">
        <p class="text-sm text-slate-500">
          New user?
          <a href="{{ route('register') }}" class="text-amber-400 hover:text-amber-300 font-semibold transition">Create a free account</a>
        </p>
      </div>

      {{-- Back to home --}}
      <div class="mt-3 text-center">
        <a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-slate-300 transition inline-flex items-center gap-1.5">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          Back to Homepage
        </a>
      </div>
    </div>
  </div>


  {{-- RIGHT: Branding Panel (hidden on mobile) --}}
  <div class="hidden md:flex flex-col items-center justify-center relative overflow-hidden" style="background: #0f172a;">

    {{-- Animated grid pattern --}}
    <div class="absolute inset-0 pointer-events-none" style="background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cpath d='M 80 0 L 0 0 0 80' fill='none' stroke='%23f59e0b' stroke-width='0.3'/%3E%3C/svg%3E\"); background-size: 80px 80px; opacity: 0.07;"></div>

    {{-- Glowing orbs --}}
    <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-amber-400/5 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-48 h-48 rounded-full bg-blue-500/5 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 px-10 text-center max-w-sm">
      {{-- Big logo --}}
      <div class="flex items-center justify-center gap-4 mb-6">
        <span class="grid h-14 w-14 place-items-center rounded-2xl bg-amber-400 font-mono font-black text-slate-950 text-xl shadow-2xl shadow-amber-500/30">SS</span>
        <span class="text-3xl font-black text-white">Swift<span class="text-amber-400">Ship</span></span>
      </div>
      <p class="text-sm text-slate-400 mb-10 leading-relaxed">India's #1 Logistics Intelligence Platform</p>

      {{-- Feature list --}}
      <div class="space-y-4 text-left mb-10">
        @foreach([
            ['Real-time GPS across 15+ carriers', 'text-amber-400'],
            ['Role-based secure access controls', 'text-blue-400'],
            ['Instant delay alerts & SMS notifications', 'text-emerald-400'],
          ] as $feat)
          <div class="flex items-center gap-3">
            <span class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0" style="background: rgba(245,158,11,0.15);">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="text-sm {{ $feat[1] }} font-medium">{{ $feat[0] }}</span>
          </div>
        @endforeach
      </div>

      {{-- Decorative India map SVG outline --}}
      <div class="mb-8 opacity-20">
        <svg viewBox="0 0 400 450" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-40 mx-auto" stroke="#f59e0b" stroke-width="2">
          <path d="M200 20 L260 50 L310 80 L340 130 L360 180 L350 220 L330 260 L300 290 L280 320 L260 350 L240 380 L220 410 L200 430 L180 410 L160 380 L140 350 L120 320 L100 290 L70 260 L50 220 L40 180 L60 130 L90 80 L140 50 Z"/>
        </svg>
      </div>

      {{-- Testimonial quote --}}
      <blockquote class="text-xs text-slate-500 italic border-l-2 border-amber-400/30 pl-3 text-left">
        "SwiftShip cut our complaint rate by 60%. The live map is a game-changer for our export operations."
        <footer class="mt-2 text-amber-400/60 not-italic font-semibold">— Priya V., NovaTex Exports</footer>
      </blockquote>
    </div>
  </div>

</div>
</body>
</html>
