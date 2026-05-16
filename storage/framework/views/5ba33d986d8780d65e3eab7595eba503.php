<?php $__env->startSection('page_title', config('app.name', 'SwiftShip')); ?>
<?php $__env->startSection('page_subtitle', 'Real-Time Logistics, Delivered With Precision'); ?>
<?php $__env->startSection('meta_description', 'Track shipments in real-time across India. SwiftShip — 50K+ shipments delivered, 99.8% on-time, 15+ carrier partners.'); ?>

<?php $__env->startSection('content'); ?>


<section class="relative min-h-screen flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #0c1a3a 50%, #0f172a 100%); padding-top: 5rem;">

  
  <div class="absolute inset-0 pointer-events-none" style="background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cpath d='M 80 0 L 0 0 0 80' fill='none' stroke='%231e3a5f' stroke-width='1'/%3E%3C/svg%3E\"); background-size: 80px 80px; opacity: 0.35;"></div>

  
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <?php for($i = 0; $i < 18; $i++): ?>
      <div class="particle" style="
        position: absolute;
        width: <?php echo e(rand(3,7)); ?>px; height: <?php echo e(rand(3,7)); ?>px;
        border-radius: 50%;
        background: <?php echo e($i % 3 === 0 ? '#f59e0b' : ($i % 3 === 1 ? '#3b82f6' : '#0ea5e9')); ?>;
        left: <?php echo e(rand(5,95)); ?>%;
        top: <?php echo e(rand(10,90)); ?>%;
        opacity: <?php echo e(rand(15,50) / 100); ?>;
        animation: floatParticle <?php echo e(rand(8,18)); ?>s ease-in-out <?php echo e(rand(0,8)); ?>s infinite alternate;
      "></div>
    <?php endfor; ?>
  </div>

  <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 text-center">
    <div class="inline-flex items-center gap-2 rounded-full border border-amber-400/30 bg-amber-400/10 px-4 py-1.5 text-xs font-semibold text-amber-300 mb-8 tracking-wider uppercase">
      <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
      Live Network — Tracking Active Across India
    </div>

    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight text-white">
      Real-Time Logistics,<br>
      <span style="background: linear-gradient(90deg, #f59e0b, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Delivered With Precision</span>
    </h1>

    <p class="mt-6 text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
      Track your shipments instantly across India's largest carrier network. Get real-time GPS updates, delay alerts, and door-step delivery notifications — all in one dashboard.
    </p>

    
    <form method="GET" action="<?php echo e(route('tracking.lookup')); ?>" class="mt-10 flex flex-col sm:flex-row gap-3 max-w-2xl mx-auto" id="hero-track-form">
      <input
        name="tracking_number"
        type="text"
        placeholder="Enter your Tracking Number (e.g. IND250512ABCDEF)"
        class="flex-1 rounded-xl border border-slate-700 bg-slate-900/80 backdrop-blur px-5 py-4 text-sm text-slate-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 font-mono placeholder-slate-500"
        autocomplete="off"
      >
      <button type="submit" class="rounded-xl bg-amber-400 px-8 py-4 text-sm font-bold text-slate-950 transition hover:bg-amber-300 active:scale-95 whitespace-nowrap shadow-lg shadow-amber-500/25 flex items-center gap-2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Track Now
      </button>
    </form>

    
    <div class="mt-8 flex flex-wrap items-center justify-center gap-6">
      <div class="flex items-center gap-2 text-sm text-slate-400">
        <span class="text-amber-400 font-bold text-lg">50K+</span> Shipments
      </div>
      <span class="text-slate-700">|</span>
      <div class="flex items-center gap-2 text-sm text-slate-400">
        <span class="text-emerald-400 font-bold text-lg">99.8%</span> On-Time
      </div>
      <span class="text-slate-700">|</span>
      <div class="flex items-center gap-2 text-sm text-slate-400">
        <span class="text-blue-400 font-bold text-lg">15+</span> Carriers
      </div>
    </div>
  </div>
</section>


