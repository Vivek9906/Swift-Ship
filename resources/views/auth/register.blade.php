{{-- SwiftShip user Registration --}}
<!doctype html>
<html lang="en" x-data="{ showPass: false, showConfirm: false }">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SwiftShip | Register</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body {
      font-family: Inter, ui-sans-serif, system-ui, sans-serif;
    }

    .reg-grid {
      display: grid;
      grid-template-columns: 1fr;
      min-height: 100vh;
    }

    @media (min-width: 900px) {
      .reg-grid {
        grid-template-columns: 1.1fr 0.9fr;
      }
    }

    .field-error {
      font-size: 0.75rem;
      color: #f87171;
      margin-top: 4px;
      display: block;
    }

    input.err {
      border-color: rgba(248, 113, 113, 0.7) !important;
    }

    .req-indicator {
      font-size: 10px;
      color: #64748b;
      margin-bottom: 4px;
      display: block;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: .05em;
    }
  </style>
</head>

<body class="bg-slate-950 text-slate-100">
  <div class="reg-grid">

    {{-- LEFT: Form --}}
    <div class="flex flex-col justify-center px-8 py-10 sm:px-12 lg:px-16 bg-slate-950 relative overflow-hidden">
      <div class="absolute inset-0 pointer-events-none opacity-[0.06]" style="background-image:url(\"
        data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' %3E%3Cpath
        d='M 60 0 L 0 0 0 60' fill='none' stroke='%231e3a5f' stroke-width='0.8' /%3E%3C/svg%3E\");background-size:60px
        60px;"></div>

      <div class="relative z-10 max-w-md w-full mx-auto">
        {{-- Logo --}}
        <div class="mb-7">
          <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-3">
            <span
              class="grid h-9 w-9 place-items-center rounded-lg bg-amber-400 font-mono font-black text-slate-950 text-sm shadow-lg shadow-amber-500/20">SS</span>
            <span class="text-xl font-extrabold tracking-tight text-white">Swift<span
                class="text-amber-400">Ship</span></span>
          </a>
          <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">user Portal</p>
        </div>

        <h2 class="text-2xl font-black text-white mb-1">Create your account</h2>
        <p class="text-sm text-slate-400 mb-6">Start booking and tracking shipments across India</p>

        {{-- Success message from redirect --}}
        @if(session('success'))
          <div class="mb-4 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
            {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4" id="reg-form" novalidate>
          @csrf

          {{-- Full Name --}}
          <div>
            <span class="req-indicator">Full Name *</span>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Rahul Sharma"
              class="w-full rounded-xl border {{ $errors->has('name') ? 'border-red-500/60 err' : 'border-slate-700' }} bg-slate-900/80 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          {{-- Email --}}
          <div>
            <span class="req-indicator">Email Address *</span>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
              placeholder="rahul@example.com"
              class="w-full rounded-xl border {{ $errors->has('email') ? 'border-red-500/60 err' : 'border-slate-700' }} bg-slate-900/80 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          {{-- Phone --}}
          <div>
            <span class="req-indicator">Phone Number * (Indian, 10 digits)</span>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="9876543210"
              class="w-full rounded-xl border {{ $errors->has('phone') ? 'border-red-500/60 err' : 'border-slate-700' }} bg-slate-900/80 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
            @error('phone') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          {{-- Password --}}
          <div class="relative">
            <span class="req-indicator">Password * (min 8 chars, 1 uppercase, 1 number)</span>
            <input :type="showPass ? 'text' : 'password'" name="password" id="password" required placeholder="••••••••"
              class="w-full rounded-xl border {{ $errors->has('password') ? 'border-red-500/60 err' : 'border-slate-700' }} bg-slate-900/80 px-4 py-3 pr-11 text-sm text-slate-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
            <button type="button" @click="showPass=!showPass" tabindex="-1"
              class="absolute right-3 bottom-3 text-slate-500 hover:text-amber-400 transition">
              <svg x-show="!showPass" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
              <svg x-show="showPass" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path
                  d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                <line x1="1" y1="1" x2="23" y2="23" />
              </svg>
            </button>
            @error('password') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          {{-- Confirm Password --}}
          <div class="relative">
            <span class="req-indicator">Confirm Password *</span>
            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" id="password_confirmation"
              required placeholder="••••••••"
              class="w-full rounded-xl border border-slate-700 bg-slate-900/80 px-4 py-3 pr-11 text-sm text-slate-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
            <button type="button" @click="showConfirm=!showConfirm" tabindex="-1"
              class="absolute right-3 bottom-3 text-slate-500 hover:text-amber-400 transition">
              <svg x-show="!showConfirm" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
              <svg x-show="showConfirm" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                <line x1="1" y1="1" x2="23" y2="23" />
              </svg>
            </button>
          </div>

          {{-- Terms --}}
          <label class="flex items-start gap-3 text-sm text-slate-400 cursor-pointer">
            <input type="checkbox" name="terms"
              class="mt-0.5 rounded border-slate-600 bg-slate-950 text-amber-400 focus:ring-amber-400/20 w-4 h-4 flex-shrink-0"
              {{ old('terms') ? 'checked' : '' }}>
            <span>I agree to SwiftShip's <a href="#" class="text-amber-400 hover:underline">Terms of Service</a> and <a
                href="#" class="text-amber-400 hover:underline">Privacy Policy</a></span>
          </label>
          @error('terms') <span class="field-error">{{ $message }}</span> @enderror

          {{-- Global error --}}
          @if($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('phone') && !$errors->has('password') && !$errors->has('terms'))
            <div class="rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300">
              {{ $errors->first() }}</div>
          @endif

          <button type="submit"
            class="w-full rounded-xl bg-amber-400 py-3.5 text-sm font-bold text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20">
            Create Account →
          </button>
        </form>

        <p class="mt-5 text-center text-sm text-slate-500">
          Already have an account?
          <a href="{{ route('login') }}" class="text-amber-400 hover:text-amber-300 font-semibold transition">Sign
            In</a>
        </p>
        <div class="mt-4 text-center">
          <a href="{{ route('home') }}"
            class="text-sm text-slate-600 hover:text-slate-400 transition inline-flex items-center gap-1">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
              stroke-linecap="round" stroke-linejoin="round">
              <line x1="19" y1="12" x2="5" y2="12" />
              <polyline points="12 19 5 12 12 5" />
            </svg>
            Back to Homepage
          </a>
        </div>
      </div>
    </div>

    {{-- RIGHT: Branding --}}
    <div class="hidden md:flex flex-col items-center justify-center relative overflow-hidden"
      style="background:#0c1a3a;">
      <div class="absolute inset-0 pointer-events-none opacity-[0.06]" style="background-image:url(\"
        data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' %3E%3Cpath
        d='M 80 0 L 0 0 0 80' fill='none' stroke='%23f59e0b' stroke-width='0.3' /%3E%3C/svg%3E\");background-size:80px
        80px;"></div>
      <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-amber-400/5 blur-3xl pointer-events-none"></div>
      <div class="relative z-10 px-10 text-center max-w-sm">
        <div class="flex items-center justify-center gap-4 mb-6">
          <span
            class="grid h-14 w-14 place-items-center rounded-2xl bg-amber-400 font-mono font-black text-slate-950 text-xl shadow-2xl shadow-amber-500/30">SS</span>
          <span class="text-3xl font-black text-white">Swift<span class="text-amber-400">Ship</span></span>
        </div>
        <p class="text-sm text-slate-400 mb-8">Join 320+ businesses shipping smarter across India</p>
        <div class="space-y-4 text-left">
          @foreach(['Book shipments in 5 minutes', 'Track in real-time across 15+ carriers', 'Automated email & SMS alerts', 'Competitive fare calculator'] as $f)
            <div class="flex items-center gap-3">
              <span class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-400/20">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="3"
                  stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="20 6 9 17 4 12" />
                </svg>
              </span>
              <span class="text-sm text-slate-300 font-medium">{{ $f }}</span>
            </div>
          @endforeach
        </div>
        <div class="mt-10 rounded-2xl border border-slate-700/60 bg-slate-900/40 p-5 text-left">
          <p class="text-xs italic text-slate-400">"SwiftShip cut our complaint rate by 60%. The live map is a
            game-changer for our export operations."</p>
          <p class="mt-2 text-xs text-amber-400 font-semibold">— Priya V., NovaTex Exports</p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>