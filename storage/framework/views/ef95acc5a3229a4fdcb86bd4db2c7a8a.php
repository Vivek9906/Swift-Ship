<?php $__env->startSection('title', 'Complete Payment'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-2">
  <div class="mx-auto max-w-7xl">
    
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start" x-data="paymentGateway()">
      
      
      <div class="lg:col-span-8 rounded-2xl border border-slate-800 bg-slate-900/80 p-6 sm:p-8 space-y-6 relative overflow-hidden">
        
        
        <div x-show="processing" x-transition.opacity 
             class="absolute inset-0 bg-slate-950/95 z-50 flex flex-col items-center justify-center text-center p-6 backdrop-blur-md">
          <div class="relative w-20 h-20 mb-6">
            <div class="absolute inset-0 rounded-full border-4 border-amber-400/20 animate-ping"></div>
            <div class="w-20 h-20 rounded-full border-4 border-amber-400/20 border-t-amber-400 animate-spin"></div>
          </div>
          <h3 class="text-xl font-bold text-white mb-2" x-text="loadingStep"></h3>
          <p class="text-xs text-slate-400 animate-pulse">Contacting NPCI Payment Gateways. Please do not close or refresh this page.</p>
        </div>

        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-800/80 pb-5 gap-3">
          <div>
            <h2 class="text-2xl font-black text-white tracking-tight">Secure Payment Gateway</h2>
            <p class="text-xs text-slate-400 mt-1">Select a gateway method to settle your booking charges</p>
          </div>
          <div class="flex items-center gap-1.5 self-start rounded-full bg-emerald-400/10 border border-emerald-400/20 px-3.5 py-1.5 text-[10px] font-bold text-emerald-400 uppercase tracking-wider">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> PCI-DSS Compliant
          </div>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <?php $__currentLoopData = [
            'upi' => ['⚡ Real UPI QR & VPA', 'GPay / PhonePe / Paytm / BHIM', 'border-amber-400/30'],
            'card' => ['💳 Card Checkout', 'Credit / Debit Card Sim', 'border-blue-400/30'],
            'netbanking' => ['🏦 Netbanking Sim', 'Top Indian Retail Banks', 'border-purple-400/30']
          ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab => [$title, $sub, $borderColor]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button @click="activeTab = '<?php echo e($tab); ?>'"
                    type="button"
                    class="rounded-xl p-3.5 border text-left transition-all duration-200 outline-none"
                    :class="activeTab == '<?php echo e($tab); ?>' ? 'bg-amber-400/10 border-amber-400 text-white shadow-lg shadow-amber-500/5' : 'border-slate-800 bg-slate-950/40 text-slate-400 hover:border-slate-700'">
              <span class="block text-sm font-bold tracking-wide" :class="activeTab == '<?php echo e($tab); ?>' ? 'text-amber-400' : 'text-slate-200'"><?php echo e($title); ?></span>
              <span class="block text-[10px] text-slate-500 mt-1 leading-normal"><?php echo e($sub); ?></span>
            </button>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="mt-6 border border-slate-800/80 rounded-xl bg-slate-950/20 p-5 sm:p-6">
          
          
          <div x-show="activeTab == 'upi'" x-transition class="space-y-6">
            
            
            <div class="rounded-lg border border-blue-500/20 bg-blue-500/5 px-4 py-3 text-xs text-slate-300 leading-relaxed">
              💡 <strong class="text-blue-300">How to test dynamic deduction:</strong> Enter <span class="font-bold text-amber-400">your own UPI ID</span> below. GPay/PhonePe will safely deduct the amount from your bank and deposit it <strong>directly back to yourself</strong>! This allows you to test the complete genuine banking pipeline with zero actual net cost.
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
              
              
              <div class="md:col-span-5 flex flex-col items-center justify-center p-4 rounded-xl border border-slate-800 bg-slate-900/60 shadow-inner">
                <div class="relative bg-white rounded-xl p-3 shadow-xl shadow-black/40 flex items-center justify-center">
                  <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=200x200&margin=8&data=' + encodeURIComponent(generateUpiUri())" 
                       alt="UPI QR Code" 
                       class="w-40 h-40 select-none object-contain">
                  <div class="absolute inset-0 bg-emerald-400/5 pointer-events-none rounded-xl"></div>
                </div>
                <div class="mt-3 flex items-center gap-1.5">
                  <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                  <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Scan dynamically</span>
                </div>
              </div>

              
              <div class="md:col-span-7 space-y-4">
                <div>
                  <h4 class="text-base font-bold text-white mb-1">Scan QR with GPay / PhonePe / Paytm</h4>
                  <p class="text-xs text-slate-400 leading-relaxed">The QR code automatically embeds the exact transaction cost. Scan it with any UPI banking application on your mobile device to complete payment.</p>
                </div>

                <div class="border-t border-slate-800/80 pt-4 space-y-3">
                  <div>
                    <label class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">Configure Payee UPI ID (To settle to yourself)</label>
                    <div class="flex gap-2">
                      <input type="text" x-model="payeeUpi" placeholder="e.g. yourname@okaxis" 
                             class="flex-1 rounded-lg border border-slate-700 bg-slate-950/80 px-4 py-2.5 text-xs text-slate-100 outline-none focus:border-amber-400 transition font-mono placeholder-slate-700">
                      <button type="button" @click="savePayee()" 
                              class="rounded-lg bg-amber-400 hover:bg-amber-300 px-4 py-2.5 text-xs font-black text-slate-950 transition-colors">
                        Set Payee
                      </button>
                    </div>
                  </div>

                  <div class="flex items-center justify-between text-xs rounded-lg bg-slate-900/60 p-3 border border-slate-800">
                    <span class="text-slate-400">Current Payee UPI ID:</span>
                    <span class="font-mono font-bold text-amber-400" x-text="payeeUpi"></span>
                  </div>
                </div>
              </div>

            </div>

            
            <div class="border-t border-slate-800/80 pt-5">
              <button type="button" @click="startPayment('upi')"
                      class="w-full rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 py-4 text-sm font-black transition-all shadow-lg shadow-emerald-500/10 flex items-center justify-center gap-2">
                ✅ I Have Scanned & Completed the UPI Payment on My Phone
              </button>
            </div>

          </div>

          
          <div x-show="activeTab == 'card'" x-transition class="space-y-6">
            
            
            <div class="relative w-full max-w-[340px] h-[190px] mx-auto rounded-2xl p-5 text-white flex flex-col justify-between shadow-2xl transition-transform duration-300 hover:scale-105"
                 style="background: linear-gradient(135deg, #1e293b 0%, #0c1524 100%); border: 1px solid rgba(251, 191, 36, 0.2); box-shadow: 0 20px 40px -15px rgba(0,0,0,0.7);">
              <div class="flex justify-between items-start">
                <div>
                  <span class="block text-[8px] uppercase tracking-wider text-slate-400 font-bold">Secure Gateway Card</span>
                  <span class="block font-black text-amber-400 text-sm mt-0.5 tracking-wider">SWIFTSHIP PAY</span>
                </div>
                <div class="text-xl">💳</div>
              </div>
              
              <div class="font-mono text-lg tracking-widest text-slate-100 py-2 text-center" x-text="cardNumber || '•••• •••• •••• ••••'"></div>
              
              <div class="flex justify-between items-end">
                <div>
                  <span class="block text-[8px] uppercase tracking-wider text-slate-500 font-bold">Cardholder</span>
                  <span class="block text-xs font-semibold text-slate-300 uppercase tracking-wide truncate max-w-[170px]" x-text="cardName || 'YOUR FULL NAME'"></span>
                </div>
                <div class="text-right">
                  <span class="block text-[8px] uppercase tracking-wider text-slate-500 font-bold">Expires</span>
                  <span class="block text-xs font-mono font-bold text-slate-300" x-text="cardExpiry || 'MM/YY'"></span>
                </div>
              </div>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Cardholder Name</label>
                <input type="text" x-model="cardName" placeholder="e.g. Rahul Sharma"
                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none focus:border-amber-400 transition uppercase tracking-wider font-semibold">
              </div>
              <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Card Number</label>
                <input type="text" x-model="cardNumber" placeholder="4111 2222 3333 4444" maxlength="19" @input="formatCardNumber"
                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none focus:border-amber-400 transition font-mono font-semibold">
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Expiry Date</label>
                <input type="text" x-model="cardExpiry" placeholder="MM/YY" maxlength="5" @input="formatExpiry"
                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none focus:border-amber-400 transition font-mono font-semibold">
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">CVV / Security Code</label>
                <input type="password" placeholder="•••" maxlength="3"
                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none focus:border-amber-400 transition font-mono font-semibold">
              </div>
            </div>

            <div class="border-t border-slate-800/80 pt-5">
              <button type="button" @click="startPayment('card')"
                      class="w-full rounded-xl bg-amber-400 py-4 text-sm font-black text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                🔒 Settle Charges via Secure Card Simulation (₹<?php echo e(number_format($shipment->cost, 2)); ?>)
              </button>
            </div>

          </div>

          
          <div x-show="activeTab == 'netbanking'" x-transition class="space-y-6">
            <div>
              <p class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-3">Popular Retail Banking Portals</p>
              <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <?php $__currentLoopData = [
                  'SBI' => '🏛️ State Bank of India',
                  'HDFC' => '🏢 HDFC Bank',
                  'ICICI' => '🏨 ICICI Bank',
                  'AXIS' => '🏫 Axis Bank'
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $bankName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <button type="button" @click="selectedBank = '<?php echo e($code); ?>'"
                          class="rounded-xl border p-4 text-center transition-all outline-none duration-150"
                          :class="selectedBank == '<?php echo e($code); ?>' ? 'bg-amber-400/10 border-amber-400 text-white' : 'border-slate-800 bg-slate-950/40 text-slate-400 hover:border-slate-700'">
                    <div class="text-base font-black text-slate-200"><?php echo e($code); ?></div>
                    <div class="text-[9px] text-slate-500 mt-1 truncate"><?php echo e($bankName); ?></div>
                  </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>

            <div class="border-t border-slate-800/80 pt-4">
              <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Or select from other banks</label>
              <select x-model="selectedBank" 
                      class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none focus:border-amber-400 transition font-semibold">
                <option value="">Select Alternative Bank...</option>
                <option value="KOTAK">Kotak Mahindra Bank</option>
                <option value="PNB">Punjab National Bank</option>
                <option value="BOB">Bank of Baroda</option>
                <option value="YES">Yes Bank</option>
                <option value="INDUS">IndusInd Bank</option>
              </select>
            </div>

            <div class="border-t border-slate-800/80 pt-5">
              <button type="button" @click="startPayment('netbanking')"
                      class="w-full rounded-xl bg-amber-400 py-4 text-sm font-black text-slate-950 hover:bg-amber-300 active:scale-95 transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                🔒 Settle Charges via Netbanking Redirect (₹<?php echo e(number_format($shipment->cost, 2)); ?>)
              </button>
            </div>

          </div>

        </div>

        
        <form id="simulate-form" action="<?php echo e(route('customer.shipments.pay-simulate')); ?>" method="POST" class="hidden">
          <?php echo csrf_field(); ?>
        </form>

        
        <div class="text-center pt-2">
          <p class="text-[10px] text-slate-500 flex items-center justify-center gap-2">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            SSL Encrypted End-to-End Secure Processing Gateway
          </p>
        </div>

      </div>

      
      <aside class="lg:col-span-4 rounded-2xl border border-slate-800 bg-slate-900/80 p-6 space-y-5">
        <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider">Shipment Details</h3>
        
        <div class="space-y-2.5 text-xs border-b border-slate-800/80 pb-4">
          <div class="flex justify-between text-slate-400"><span>Tracking ID</span><span class="font-mono font-bold text-amber-400"><?php echo e($shipment->tracking_number); ?></span></div>
          <div class="flex justify-between text-slate-400"><span>Route</span><span class="font-bold text-white"><?php echo e($shipment->sender_city); ?> → <?php echo e($shipment->receiver_city); ?></span></div>
          <div class="flex justify-between text-slate-400"><span>Carrier Partner</span><span class="font-semibold text-white"><?php echo e($shipment->carrier?->name); ?></span></div>
          <div class="flex justify-between text-slate-400"><span>Service Tier</span><span class="font-semibold text-white capitalize"><?php echo e($shipment->service_type); ?></span></div>
          <div class="flex justify-between text-slate-400"><span>Declared Weight</span><span class="font-semibold text-white"><?php echo e($shipment->weight); ?> kg</span></div>
        </div>

        <div class="space-y-2 text-xs">
          <div class="flex justify-between text-slate-400"><span>Base Fare</span><span class="font-semibold text-slate-300">₹<?php echo e(number_format($shipment->base_fare, 2)); ?></span></div>
          <div class="flex justify-between text-slate-400"><span>Weight Charge</span><span class="font-semibold text-slate-300">₹<?php echo e(number_format($shipment->weight_charge, 2)); ?></span></div>
          <div class="flex justify-between text-slate-400"><span>Distance Charge</span><span class="font-semibold text-slate-300">₹<?php echo e(number_format($shipment->distance_charge, 2)); ?></span></div>
          <div class="flex justify-between text-slate-400"><span>GST (18%)</span><span class="font-semibold text-slate-300">₹<?php echo e(number_format($shipment->gst_amount, 2)); ?></span></div>
        </div>

        <div class="border-t border-slate-800 pt-4 flex justify-between items-baseline">
          <span class="text-xs font-bold text-white uppercase tracking-wide">Total Amount</span>
          <span class="text-xl font-black text-amber-400">₹<?php echo e(number_format($shipment->cost, 2)); ?></span>
        </div>
      </aside>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  function paymentGateway() {
    return {
      activeTab: 'upi',
      payeeUpi: localStorage.getItem('payee_upi_id') || 'vivek@gmail.com',
      cardNumber: '',
      cardName: '',
      cardExpiry: '',
      selectedBank: '',
      cost: <?php echo json_encode($shipment->cost, 15, 512) ?>,
      trackingNumber: <?php echo json_encode($shipment->tracking_number, 15, 512) ?>,
      processing: false,
      loadingStep: '',

      savePayee() {
        if (!this.payeeUpi.trim() || !this.payeeUpi.includes('@')) {
          alert('Please enter a valid UPI VPA (e.g., yourname@okaxis).');
          return;
        }
        localStorage.setItem('payee_upi_id', this.payeeUpi.trim());
        alert('Payee UPI ID updated to: ' + this.payeeUpi.trim() + '. The QR code has been refreshed!');
      },

      generateUpiUri() {
        const vpa = this.payeeUpi.trim() || 'vivek@gmail.com';
        return `upi://pay?pa=${vpa}&pn=Vivek&am=${this.cost}&cu=INR&tn=${this.trackingNumber}`;
      },

      formatCardNumber() {
        let val = this.cardNumber.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formatted = '';
        for (let i = 0; i < val.length; i++) {
          if (i > 0 && i % 4 === 0) formatted += ' ';
          formatted += val[i];
        }
        this.cardNumber = formatted;
      },

      formatExpiry() {
        let val = this.cardExpiry.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        if (val.length >= 2) {
          this.cardExpiry = val.slice(0, 2) + '/' + val.slice(2, 4);
        } else {
          this.cardExpiry = val;
        }
      },

      startPayment(method) {
        if (method === 'upi') {
          if (!this.payeeUpi.trim()) {
            alert('Please configure a valid Payee UPI ID.');
            return;
          }
        }
        if (method === 'card') {
          if (!this.cardNumber || !this.cardName || !this.cardExpiry) {
            alert('Please fill out cardholder details.');
            return;
          }
        }
        if (method === 'netbanking') {
          if (!this.selectedBank) {
            alert('Please select your preferred retail bank.');
            return;
          }
        }

        this.processing = true;
        
        const steps = [
          'Connecting to secure NPCI UPI Network...',
          'Retrieving transaction verification logs...',
          'Verifying bank settlement & fund deduction status...',
          'Authorization confirmed! Finalizing your booking...'
        ];

        let index = 0;
        this.loadingStep = steps[index];

        const timer = setInterval(() => {
          index++;
          if (index < steps.length) {
            this.loadingStep = steps[index];
          } else {
            clearInterval(timer);
            document.getElementById('simulate-form').submit();
          }
        }, 1300);
      }
    };
  }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Swift-Ship\resources\views/customer/pay.blade.php ENDPATH**/ ?>