<section class="py-24 bg-slate-950" id="how-it-works">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">
    <div class="text-center mb-16">
      <p class="text-xs font-semibold uppercase tracking-widest text-amber-400 mb-3">Simple Process</p>
      <h2 class="text-3xl sm:text-4xl font-black text-white">How It Works</h2>
      <p class="mt-4 text-slate-400 max-w-xl mx-auto">Three steps from order to doorstep — with full visibility at every stage.</p>
    </div>

    <div class="relative grid grid-cols-1 md:grid-cols-3 gap-10">
      
      <div class="hidden md:block absolute top-12 left-1/6 right-1/6 h-px" style="background: repeating-linear-gradient(90deg, #334155 0, #334155 8px, transparent 8px, transparent 18px); left: 18%; right: 18%; top: 3rem;"></div>

      <?php
        $steps = [
          ['icon' => '<path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>', 'step' => '01', 'title' => 'Place Your Order', 'desc' => 'Submit your shipment details via our portal or API. Our system auto-assigns the best carrier for your route and weight.'],
          ['icon' => '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>', 'step' => '02', 'title' => 'We Pick & Ship', 'desc' => 'Your carrier collects the package, logs it into our network, and begins the transit journey with real-time scan updates.'],
          ['icon' => '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>', 'step' => '03', 'title' => 'Track in Real Time', 'desc' => 'Watch your shipment move on a live map. Receive SMS/email alerts at every milestone until delivery is confirmed.'],
        ];
      ?>

      <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="relative flex flex-col items-center text-center group">
        <div class="relative z-10 w-24 h-24 rounded-2xl border border-slate-700 bg-slate-900 flex flex-col items-center justify-center mb-6 group-hover:border-amber-400/60 transition-all duration-300 group-hover:shadow-lg group-hover:shadow-amber-500/10">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><?php echo $s['icon']; ?></svg>
          <span class="absolute -top-3 -right-3 w-7 h-7 rounded-full bg-amber-400 text-slate-950 text-xs font-black flex items-center justify-center"><?php echo e($s['step']); ?></span>
        </div>
        <h3 class="text-lg font-bold text-white mb-3"><?php echo e($s['title']); ?></h3>
        <p class="text-sm text-slate-400 leading-relaxed max-w-xs"><?php echo e($s['desc']); ?></p>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<section class="py-24 bg-slate-900/50" id="features">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">
    <div class="text-center mb-16">
      <p class="text-xs font-semibold uppercase tracking-widest text-blue-400 mb-3">Platform Capabilities</p>
      <h2 class="text-3xl sm:text-4xl font-black text-white">Everything You Need</h2>
      <p class="mt-4 text-slate-400 max-w-xl mx-auto">Built for logistics teams that demand accuracy, speed, and full control.</p>
    </div>

    <?php
      $features = [
        ['icon' => '<circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>', 'color' => 'amber', 'title' => 'Real-Time GPS Tracking', 'desc' => 'Live coordinates updated every 60s on an interactive Leaflet map. Know exactly where every parcel is.'],
        ['icon' => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>', 'color' => 'blue', 'title' => 'Instant Delay Alerts', 'desc' => 'Push and email notifications trigger the moment a shipment deviates from its scheduled ETA.'],
        ['icon' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>', 'color' => 'emerald', 'title' => 'Multi-Carrier Support', 'desc' => 'Unified dashboard for BlueDart, DTDC, Delhivery, Ecom Express, India Post and more — one portal, all carriers.'],
        ['icon' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.64 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.55 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>', 'color' => 'purple', 'title' => 'Customer Notifications', 'desc' => 'Auto-send SMS and email updates to recipients at pickup, transit, out-for-delivery, and delivered milestones.'],
        ['icon' => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>', 'color' => 'cyan', 'title' => 'Detailed Analytics', 'desc' => 'Charts for on-time rates, carrier performance, shipment volumes, and delay trends — exportable as CSV.'],
        ['icon' => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>', 'color' => 'orange', 'title' => 'Secure Role-Based Access', 'desc' => 'Admin, Manager, and Viewer roles with granular permissions. All actions logged with full audit trail.'],
      ];
      $colorMap = [
        'amber'   => ['border' => '#92400e', 'bg' => 'rgba(245,158,11,0.08)', 'stroke' => '#f59e0b'],
        'blue'    => ['border' => '#1e3a5f', 'bg' => 'rgba(59,130,246,0.08)',  'stroke' => '#3b82f6'],
        'emerald' => ['border' => '#064e3b', 'bg' => 'rgba(16,185,129,0.08)', 'stroke' => '#10b981'],
        'purple'  => ['border' => '#3b1f6b', 'bg' => 'rgba(139,92,246,0.08)', 'stroke' => '#8b5cf6'],
        'cyan'    => ['border' => '#164e63', 'bg' => 'rgba(6,182,212,0.08)',  'stroke' => '#06b6d4'],
        'orange'  => ['border' => '#7c2d12', 'bg' => 'rgba(249,115,22,0.08)', 'stroke' => '#f97316'],
      ];
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $c = $colorMap[$f['color']]; ?>
        <div class="group rounded-2xl border p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl cursor-default"
             style="border-color: <?php echo e($c['border']); ?>; background: <?php echo e($c['bg']); ?>;">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background: rgba(255,255,255,0.04); border: 1px solid <?php echo e($c['border']); ?>;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="<?php echo e($c['stroke']); ?>" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><?php echo $f['icon']; ?></svg>
          </div>
          <h3 class="text-base font-bold text-white mb-2"><?php echo e($f['title']); ?></h3>
          <p class="text-sm text-slate-400 leading-relaxed"><?php echo e($f['desc']); ?></p>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<section class="py-20 bg-slate-950 border-y border-slate-800" id="stats"
  x-data="{
    done: false,
    counts: { shipments: 0, carriers: 0, clients: 0, rate: 0 },
    targets: { shipments: 50000, carriers: 15, clients: 500, rate: 998 }
  }"
  x-intersect.once="
    done = true;
    Object.keys(targets).forEach(k => {
      let start = 0, end = targets[k], dur = 2000, step = 16;
      let timer = setInterval(() => {
        start += Math.ceil(end / (dur/step));
        if(start >= end){ start = end; clearInterval(timer); }
        counts[k] = start;
      }, step);
    });
  ">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-10 text-center">
      <div>
        <div class="text-4xl sm:text-5xl font-black text-amber-400" x-text="counts.shipments >= 50000 ? '50,000+' : counts.shipments.toLocaleString()">0</div>
        <p class="mt-2 text-sm text-slate-400 font-medium">Shipments Delivered</p>
      </div>
      <div>
        <div class="text-4xl sm:text-5xl font-black text-blue-400" x-text="counts.carriers >= 15 ? '15+' : counts.carriers">0</div>
        <p class="mt-2 text-sm text-slate-400 font-medium">Carrier Partners</p>
      </div>
      <div>
        <div class="text-4xl sm:text-5xl font-black text-emerald-400" x-text="counts.clients >= 500 ? '500+' : counts.clients">0</div>
        <p class="mt-2 text-sm text-slate-400 font-medium">Business Clients</p>
      </div>
      <div>
        <div class="text-4xl sm:text-5xl font-black text-cyan-400" x-text="counts.rate >= 998 ? '99.8%' : (counts.rate/10).toFixed(1)+'%'">0</div>
        <p class="mt-2 text-sm text-slate-400 font-medium">On-Time Rate</p>
      </div>
    </div>
  </div>
</section>


<section class="py-14 bg-slate-900/60 overflow-hidden border-b border-slate-800">
  <div class="mx-auto max-w-6xl px-4 mb-8 text-center">
    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Our Carrier Network</p>
  </div>
  <div class="relative overflow-hidden">
    <div class="flex gap-12 items-center" style="animation: marqueeScroll 22s linear infinite; width: max-content;">
      <?php
        $carriers = ['BlueDart','DTDC','Delhivery','Ecom Express','India Post','FedEx India','Xpressbees','Shadowfax','Shiprocket','Borzo'];
        $emojis   = ['✈️','🚛','🏎️','📦','📮','🌐','⚡','🌑','🚀','🛵'];
      ?>
      <?php $__currentLoopData = array_merge($carriers, $carriers); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center gap-2 px-6 py-3 rounded-full border border-slate-700 bg-slate-900/80 whitespace-nowrap text-sm font-semibold text-slate-300 hover:border-amber-400/40 hover:text-white transition-colors cursor-default">
          <span><?php echo e($emojis[$i % count($emojis)]); ?></span>
          <?php echo e($carrier); ?>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<section class="py-24 bg-slate-950" id="about">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">
    <div class="text-center mb-16">
      <p class="text-xs font-semibold uppercase tracking-widest text-emerald-400 mb-3">Client Stories</p>
      <h2 class="text-3xl sm:text-4xl font-black text-white">Trusted by Businesses Across India</h2>
    </div>

    <?php
      $testimonials = [
        ['name' => 'Priya Venkataraman', 'company' => 'NovaTex Exports', 'city' => 'Chennai', 'stars' => 5, 'quote' => 'SwiftShip cut our customer complaint rate by 60%. The live map and delay alerts are a game-changer for our export operations. We\'ve never had this kind of visibility before.'],
        ['name' => 'Rohan Malhotra', 'company' => 'UrbanKart Retail', 'city' => 'Delhi', 'stars' => 5, 'quote' => 'Managing 5 carriers from one portal was something we\'d only dreamed of. The role-based access means our ops team, managers, and finance all have exactly what they need.'],
        ['name' => 'Anitha Krishnaswamy', 'company' => 'MedLine Pharma', 'city' => 'Bangalore', 'stars' => 5, 'quote' => 'For temperature-sensitive shipments, the real-time tracking and instant alerts have been critical. SwiftShip is now our backbone for pan-India pharmaceutical logistics.'],
      ];
    ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 flex flex-col gap-4 hover:border-slate-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-black/30">
          <div class="flex gap-1">
            <?php for($i = 0; $i < $t['stars']; $i++): ?>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#f59e0b" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <?php endfor; ?>
          </div>
          <p class="text-sm text-slate-300 leading-relaxed flex-1">"<?php echo e($t['quote']); ?>"</p>
          <div class="flex items-center gap-3 pt-2 border-t border-slate-800">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-blue-500 flex items-center justify-center font-bold text-slate-950 text-sm flex-shrink-0">
              <?php echo e(substr($t['name'], 0, 1)); ?>

            </div>
            <div>
              <p class="text-sm font-semibold text-white"><?php echo e($t['name']); ?></p>
              <p class="text-xs text-slate-500"><?php echo e($t['company']); ?> · <?php echo e($t['city']); ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<section class="py-20" style="background: linear-gradient(135deg, #0c1a3a 0%, #0f172a 100%); border-top: 1px solid #1e293b;">
  <div class="mx-auto max-w-3xl px-4 text-center">
    <h2 class="text-3xl sm:text-4xl font-black text-white mb-4">Ready to streamline your logistics?</h2>
    <p class="text-slate-400 mb-10 text-lg">Join 500+ businesses using SwiftShip to deliver faster, smarter, and with total visibility.</p>
    <div class="flex flex-wrap items-center justify-center gap-4">
      <a href="<?php echo e(route('home')); ?>#contact" class="rounded-xl border border-slate-600 px-8 py-4 text-sm font-bold text-slate-100 hover:border-slate-400 hover:bg-slate-800 transition-all">
        Contact Sales
      </a>
      <a href="<?php echo e(route('login')); ?>" class="rounded-xl bg-amber-400 px-8 py-4 text-sm font-bold text-slate-950 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/25 flex items-center gap-2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Admin Login
      </a>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<style>
@keyframes floatParticle {
  0%   { transform: translateY(0px) scale(1);   }
  100% { transform: translateY(-24px) scale(1.3); }
}
@keyframes marqueeScroll {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/home.blade.php ENDPATH**/ ?>