<!doctype html>
<html lang="en" x-data="bookingWizard()" x-init="init()">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>SwiftShip | Book Shipment</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  <style>
    body {
      font-family: Inter, ui-sans-serif, system-ui, sans-serif;
    }

    .step-panel {
      display: none;
    }

    .step-panel.active {
      display: block;
    }

    .field-label {
      font-size: 0.72rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: #64748b;
      margin-bottom: 5px;
      display: block;
    }

    .field-input {
      width: 100%;
      border-radius: 0.75rem;
      border: 1px solid #334155;
      background: rgba(30, 41, 59, 0.8);
      padding: 0.7rem 1rem;
      font-size: 0.875rem;
      color: #f8fafc;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    .field-input:focus {
      border-color: #f59e0b;
      box-shadow: 0 0 0 3px rgba(245, 158, 11, .15);
    }

    .carrier-card {
      border: 2px solid #334155;
      border-radius: 1rem;
      padding: 1.25rem;
      cursor: pointer;
      transition: all .2s;
      background: rgba(30, 41, 59, .6);
    }

    .carrier-card:hover {
      border-color: rgba(245, 158, 11, .5);
    }

    .carrier-card.selected {
      border-color: #f59e0b;
      background: rgba(245, 158, 11, .08);
    }

    .step-dot {
      width: 2rem;
      height: 2rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .75rem;
      font-weight: 700;
      border: 2px solid;
      transition: all .3s;
    }
  </style>
</head>

