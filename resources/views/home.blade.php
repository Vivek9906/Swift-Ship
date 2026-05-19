@extends('layouts.public')

@section('page_title', 'Home')
@section('meta_description', 'Track shipments in real-time across India. SwiftShip — 50K+ shipments delivered, 99.8% on-time, 15+ carrier partners.')

@section('content')

  {{-- ===== HERO ===== --}}
  <section class="relative min-h-screen flex items-center justify-center overflow-hidden"
    style="background: linear-gradient(135deg, #0f172a 0%, #0c1a3a 50%, #0f172a 100%); padding-top: 5rem;">

    {{-- Canvas particle network background --}}
    <canvas id="heroCanvas" class="absolute inset-0 w-full h-full pointer-events-none"></canvas>

    <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 text-center">
      <div
        class="inline-flex items-center gap-2 rounded-full border border-amber-400/30 bg-amber-400/10 px-4 py-1.5 text-xs font-semibold text-amber-300 mb-8 tracking-wider uppercase">
        <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        Live Network — Tracking Active Across India
      </div>

      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight text-white">
        Real-Time Logistics,<br>
        <span
          style="background: linear-gradient(90deg, #f59e0b, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Delivered
          With Precision</span>
      </h1>

      <p class="mt-6 text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
        Track your shipments instantly across India's largest carrier network. Get real-time GPS updates, delay alerts,
        and door-step delivery notifications — all in one dashboard.
      </p>

      {{-- Big tracking input --}}
      <form method="GET" action="{{ route('tracking.lookup') }}"
        class="mt-10 flex flex-col sm:flex-row gap-3 max-w-2xl mx-auto" id="hero-track-form"
        onsubmit="return validateTrackForm()">
        <input id="hero-tracking-input" name="tracking_number" type="text"
          placeholder="Enter your Tracking Number (e.g. IND250512ABCDEF)"
          class="flex-1 rounded-xl border border-slate-700 bg-slate-900/80 backdrop-blur px-5 py-4 text-sm text-slate-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 font-mono placeholder-slate-500"
          autocomplete="off">
        <button type="submit"
          class="rounded-xl bg-amber-400 px-8 py-4 text-sm font-bold text-slate-950 transition hover:bg-amber-300 active:scale-95 whitespace-nowrap shadow-lg shadow-amber-500/25 flex items-center gap-2">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />
          </svg>
          Track Now
        </button>
      </form>
      {{-- Error toast placeholder --}}
      <div id="track-error"
        class="hidden mt-3 mx-auto max-w-2xl rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-2.5 text-sm text-red-300 text-center">
        Please enter a tracking number before searching.</div>

      {{-- Stats bar --}}
      <div class="mt-8 flex flex-wrap items-center justify-center gap-6">
        <div class="flex items-center gap-2 text-sm text-slate-400">
          <span class="text-amber-400 font-bold text-lg counter" data-target="50000" data-suffix="+">0</span> Shipments
        </div>
        <span class="text-slate-700">|</span>
        <div class="flex items-center gap-2 text-sm text-slate-400">
          <span class="text-emerald-400 font-bold text-lg">99.8%</span> On-Time
        </div>
        <span class="text-slate-700">|</span>
        <div class="flex items-center gap-2 text-sm text-slate-400">
          <span class="text-blue-400 font-bold text-lg counter" data-target="15" data-suffix="+">0</span> Carriers
        </div>
      </div>
    </div>
  </section>

  {{-- ===== HOW IT WORKS ===== --}}
  <section class="py-24 bg-slate-950" id="how-it-works">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="text-center mb-16">
        <p class="text-xs font-semibold uppercase tracking-widest text-amber-400 mb-3">Simple Process</p>
        <h2 class="text-3xl sm:text-4xl font-black text-white">How It Works</h2>
        <p class="mt-4 text-slate-400 max-w-xl mx-auto">Three steps from order to doorstep — with full visibility at every
          stage.</p>
      </div>

      <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10">
        {{-- Dashed connector line --}}
        <div class="hidden md:block absolute top-12 left-1/6 right-1/6 h-px"
          style="background: repeating-linear-gradient(90deg, #334155 0, #334155 8px, transparent 8px, transparent 18px); left: 18%; right: 18%; top: 3rem;">
        </div>

        @php
          $steps = [
            ['icon' => '<path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>', 'step' => '01', 'title' => 'Place Your Order', 'desc' => 'Submit your shipment details via our portal or API. Our system auto-assigns the best carrier for your route and weight.'],
            ['icon' => '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>', 'step' => '02', 'title' => 'We Pick & Ship', 'desc' => 'Your carrier collects the package, logs it into our network, and begins the transit journey with real-time scan updates.'],
            ['icon' => '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>', 'step' => '03', 'title' => 'Track in Real Time', 'desc' => 'Watch your shipment move on a live map. Receive SMS/email alerts at every milestone until delivery is confirmed.'],
          ];
        @endphp

        @foreach($steps as $s)
          <div class="relative flex flex-col items-center text-center group">
            <div
              class="relative z-10 w-24 h-24 rounded-2xl border border-slate-700 bg-slate-900 flex flex-col items-center justify-center mb-6 group-hover:border-amber-400/60 transition-all duration-300 group-hover:shadow-lg group-hover:shadow-amber-500/10">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.8"
                stroke-linecap="round" stroke-linejoin="round">{!! $s['icon'] !!}</svg>
              <span
                class="absolute -top-3 -right-3 w-7 h-7 rounded-full bg-amber-400 text-slate-950 text-xs font-black flex items-center justify-center">{{ $s['step'] }}</span>
            </div>
            <h3 class="text-lg font-bold text-white mb-3">{{ $s['title'] }}</h3>
            <p class="text-sm text-slate-400 leading-relaxed max-w-xs">{{ $s['desc'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== FEATURES ===== --}}
  <section class="py-24 bg-slate-900/50" id="features">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="text-center mb-16">
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-400 mb-3">Platform Capabilities</p>
        <h2 class="text-3xl sm:text-4xl font-black text-white">Everything You Need</h2>
        <p class="mt-4 text-slate-400 max-w-xl mx-auto">Built for logistics teams that demand accuracy, speed, and full
          control.</p>
      </div>

      @php
        $features = [
          ['icon' => '<circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>', 'color' => 'amber', 'title' => 'Real-Time GPS Tracking', 'desc' => 'Live coordinates updated every 60s on an interactive Leaflet map. Know exactly where every parcel is.'],
          ['icon' => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>', 'color' => 'blue', 'title' => 'Instant Delay Alerts', 'desc' => 'Push and email notifications trigger the moment a shipment deviates from its scheduled ETA.'],
          ['icon' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>', 'color' => 'emerald', 'title' => 'Multi-Carrier Support', 'desc' => 'Unified dashboard for BlueDart, DTDC, Delhivery, Ecom Express, India Post and more — one portal, all carriers.'],
          ['icon' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.64 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.55 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>', 'color' => 'purple', 'title' => 'user Notifications', 'desc' => 'Auto-send SMS and email updates to recipients at pickup, transit, out-for-delivery, and delivered milestones.'],
          ['icon' => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>', 'color' => 'cyan', 'title' => 'Detailed Analytics', 'desc' => 'Charts for on-time rates, carrier performance, shipment volumes, and delay trends — exportable as CSV.'],
          ['icon' => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>', 'color' => 'orange', 'title' => 'Secure Role-Based Access', 'desc' => 'Admin, Manager, and Viewer roles with granular permissions. All actions logged with full audit trail.'],
        ];
        $colorMap = [
          'amber' => ['border' => '#92400e', 'bg' => 'rgba(245,158,11,0.08)', 'stroke' => '#f59e0b'],
          'blue' => ['border' => '#1e3a5f', 'bg' => 'rgba(59,130,246,0.08)', 'stroke' => '#3b82f6'],
          'emerald' => ['border' => '#064e3b', 'bg' => 'rgba(16,185,129,0.08)', 'stroke' => '#10b981'],
          'purple' => ['border' => '#3b1f6b', 'bg' => 'rgba(139,92,246,0.08)', 'stroke' => '#8b5cf6'],
          'cyan' => ['border' => '#164e63', 'bg' => 'rgba(6,182,212,0.08)', 'stroke' => '#06b6d4'],
          'orange' => ['border' => '#7c2d12', 'bg' => 'rgba(249,115,22,0.08)', 'stroke' => '#f97316'],
        ];
      @endphp

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($features as $f)
          @php $c = $colorMap[$f['color']]; @endphp
          <div
            class="group rounded-2xl border p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl cursor-default"
            style="border-color: {{ $c['border'] }}; background: {{ $c['bg'] }};">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5"
              style="background: rgba(255,255,255,0.04); border: 1px solid {{ $c['border'] }};">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ $c['stroke'] }}" stroke-width="1.8"
                stroke-linecap="round" stroke-linejoin="round">{!! $f['icon'] !!}</svg>
            </div>
            <h3 class="text-base font-bold text-white mb-2">{{ $f['title'] }}</h3>
            <p class="text-sm text-slate-400 leading-relaxed">{{ $f['desc'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== STATS BANNER ===== --}}
  <section class="py-20 bg-slate-950 border-y border-slate-800" id="stats">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-10 text-center">
        <div>
          <div class="text-4xl sm:text-5xl font-black text-amber-400 counter" data-target="12400" data-suffix="+">0</div>
          <p class="mt-2 text-sm text-slate-400 font-medium">Shipments Delivered</p>
        </div>
        <div>
          <div class="text-4xl sm:text-5xl font-black text-blue-400 counter" data-target="8" data-suffix="">0</div>
          <p class="mt-2 text-sm text-slate-400 font-medium">Carrier Partners</p>
        </div>
        <div>
          <div class="text-4xl sm:text-5xl font-black text-emerald-400 counter" data-target="320" data-suffix="+">0</div>
          <p class="mt-2 text-sm text-slate-400 font-medium">Business Clients</p>
        </div>
        <div>
          <div class="text-4xl sm:text-5xl font-black text-cyan-400">98.7%</div>
          <p class="mt-2 text-sm text-slate-400 font-medium">On-Time Rate</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== CARRIERS STRIP ===== --}}
  <section class="py-14 bg-slate-900/60 overflow-hidden border-b border-slate-800">
    <div class="mx-auto max-w-6xl px-4 mb-8 text-center">
      <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Our Carrier Network</p>
    </div>
    <div class="relative overflow-hidden"
      style="-webkit-mask-image: linear-gradient(90deg, transparent 0%, black 10%, black 90%, transparent 100%); mask-image: linear-gradient(90deg, transparent 0%, black 10%, black 90%, transparent 100%);">
      <div class="flex gap-10 items-center" style="animation: marqueeScroll 20s linear infinite; width: max-content;">
        @php
          $carriers = ['BlueDart', 'DTDC', 'Delhivery', 'Ecom Express', 'India Post', 'FedEx India', 'Xpressbees', 'Shadowfax', 'Shiprocket', 'Borzo'];
          $emojis = ['✈️', '🚛', '🏎️', '📦', '📮', '🌐', '⚡', '🌑', '🚀', '🛵'];
        @endphp
        @foreach(array_merge($carriers, $carriers) as $i => $carrier)
          <div
            class="flex items-center gap-2 px-6 py-3 rounded-full border border-slate-700 bg-slate-900/80 whitespace-nowrap text-sm font-semibold text-slate-300 hover:border-amber-400/40 hover:text-white transition-colors cursor-default">
            <span>{{ $emojis[$i % count($emojis)] }}</span>
            {{ $carrier }}
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="py-24 bg-slate-950" id="about">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="text-center mb-16">
        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-400 mb-3">Client Stories</p>
        <h2 class="text-3xl sm:text-4xl font-black text-white">Trusted by Businesses Across India</h2>
      </div>

      @php
        $testimonials = [
          ['name' => 'Priya Venkataraman', 'company' => 'NovaTex Exports', 'city' => 'Chennai', 'stars' => 5, 'quote' => 'SwiftShip cut our user complaint rate by 60%. The live map and delay alerts are a game-changer for our export operations. We\'ve never had this kind of visibility before.'],
          ['name' => 'Rohan Malhotra', 'company' => 'UrbanKart Retail', 'city' => 'Delhi', 'stars' => 5, 'quote' => 'Managing 5 carriers from one portal was something we\'d only dreamed of. The role-based access means our ops team, managers, and finance all have exactly what they need.'],
          ['name' => 'Anitha Krishnaswamy', 'company' => 'MedLine Pharma', 'city' => 'Bangalore', 'stars' => 5, 'quote' => 'For temperature-sensitive shipments, the real-time tracking and instant alerts have been critical. SwiftShip is now our backbone for pan-India pharmaceutical logistics.'],
        ];
      @endphp

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($testimonials as $t)
          <div
            class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 flex flex-col gap-4 hover:border-slate-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-black/30">
            <div class="flex gap-1">
              @for($i = 0; $i < $t['stars']; $i++)
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#f59e0b" stroke="none">
                  <polygon
                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                </svg>
              @endfor
            </div>
            <p class="text-sm text-slate-300 leading-relaxed flex-1">"{{ $t['quote'] }}"</p>
            <div class="flex items-center gap-3 pt-2 border-t border-slate-800">
              <div
                class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-blue-500 flex items-center justify-center font-bold text-slate-950 text-sm flex-shrink-0">
                {{ substr($t['name'], 0, 1) }}
              </div>
              <div>
                <p class="text-sm font-semibold text-white">{{ $t['name'] }}</p>
                <p class="text-xs text-slate-500">{{ $t['company'] }} · {{ $t['city'] }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== CTA ===== --}}
  <section class="py-20"
    style="background: linear-gradient(135deg, #0c1a3a 0%, #0f172a 100%); border-top: 1px solid #1e293b;">
    <div class="mx-auto max-w-3xl px-4 text-center">
      <h2 class="text-3xl sm:text-4xl font-black text-white mb-4">Ready to streamline your logistics?</h2>
      <p class="text-slate-400 mb-10 text-lg">Join 500+ businesses using SwiftShip to deliver faster, smarter, and with
        total visibility.</p>
      <div class="flex flex-wrap items-center justify-center gap-4">
        <button onclick="openContactModal()"
          class="rounded-xl border border-slate-600 px-8 py-4 text-sm font-bold text-slate-100 hover:border-amber-400/50 hover:bg-slate-800 transition-all">
          Contact Sales
        </button>
        <a href="{{ route('register') }}"
          class="rounded-xl bg-amber-400 px-8 py-4 text-sm font-bold text-slate-950 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/25 flex items-center gap-2">
          Get Started Free →
        </a>
      </div>
    </div>
  </section>

  {{-- CONTACT SALES MODAL --}}
  <div id="contact-modal" class="fixed inset-0 z-[200] hidden items-end sm:items-center justify-center p-4"
    aria-modal="true" role="dialog">
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="closeContactModal()"></div>
    <div id="contact-panel"
      class="relative z-10 w-full max-w-lg rounded-2xl border border-slate-700 bg-slate-900 shadow-2xl max-h-[90vh] overflow-y-auto transform translate-y-8 opacity-0"
      style="transition: transform .3s cubic-bezier(.22,1,.36,1), opacity .25s;">
      <div class="flex items-center justify-between p-6 border-b border-slate-800">
        <div>
          <h2 class="text-base font-bold text-white">Get in Touch with SwiftShip Sales</h2>
          <p class="text-xs text-slate-400 mt-0.5">We'll get back within 24 hours</p>
        </div>
        <button onclick="closeContactModal()"
          class="text-slate-500 hover:text-white w-8 h-8 rounded-full hover:bg-slate-800 flex items-center justify-center transition">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg>
        </button>
      </div>
      <form id="contact-form" class="p-6 space-y-4" onsubmit="submitContact(event)">
        @csrf
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Full Name *</label>
            <input type="text" name="name" required placeholder="Rahul Sharma"
              class="w-full rounded-xl border border-slate-700 bg-slate-800 px-3 py-2.5 text-sm text-slate-100 outline-none focus:border-amber-400 transition">
          </div>
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Phone *</label>
            <input type="tel" name="phone" required placeholder="+91 9876543210"
              class="w-full rounded-xl border border-slate-700 bg-slate-800 px-3 py-2.5 text-sm text-slate-100 outline-none focus:border-amber-400 transition">
          </div>
        </div>
        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Business Email *</label>
          <input type="email" name="email" required placeholder="rahul@company.com"
            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-3 py-2.5 text-sm text-slate-100 outline-none focus:border-amber-400 transition">
        </div>
        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Company Name *</label>
          <input type="text" name="company" required placeholder="Acme Exports Pvt Ltd"
            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-3 py-2.5 text-sm text-slate-100 outline-none focus:border-amber-400 transition">
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Business Type
              *</label>
            <select name="business_type" required
              class="w-full rounded-xl border border-slate-700 bg-slate-800 px-3 py-2.5 text-sm text-slate-100 outline-none focus:border-amber-400 transition">
              <option value="">Select…</option>
              @foreach(['E-commerce', 'Manufacturing', 'Retail', 'Pharma', 'FMCG', 'Other'] as $bt)
                <option value="{{ $bt }}">{{ $bt }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Monthly Volume
              *</label>
            <select name="monthly_volume" required
              class="w-full rounded-xl border border-slate-700 bg-slate-800 px-3 py-2.5 text-sm text-slate-100 outline-none focus:border-amber-400 transition">
              <option value="">Select…</option>
              @foreach(['< 100', '100–500', '500–2000', '2000–5000', '5000+'] as $v)
                <option value="{{ $v }}">{{ $v }} shipments/mo</option>
              @endforeach
            </select>
          </div>
        </div>
        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Message /
            Requirements</label>
          <textarea name="message" rows="3" placeholder="Tell us about your logistics needs…"
            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-3 py-2.5 text-sm text-slate-100 outline-none focus:border-amber-400 transition resize-none"></textarea>
        </div>
        <div id="contact-error"
          class="hidden rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-2 text-sm text-red-300"></div>
        <button type="submit" id="contact-submit"
          class="w-full rounded-xl bg-amber-400 py-3.5 text-sm font-bold text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20">
          Send Message →
        </button>
      </form>
    </div>
  </div>

@endsection


@push('scripts')
  <style>
    @keyframes floatParticle {
      0% {
        transform: translateY(0px) scale(1);
      }

      100% {
        transform: translateY(-24px) scale(1.3);
      }
    }

    @keyframes marqueeScroll {
      0% {
        transform: translateX(0);
      }

      100% {
        transform: translateX(-50%);
      }
    }
  </style>
  <script>
    // === Canvas Particle Network ===
    (function () {
      const canvas = document.getElementById('heroCanvas');
      if (!canvas) return;
      const ctx = canvas.getContext('2d');
      let W, H, nodes = [];
      const N = 60, MAX_DIST = 140;
      function resize() {
        W = canvas.width = canvas.offsetWidth;
        H = canvas.height = canvas.offsetHeight;
      }
      function init() {
        nodes = Array.from({ length: N }, () => ({
          x: Math.random() * W, y: Math.random() * H,
          vx: (Math.random() - 0.5) * 0.4, vy: (Math.random() - 0.5) * 0.4,
          r: Math.random() * 2 + 1.5
        }));
      }
      function draw() {
        ctx.clearRect(0, 0, W, H);
        nodes.forEach(n => {
          n.x += n.vx; n.y += n.vy;
          if (n.x < 0 || n.x > W) n.vx *= -1;
          if (n.y < 0 || n.y > H) n.vy *= -1;
          ctx.beginPath();
          ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
          ctx.fillStyle = 'rgba(148,163,184,0.5)';
          ctx.fill();
        });
        for (let i = 0; i < N; i++) {
          for (let j = i + 1; j < N; j++) {
            const dx = nodes[i].x - nodes[j].x, dy = nodes[i].y - nodes[j].y;
            const d = Math.sqrt(dx * dx + dy * dy);
            if (d < MAX_DIST) {
              ctx.beginPath();
              ctx.moveTo(nodes[i].x, nodes[i].y);
              ctx.lineTo(nodes[j].x, nodes[j].y);
              ctx.strokeStyle = `rgba(100,130,200,${0.15 * (1 - d / MAX_DIST)})`;
              ctx.lineWidth = 0.8;
              ctx.stroke();
            }
          }
        }
        requestAnimationFrame(draw);
      }
      resize(); init(); draw();
      window.addEventListener('resize', () => { resize(); init(); });
    })();

    // === Tracking form validation ===
    function validateTrackForm() {
      const val = document.getElementById('hero-tracking-input')?.value?.trim();
      const err = document.getElementById('track-error');
      if (!val) {
        if (err) { err.classList.remove('hidden'); setTimeout(() => err.classList.add('hidden'), 4000); }
        return false;
      }
      return true;
    }

    // === Intersection Observer Counters ===
    document.querySelectorAll('.counter[data-target]').forEach(el => {
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const target = parseInt(el.dataset.target);
            const suffix = el.dataset.suffix || '';
            let current = 0;
            const step = Math.ceil(target / 80);
            const timer = setInterval(() => {
              current = Math.min(current + step, target);
              el.textContent = (target >= 1000 ? current.toLocaleString() : current) + suffix;
              if (current >= target) clearInterval(timer);
            }, 25);
            observer.unobserve(el);
          }
        });
      }, { threshold: 0.5 });
      observer.observe(el);
    });

    // === Contact Sales Modal ===
    function openContactModal() {
      const modal = document.getElementById('contact-modal');
      const panel = document.getElementById('contact-panel');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';
      requestAnimationFrame(() => {
        panel.style.transform = 'translateY(0)';
        panel.style.opacity = '1';
      });
    }

    function closeContactModal() {
      const modal = document.getElementById('contact-modal');
      const panel = document.getElementById('contact-panel');
      panel.style.transform = 'translateY(2rem)';
      panel.style.opacity = '0';
      setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
      }, 280);
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeContactModal(); });

    async function submitContact(e) {
      e.preventDefault();
      const form = document.getElementById('contact-form');
      const btn = document.getElementById('contact-submit');
      const err = document.getElementById('contact-error');
      err.classList.add('hidden');
      btn.disabled = true;
      btn.textContent = 'Sending…';

      const data = new FormData(form);

      try {
        const res = await fetch('/contact-leads', { method: 'POST', body: data, headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content } });
        const json = await res.json();
        if (json.success) {
          closeContactModal();
          showToast('success', json.message || "Thanks! Our team will reach out within 24 hours.");
          form.reset();
        } else {
          err.textContent = json.message || 'An error occurred. Please try again.';
          err.classList.remove('hidden');
        }
      } catch (ex) {
        err.textContent = 'Network error. Please try again.';
        err.classList.remove('hidden');
      }
      btn.disabled = false;
      btn.textContent = 'Send Message →';
    }

    // === Global Toast System ===
    function showToast(type, msg) {
      const colors = { success: 'border-emerald-500/40 bg-emerald-500/10 text-emerald-300', error: 'border-red-500/40 bg-red-500/10 text-red-300', info: 'border-blue-500/40 bg-blue-500/10 text-blue-300', warning: 'border-amber-500/40 bg-amber-500/10 text-amber-300' };
      const toast = document.createElement('div');
      toast.className = `fixed top-4 right-4 z-[300] flex items-center gap-3 rounded-xl border px-5 py-3 text-sm font-medium shadow-xl transition-all duration-300 ${colors[type] || colors.info}`;
      toast.style.cssText = 'transform:translateX(120%);';
      toast.innerHTML = `<span>${msg}</span><button onclick="this.parentElement.remove()" class="ml-2 opacity-60 hover:opacity-100 text-lg leading-none">&times;</button>`;
      document.body.appendChild(toast);
      requestAnimationFrame(() => { toast.style.transform = 'translateX(0)'; });
      setTimeout(() => { toast.style.transform = 'translateX(120%)'; setTimeout(() => toast.remove(), 300); }, 5000);
    }
  </script>
@endpush