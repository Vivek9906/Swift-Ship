

<?php $__env->startSection('title', 'Live Tracking Map'); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid gap-4 xl:grid-cols-[360px_1fr]" x-data="liveMap()" x-init="init()">
        <aside class="ops-panel rounded-lg p-4">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-semibold">Live Shipments</h2>
                <span class="font-mono text-xs text-emerald-300" x-text="`${shipments.length} ACTIVE`"></span>
            </div>
            <div class="grid gap-3">
                <select x-model="filters.carrier_id" @change="load()" class="ops-input">
                    <option value="">All carriers</option>
                    <?php $__currentLoopData = $carriers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($carrier->id); ?>"><?php echo e($carrier->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select x-model="filters.status" @change="load()" class="ops-input">
                    <option value="">All statuses</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status); ?>"><?php echo e(str($status)->headline()); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select x-model="filters.city" @change="load()" class="ops-input">
                    <option value="">All regions</option>
                    <?php $__currentLoopData = array_keys($cities); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($city); ?>"><?php echo e($city); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="mt-5 max-h-[calc(100vh-260px)] space-y-3 overflow-y-auto pr-1">
                <template x-for="shipment in shipments" :key="shipment.id">
                    <button class="w-full rounded border border-slate-800 p-3 text-left transition hover:bg-slate-800/60"
                        @click="focus(shipment)">
                        <span class="font-mono text-xs text-blue-200" x-text="shipment.tracking_number"></span>
                        <span class="mt-1 block text-sm font-semibold" x-text="shipment.user"></span>
                        <span class="mt-1 block text-xs text-slate-400"
                            x-text="`${shipment.origin} → ${shipment.destination} · ${shipment.eta}`"></span>
                    </button>
                </template>
            </div>
        </aside>

        <section class="ops-panel overflow-hidden rounded-lg">
            <div id="liveMap" class="h-[calc(100vh-128px)] min-h-[580px]"></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function liveMap() {
            return {
                map: null,
                markers: {},
                shipments: [],
                filters: { carrier_id: '', status: '', city: '' },
                init() {
                    this.map = L.map('liveMap').setView([22.5, 79.2], 5);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(this.map);
                    this.load();
                    setInterval(() => this.load(), 15000);
                },
                async load() {
                    const query = new URLSearchParams(Object.fromEntries(Object.entries(this.filters).filter(([, value]) => value)));
                    const response = await fetch(`<?php echo e(route('tracking.active')); ?>?${query}`);
                    this.shipments = await response.json();
                    this.syncMarkers();
                },
                syncMarkers() {
                    Object.values(this.markers).forEach(marker => marker.remove());
                    this.markers = {};
                    this.shipments.forEach((shipment, index) => {
                        const marker = L.circleMarker([shipment.lat, shipment.lng], {
                            radius: 7,
                            color: shipment.status === 'delayed' ? '#f97316' : '#3b82f6',
                            fillColor: shipment.status === 'out_for_delivery' ? '#f59e0b' : '#38bdf8',
                            fillOpacity: 0.85,
                        }).addTo(this.map);
                        marker.bindPopup(`<strong>${shipment.tracking_number}</strong><br>${shipment.user}<br>${shipment.status_label}<br>ETA ${shipment.eta}`);
                        this.markers[shipment.id] = marker;
                        setTimeout(() => marker.setRadius(10), index * 90);
                        setTimeout(() => marker.setRadius(7), index * 90 + 500);
                    });
                },
                focus(shipment) {
                    const marker = this.markers[shipment.id];
                    if (!marker) return;
                    this.map.setView(marker.getLatLng(), 8);
                    marker.openPopup();
                }
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Swift-Ship\resources\views/tracking/live-map.blade.php ENDPATH**/ ?>