<body class="min-h-screen bg-slate-950 text-slate-100">

  
  <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur border-b border-slate-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 flex h-14 items-center justify-between">
      <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
        <span
          class="grid h-7 w-7 place-items-center rounded bg-amber-400 font-mono font-black text-slate-950 text-xs">SS</span>
        <span class="text-sm font-extrabold text-white">Swift<span class="text-amber-400">Ship</span></span>
      </a>
      <a href="<?php echo e(route('customer.dashboard')); ?>"
        class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
          stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12" />
          <polyline points="12 19 5 12 12 5" />
        </svg>
        Dashboard
      </a>
    </div>
  </nav>

  <div class="pt-16 pb-12 min-h-screen">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 py-8">

      
      <div class="mb-8">
        <div class="flex items-center justify-between relative">
          <div class="absolute top-4 left-4 right-4 h-0.5 bg-slate-800 z-0">
            <div class="h-full bg-amber-400 transition-all duration-500"
              :style="'width:'+Math.max(0, (step-1)/3*100)+'%'"></div>
          </div>
          <?php $__currentLoopData = ['Package Details', 'Specifications', 'Choose Carrier', 'Review & Pay']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="relative z-10 flex flex-col items-center gap-1.5">
              <div class="step-dot w-8 h-8" :class="{
                 'border-amber-400 bg-amber-400 text-slate-950': step > <?php echo e($i + 1); ?>,
                 'border-amber-400 bg-amber-400/20 text-amber-400': step == <?php echo e($i + 1); ?>,
                 'border-slate-700 bg-slate-900 text-slate-500': step < <?php echo e($i + 1); ?>

               }">
                <template x-if="step > <?php echo e($i + 1); ?>">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                  </svg>
                </template>
                <template x-if="step <= <?php echo e($i + 1); ?>">
                  <span class="text-xs font-bold"><?php echo e(str_pad($i + 1, 2, '0', STR_PAD_LEFT)); ?></span>
                </template>
              </div>
              <span class="text-xs font-medium hidden sm:block"
                :class="step == <?php echo e($i + 1); ?> ? 'text-amber-400' : 'text-slate-500'"><?php echo e($label); ?></span>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <form id="booking-form" method="POST" action="<?php echo e(route('customer.shipments.store')); ?>" novalidate>
        <?php echo csrf_field(); ?>

        <?php if($errors->any()): ?>
          <div class="mb-5 rounded-xl border border-red-500/40 bg-red-500/10 p-4">
            <div class="flex items-center gap-2 text-red-400 font-bold mb-2">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
              </svg>
              Please fix the following errors:
            </div>
            <ul class="list-disc list-inside text-sm text-red-300">
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        <?php endif; ?>

        
        <div class="step-panel" :class="step==1 ? 'active' : ''">
          <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6 mb-4">
            <h2 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
              <span
                class="w-6 h-6 rounded-full bg-amber-400/20 border border-amber-400/40 flex items-center justify-center text-xs font-bold text-amber-400">1</span>
              Sender & Pickup Details
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="field-label">Sender Name *</label>
                <input type="text" name="sender_name" class="field-input" value="<?php echo e(auth()->user()->name); ?>" required
                  placeholder="Your full name">
              </div>
              <div>
                <label class="field-label">Sender Phone *</label>
                <input type="tel" name="sender_phone" class="field-input" value="<?php echo e(auth()->user()->phone); ?>" required
                  placeholder="+91 9876543210">
              </div>
              <div class="sm:col-span-2">
                <label class="field-label">Sender Email *</label>
                <input type="email" name="sender_email" class="field-input" value="<?php echo e(auth()->user()->email); ?>"
                  required>
              </div>
              <div class="sm:col-span-2">
                <label class="field-label">Pickup Street Address *</label>
                <input type="text" name="pickup_address" class="field-input" required
                  placeholder="House No, Street, Area">
              </div>
              <div>
                <label class="field-label">Pickup State *</label>
                <select name="pickup_state" class="field-input" required x-model="pickupState"
                  @change="pickupCity = ''; fetchFares()">
                  <option value="">Select State</option>
                  <template x-for="state in Object.keys(stateCityMap)" :key="state">
                    <option :value="state" x-text="state"></option>
                  </template>
                </select>
              </div>
              <div>
                <label class="field-label">Pickup City *</label>
                <select name="pickup_city" class="field-input" required x-model="pickupCity" @change="fetchFares()"
                  :disabled="!pickupState">
                  <option value="">Select City</option>
                  <template x-if="pickupState">
                    <template x-for="city in stateCityMap[pickupState]" :key="city">
                      <option :value="city" x-text="city"></option>
                    </template>
                  </template>
                </select>
              </div>
              <div>
                <label class="field-label">Pickup PIN Code *</label>
                <input type="text" name="pickup_pin" class="field-input" maxlength="6" pattern="\d{6}" required
                  placeholder="400001">
              </div>
            </div>
          </div>

          <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
            <h2 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
              <span
                class="w-6 h-6 rounded-full bg-blue-500/20 border border-blue-500/40 flex items-center justify-center text-xs font-bold text-blue-400">R</span>
              Recipient & Delivery Details
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="field-label">Recipient Name *</label>
                <input type="text" name="recipient_name" class="field-input" required
                  placeholder="Recipient's full name">
              </div>
              <div>
                <label class="field-label">Recipient Phone *</label>
                <input type="tel" name="recipient_phone" class="field-input" required placeholder="+91 9876543210">
              </div>
              <div class="sm:col-span-2">
                <label class="field-label">Recipient Email (optional)</label>
                <input type="email" name="recipient_email" class="field-input" placeholder="recipient@example.com">
              </div>
              <div class="sm:col-span-2">
                <label class="field-label">Delivery Street Address *</label>
                <input type="text" name="delivery_address" class="field-input" required
                  placeholder="House No, Street, Area">
              </div>
              <div>
                <label class="field-label">Delivery State *</label>
                <select name="delivery_state" class="field-input" required x-model="destState"
                  @change="destCity = ''; fetchFares()">
                  <option value="">Select State</option>
                  <template x-for="state in Object.keys(stateCityMap)" :key="state">
                    <option :value="state" x-text="state"></option>
                  </template>
                </select>
              </div>
              <div>
                <label class="field-label">Delivery City *</label>
                <select name="delivery_city" class="field-input" required x-model="destCity" @change="fetchFares()"
                  :disabled="!destState">
                  <option value="">Select City</option>
                  <template x-if="destState">
                    <template x-for="city in stateCityMap[destState]" :key="city">
                      <option :value="city" x-text="city"></option>
                    </template>
                  </template>
                </select>
              </div>
              <div>
                <label class="field-label">Delivery PIN Code *</label>
                <input type="text" name="delivery_pin" class="field-input" maxlength="6" pattern="\d{6}" required
                  placeholder="302001">
              </div>

            </div>
          </div>
        </div>

        
        <div class="step-panel" :class="step==2 ? 'active' : ''">
          <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
            <h2 class="text-lg font-bold text-white mb-5">Package Specifications</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="sm:col-span-2">
                <label class="field-label">Package Type *</label>
                <select name="package_type" class="field-input" required>
                  <?php $__currentLoopData = ['Document', 'Small Parcel', 'Medium Box', 'Large Box', 'Fragile', 'Electronics', 'Clothing', 'Food & Perishable', 'Industrial']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type); ?>"><?php echo e($type); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div>
                <label class="field-label">Weight (kg) *</label>
                <input type="number" name="weight_kg" class="field-input" min="0.1" max="500" step="0.1" required
                  placeholder="1.5" x-model="weightKg" @input="fetchFares()">
              </div>
              <div>
                <label class="field-label">Quantity</label>
                <input type="number" name="quantity" class="field-input" min="1" value="1">
              </div>
              <div>
                <label class="field-label">Length (cm) *</label>
                <input type="number" name="length_cm" class="field-input" min="1" max="300" step="0.1" required
                  placeholder="30" x-model="lengthCm" @input="fetchFares()">
              </div>
              <div>
                <label class="field-label">Width (cm) *</label>
                <input type="number" name="width_cm" class="field-input" min="1" max="300" step="0.1" required
                  placeholder="20" x-model="widthCm" @input="fetchFares()">
              </div>
              <div>
                <label class="field-label">Height (cm) *</label>
                <input type="number" name="height_cm" class="field-input" min="1" max="300" step="0.1" required
                  placeholder="15" x-model="heightCm" @input="fetchFares()">
              </div>
              <div>
                <label class="field-label">Declared Value (₹)</label>
                <input type="number" name="declared_value" class="field-input" min="0" placeholder="5000">
              </div>
              <div class="sm:col-span-2">
                <label class="field-label">Special Instructions</label>
                <textarea name="special_instructions" class="field-input" rows="2"
                  placeholder="Fragile, keep upright, etc."></textarea>
              </div>
              <div class="sm:col-span-2">
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="checkbox" name="is_dangerous" value="1"
                    class="rounded border-slate-600 bg-slate-900 text-amber-400 w-4 h-4">
                  <span class="text-sm text-slate-300">This is a dangerous goods / hazmat shipment</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        
        <div class="step-panel" :class="step==3 ? 'active' : ''">
          <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
            <h2 class="text-lg font-bold text-white mb-2">Choose Carrier & Service</h2>
            <p class="text-xs text-slate-500 mb-5">Select the best option for your shipment</p>

            
            <div class="flex flex-wrap gap-2 mb-6">
              <?php $__currentLoopData = ['standard' => 'Standard', 'express' => 'Express', 'economy' => 'Economy']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" class="rounded-lg px-4 py-2 text-xs font-bold border transition"
                  :class="serviceType=='<?php echo e($val); ?>' ? 'bg-amber-400 text-slate-950 border-amber-400' : 'border-slate-700 text-slate-400 hover:border-amber-400/50'"
                  @click="serviceType='<?php echo e($val); ?>'; fetchFares()"><?php echo e($label); ?></button>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <input type="hidden" name="service_type" :value="serviceType">
            <input type="hidden" name="carrier_id" :value="selectedCarrier">

            <div class="space-y-3" x-show="!loadingFares">
              <?php $__currentLoopData = $carriers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="carrier-card" :class="selectedCarrier=='<?php echo e($carrier->id); ?>' ? 'selected' : ''"
                  @click="selectedCarrier='<?php echo e($carrier->id); ?>'">
                  <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                      <div
                        class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-lg font-black text-amber-400">
                        <?php echo e(substr($carrier->name, 0, 1)); ?>

                      </div>
                      <div>
                        <p class="font-bold text-white text-sm"><?php echo e($carrier->name); ?></p>
                        <p class="text-xs text-slate-400"><?php echo e($carrier->est_days_min); ?>â€“<?php echo e($carrier->est_days_max); ?>

                          business days</p>
                        <p class="text-xs text-slate-500"><?php echo e(ucfirst($carrier->type)); ?> Â· Rating <?php echo e($carrier->rating); ?>/5
                        </p>
                      </div>
                    </div>
                    <div class="text-right flex-shrink-0">
                      <div x-show="fares['<?php echo e($carrier->id); ?>']" class="text-lg font-black text-amber-400">
                        ₹<span x-text="fares['<?php echo e($carrier->id); ?>']?.total?.toFixed(0) ?? '—'"></span>
                      </div>
                      <div x-show="!fares['<?php echo e($carrier->id); ?>']" class="text-lg font-black text-slate-500">—</div>
                      <div class="text-xs text-slate-500 mt-0.5">
                        incl. GST
                      </div>
                    </div>
                  </div>
                  
                  <div x-show="selectedCarrier=='<?php echo e($carrier->id); ?>' && fares['<?php echo e($carrier->id); ?>']"
                    class="mt-4 pt-4 border-t border-slate-700/60">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                      <div>
                        <p class="text-slate-500">Base Fare</p>
                        <p class="font-semibold text-white">₹<span
                            x-text="fares['<?php echo e($carrier->id); ?>']?.base_fare?.toFixed(0)"></span></p>
                      </div>
                      <div>
                        <p class="text-slate-500">Weight</p>
                        <p class="font-semibold text-white">₹<span
                            x-text="fares['<?php echo e($carrier->id); ?>']?.weight_charge?.toFixed(0)"></span></p>
                      </div>
                      <div>
                        <p class="text-slate-500">Distance</p>
                        <p class="font-semibold text-white">₹<span
                            x-text="fares['<?php echo e($carrier->id); ?>']?.distance_charge?.toFixed(0)"></span></p>
                      </div>
                      <div>
                        <p class="text-slate-500">GST 18%</p>
                        <p class="font-semibold text-amber-400">₹<span
                            x-text="fares['<?php echo e($carrier->id); ?>']?.gst?.toFixed(0)"></span></p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div x-show="loadingFares" class="py-10 text-center">
              <div class="inline-flex items-center gap-2 text-slate-400 text-sm">
                <svg class="animate-spin" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                </svg>
                Calculating fares…
              </div>
            </div>
          </div>
        </div>

        
        <div class="step-panel" :class="step==4 ? 'active' : ''">
          <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6 space-y-5">
            <h2 class="text-lg font-bold text-white">Review & Confirm</h2>

            <div class="rounded-xl bg-slate-950/60 p-4 border border-slate-800 text-sm space-y-2">
              <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider mb-3">Summary</p>
              <div class="flex justify-between text-slate-300"><span>Route</span><span class="font-semibold text-white"
                  x-text="(pickupCity || '?') + ' → ' + (destCity || '?')"></span></div>
              <div class="flex justify-between text-slate-300"><span>Package Type</span><span
                  class="font-semibold text-white"
                  x-text="document.querySelector('[name=package_type]')?.value || '—'"></span></div>
              <div class="flex justify-between text-slate-300"><span>Weight</span><span class="font-semibold text-white"
                  x-text="(weightKg||'—') + ' kg'"></span></div>
              <div class="flex justify-between text-slate-300"><span>Service</span><span
                  class="font-semibold text-white capitalize" x-text="serviceType"></span></div>
              <template x-if="selectedCarrier && fares[selectedCarrier]">
                <div class="border-t border-slate-800 pt-3 mt-3">
                  <div class="flex justify-between text-base font-bold"><span class="text-white">Total (incl.
                      GST)</span><span class="text-amber-400">₹<span
                        x-text="fares[selectedCarrier]?.total?.toFixed(2)"></span></span></div>
                </div>
              </template>
            </div>

            
            <div>
              <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider mb-3">Payment Method</p>
              <div class="space-y-2">
                <?php $__currentLoopData = ['razorpay' => ['Pay Online (Razorpay)', 'Credit/Debit/UPI/Netbanking', 'text-amber-400'], 'cod' => ['Pay on Pickup (COD)', 'No payment now', 'text-emerald-400'], 'bank_transfer' => ['Bank Transfer', 'NEFT/IMPS after booking', 'text-blue-400']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => [$label, $sub, $color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <label
                    class="flex items-center gap-3 rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 cursor-pointer hover:border-amber-400/40 transition">
                    <input type="radio" name="payment_method" value="<?php echo e($val); ?>" class="text-amber-400" <?php echo e($val === 'cod' ? 'checked' : ''); ?>>
                    <div>
                      <p class="text-sm font-semibold text-white"><?php echo e($label); ?></p>
                      <p class="text-xs <?php echo e($color); ?>"><?php echo e($sub); ?></p>
                    </div>
                  </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>
        </div>

        
        <div class="flex items-center justify-between mt-6 gap-3">
          <button type="button" x-show="step > 1" @click="step--"
            class="flex items-center gap-2 rounded-xl border border-slate-700 px-6 py-3 text-sm font-semibold text-slate-300 hover:border-slate-500 hover:bg-slate-800 transition">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
              stroke-linecap="round" stroke-linejoin="round">
              <line x1="19" y1="12" x2="5" y2="12" />
              <polyline points="12 19 5 12 12 5" />
            </svg>
            Back
          </button>
          <div x-show="step < 1" class="flex-1"></div>

          <button type="button" x-show="step < 4" @click="nextStep()"
            class="ml-auto rounded-xl bg-amber-400 px-8 py-3 text-sm font-bold text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20 flex items-center gap-2">
            Continue
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
              stroke-linecap="round" stroke-linejoin="round">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </button>

          <button type="submit" x-show="step == 4" @click="sessionStorage.removeItem('booking_step'); $el.disabled = true; $el.form.submit();"
            class="ml-auto rounded-xl bg-amber-400 px-8 py-3 text-sm font-bold text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20 flex items-center gap-2">
            Confirm & Book
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
              stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12" />
            </svg>
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function bookingWizard() {
      return {
        step: 1,
        pickupState: '',
        pickupCity: '',
        destState: '',
        destCity: '',
        serviceType: 'standard',
        selectedCarrier: '',
        weightKg: '',
        lengthCm: '',
        widthCm: '',
        heightCm: '',
        fares: {},
        loadingFares: false,
        stateCityMap: {
          'Maharashtra': ['Mumbai', 'Pune', 'Nagpur', 'Nashik',
            'Aurangabad', 'Thane', 'Solapur'],
          'Karnataka': ['Bengaluru', 'Mysuru', 'Hubli', 'Mangaluru',
            'Belagavi', 'Davangere', 'Ballari'],
          'Tamil Nadu': ['Chennai', 'Coimbatore', 'Madurai', 'Trichy',
            'Salem', 'Tirunelveli', 'Vellore'],
          'Delhi': ['New Delhi', 'Dwarka', 'Rohini', 'Saket',
            'Janakpuri', 'Laxmi Nagar', 'Connaught Place'],
          'Rajasthan': ['Jaipur', 'Jodhpur', 'Udaipur', 'Kota',
            'Ajmer', 'Bikaner', 'Alwar'],
          'Gujarat': ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot',
            'Gandhinagar', 'Bhavnagar', 'Jamnagar'],
          'Uttar Pradesh': ['Lucknow', 'Kanpur', 'Agra', 'Varanasi',
            'Allahabad', 'Meerut', 'Ghaziabad'],
          'West Bengal': ['Kolkata', 'Howrah', 'Durgapur', 'Asansol',
            'Siliguri', 'Darjeeling', 'Kharagpur'],
          'Punjab': ['Chandigarh', 'Ludhiana', 'Amritsar', 'Jalandhar',
            'Patiala', 'Bathinda', 'Mohali'],
          'Bihar': ['Patna', 'Gaya', 'Muzaffarpur', 'Bhagalpur',
            'Darbhanga', 'Purnia', 'Ara'],
          'Andhra Pradesh': ['Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore'],
          'Assam': ['Guwahati', 'Silchar', 'Dibrugarh'],
          'Kerala': ['Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur'],
          'Telangana': ['Hyderabad', 'Warangal', 'Nizamabad', 'Khammam']
        },

        init() {
          const saved = sessionStorage.getItem('booking_step');
          if (saved) {
            try {
              const s = JSON.parse(saved);
              this.step = s.step || 1;
              this.pickupState = s.pickupState || '';
              this.pickupCity = s.pickupCity || '';
              this.destState = s.destState || '';
              this.destCity = s.destCity || '';
              this.serviceType = s.serviceType || 'standard';
              this.selectedCarrier = s.selectedCarrier || '';
              this.weightKg = s.weightKg || '';
              this.lengthCm = s.lengthCm || '';
              this.widthCm = s.widthCm || '';
              this.heightCm = s.heightCm || '';
              this.fares = s.fares || {};
            } catch (e) { }
          }
        },

        save() {
          sessionStorage.setItem('booking_step', JSON.stringify({
            step: this.step, pickupState: this.pickupState, pickupCity: this.pickupCity,
            destState: this.destState, destCity: this.destCity, serviceType: this.serviceType,
            selectedCarrier: this.selectedCarrier, weightKg: this.weightKg,
            lengthCm: this.lengthCm, widthCm: this.widthCm, heightCm: this.heightCm,
            fares: this.fares
          }));
        },

        nextStep() {
          const currentPanel = document.querySelectorAll('.step-panel')[this.step - 1];
          const invalidInputs = currentPanel.querySelectorAll(':invalid');
          if (invalidInputs.length > 0) {
            invalidInputs[0].reportValidity();
            return;
          }

          if (this.step === 3 && !this.selectedCarrier) {
            alert('Please select a carrier to continue.');
            return;
          }
          this.step++;
          this.save();
          window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        async fetchFares() {
          if (!this.pickupCity || !this.destCity || !this.weightKg || !this.lengthCm || !this.widthCm || !this.heightCm) return;

          this.loadingFares = true;
          const carriers = <?php echo json_encode($carriers->pluck('id'), 15, 512) ?>;

          const results = {};
          await Promise.all(carriers.map(async (id) => {
            try {
              const res = await fetch('<?php echo e(route("booking.fare")); ?>', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                  'Accept': 'application/json',
                },
                body: JSON.stringify({
                  carrier_id: id,
                  weight_kg: this.weightKg,
                  length_cm: this.lengthCm,
                  width_cm: this.widthCm,
                  height_cm: this.heightCm,
                  pickup_city: this.pickupCity,
                  dest_city: this.destCity,
                  service: this.serviceType,
                })
              });
              const data = await res.json();
              results[id] = data;
            } catch (e) { }
          }));

          this.fares = results;
          this.loadingFares = false;
          this.save();
        }
      };
    }
  </script>
</body>

</html>
<?php /**PATH C:\Users\bhard\Documents\Codex\2026-05-13\build-me-a-full-logistics-delivery\resources\views/customer/book.blade.php ENDPATH**/ ?>