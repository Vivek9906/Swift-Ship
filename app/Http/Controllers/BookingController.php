<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    /** Step 1â€“4: Show multi-step form */
    public function create(): View
    {
        $user = auth()->user();
        $carriers = Carrier::where('is_active', true)->orderBy('name')->get();

        return view('customer.book', compact('user', 'carriers'));
    }

    /** AJAX: Calculate fare for given carrier + weight + distance */
    public function calculateFare(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'carrier_id' => ['required'],
            'weight_kg' => ['required', 'numeric', 'min:0.1', 'max:500'],
            'length_cm' => ['required', 'numeric', 'min:1'],
            'width_cm' => ['required', 'numeric', 'min:1'],
            'height_cm' => ['required', 'numeric', 'min:1'],
            'pickup_city' => ['required', 'string'],
            'dest_city' => ['required', 'string'],
            'service' => ['sometimes', 'string'],
        ]);

        $carrier = Carrier::findOrFail($validated['carrier_id']);

        $dimWeight = ($validated['length_cm'] * $validated['width_cm'] * $validated['height_cm']) / 5000;
        $billable = max((float) $validated['weight_kg'], $dimWeight);

        // Estimated distance using city coordinates (approx)
        $coords = Shipment::CITY_COORDINATES;
        $origin = $coords[$validated['pickup_city']] ?? [20.5937, 78.9629];
        $dest = $coords[$validated['dest_city']] ?? [20.5937, 78.9629];
        $distKm = $this->haversineKm($origin[0], $origin[1], $dest[0], $dest[1]);

        $serviceMultiplier = match ($validated['service'] ?? 'standard') {
            'express' => 1.5,
            'same_day' => 2.2,
            'economy' => 0.8,
            default => 1.0,
        };

        $base_fare = round((float) $carrier->base_rate * $serviceMultiplier, 2);
        $weight_charge = round($billable * (float) $carrier->per_kg_rate * $serviceMultiplier, 2);
        $distance_charge = round($distKm * (float) $carrier->per_km_rate, 2);
        $subtotal = $base_fare + $weight_charge + $distance_charge;
        $gst = round($subtotal * 0.18, 2);
        $total = round($subtotal + $gst, 2);

        // Algorithmic ETA based on Distance & Service Type
        $speedKmPerDay = match ($validated['service'] ?? 'standard') {
            'express' => 800,
            'same_day' => 2000,
            'economy' => 250,
            default => 400, // standard
        };
        $calculatedDays = max(1, ceil($distKm / $speedKmPerDay));
        $estMin = $calculatedDays;
        $estMax = $calculatedDays + ($validated['service'] === 'economy' ? 2 : 1);

        return response()->json([
            'base_fare' => $base_fare,
            'weight_charge' => $weight_charge,
            'distance_charge' => $distance_charge,
            'gst' => $gst,
            'total' => $total,
            'billable_weight' => round($billable, 2),
            'distance_km' => round($distKm, 0),
            'est_days_min' => $estMin,
            'est_days_max' => $estMax,
        ]);
    }

    /** Step 5: Store shipment (after payment or COD) */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sender_name' => ['required', 'string', 'max:100'],
            'sender_phone' => ['required', 'string', 'regex:/^(\+91|91)?[6-9]\d{9}$/'],
            'sender_email' => ['required', 'email'],
            'pickup_address' => ['required', 'string'],
            'pickup_city' => ['required', 'string'],
            'pickup_state' => ['required', 'string'],
            'pickup_pin' => ['required', 'digits:6'],
            'recipient_name' => ['required', 'string', 'max:100'],
            'recipient_phone' => ['required', 'string', 'regex:/^(\+91|91)?[6-9]\d{9}$/'],
            'recipient_email' => ['nullable', 'email'],
            'delivery_address' => ['required', 'string'],
            'delivery_city' => ['required', 'string'],
            'delivery_state' => ['required', 'string'],
            'delivery_pin' => ['required', 'digits:6'],
            'package_type' => ['required', 'string'],
            'weight_kg' => ['required', 'numeric', 'min:0.1', 'max:500'],
            'length_cm' => ['required', 'numeric', 'min:1'],
            'width_cm' => ['required', 'numeric', 'min:1'],
            'height_cm' => ['required', 'numeric', 'min:1'],
            'declared_value' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1'],
            'special_instructions' => ['nullable', 'string', 'max:500'],
            'is_dangerous' => ['boolean'],
            'carrier_id' => ['required'],
            'service_type' => ['required', 'string'],
            'payment_method' => ['required', 'string', 'in:razorpay,cod,bank_transfer'],
        ], [
            'sender_phone.regex' => 'Sender phone must be a valid Indian mobile number.',
            'recipient_phone.regex' => 'Recipient phone must be a valid Indian mobile number.',
            'pickup_pin.digits' => 'Pickup PIN must be exactly 6 digits.',
            'delivery_pin.digits' => 'Delivery PIN must be exactly 6 digits.',
        ]);

        $user = auth()->user();
        $carrier = Carrier::findOrFail($validated['carrier_id']);

        // Re-calculate fare server-side (never trust client)
        $fare = $this->computeFare($carrier, $validated);

        $trackingNumber = 'IND' . now()->format('ymd') . Str::upper(Str::random(6));

        // Get sender_city from pickup_city
        $senderCity = $validated['pickup_city'];
        $receiverCity = $validated['delivery_city'];

        [$lat, $lng] = Shipment::CITY_COORDINATES[$senderCity] ?? [20.5937, 78.9629];

        $senderPhone = $validated['sender_phone'];
        if (preg_match('/^(\+91|91)?([6-9]\d{9})$/', $senderPhone, $matches)) {
            $senderPhone = '+91' . $matches[2];
        }

        $recipientPhone = $validated['recipient_phone'];
        if (preg_match('/^(\+91|91)?([6-9]\d{9})$/', $recipientPhone, $matches)) {
            $recipientPhone = '+91' . $matches[2];
        }

        $shipment = Shipment::create([
            'tracking_number' => $trackingNumber,
            'user_id' => $user->id,
            'carrier_id' => $carrier->id,
            'sender_name' => $validated['sender_name'],
            'sender_phone' => $senderPhone,
            'sender_email' => $validated['sender_email'],
            'sender_city' => $senderCity,
            'pickup_address' => $validated['pickup_address'],
            'pickup_city' => $senderCity,
            'pickup_state' => $validated['pickup_state'],
            'pickup_pin' => $validated['pickup_pin'],
            'receiver_name' => $validated['recipient_name'],
            'recipient_phone' => $recipientPhone,
            'recipient_email' => $validated['recipient_email'],
            'receiver_city' => $receiverCity,
            'receiver_address' => $validated['delivery_address'],
            'delivery_city' => $receiverCity,
            'delivery_state' => $validated['delivery_state'],
            'delivery_pin' => $validated['delivery_pin'],
            'package_type' => $validated['package_type'],
            'weight' => $validated['weight_kg'],
            'dimensions' => $validated['length_cm'] . 'x' . $validated['width_cm'] . 'x' . $validated['height_cm'],
            'declared_value' => $validated['declared_value'],
            'quantity' => $validated['quantity'],
            'special_instructions' => $validated['special_instructions'],
            'is_dangerous' => (bool) ($validated['is_dangerous'] ?? false),
            'service_type' => $validated['service_type'],
            'base_fare' => $fare['base_fare'],
            'weight_charge' => $fare['weight_charge'],
            'distance_charge' => $fare['distance_charge'],
            'gst_amount' => $fare['gst'],
            'cost' => $fare['total'],
            'status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending',
            'payment_status' => $validated['payment_method'] === 'razorpay' ? 'pending' : 'cod_pending',
            'current_lat' => $lat,
            'current_lng' => $lng,
            'estimated_delivery' => now()->addDays($fare['est_days'] ?? 3),
        ]);

        // Create payment record
        Payment::create([
            'shipment_id' => $shipment->id,
            'amount' => $fare['total'],
            'currency' => 'INR',
            'method' => $validated['payment_method'],
            'status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending',
        ]);

        // Create first tracking event
        TrackingEvent::create([
            'shipment_id' => $shipment->id,
            'status' => 'pending',
            'location_name' => $senderCity,
            'description' => 'Shipment booked and confirmed.',
            'occurred_at' => now(),
        ]);

        if ($validated['payment_method'] === 'razorpay') {
            session(['pending_shipment_id' => $shipment->id]);
            return redirect()->route('customer.shipments.pay');
        }

        // Send confirmation email
        try {
            Mail::to($user->email)->send(new \App\Mail\ShipmentConfirmed($shipment, Payment::where('shipment_id', $shipment->id)->first()));
        } catch (\Throwable) {
        }

        return redirect()->route('customer.shipments.confirmation', $shipment->id)
            ->with('success', 'Shipment booked successfully!');
    }

    public function pay(): View
    {
        $shipment = Shipment::where('id', session('pending_shipment_id'))
            ->where('user_id', auth()->id())
            ->where('payment_status', 'pending')
            ->firstOrFail();

        return view('customer.pay', compact('shipment'));
    }

    public function stripeCheckout(Request $request): RedirectResponse
    {
        $shipment = Shipment::where('id', session('pending_shipment_id'))
            ->where('user_id', auth()->id())
            ->where('payment_status', 'pending')
            ->firstOrFail();

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => 'Shipment ' . $shipment->tracking_number,
                    ],
                    'unit_amount' => (int)($shipment->cost * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('customer.shipments.stripe-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('customer.shipments.pay'),
        ]);

        Payment::updateOrCreate(
            ['shipment_id' => $shipment->id],
            [
                'user_id' => auth()->id(),
                'amount' => $shipment->cost,
                'currency' => 'INR',
                'stripe_session_id' => $session->id,
                'transaction_id' => $session->id,
                'gateway' => 'stripe',
                'status' => 'pending',
                'payment_method' => 'card',
            ]
        );

        return redirect()->away($session->url);
    }

    public function stripeSuccess(Request $request): RedirectResponse
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            abort(404);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            $payment = Payment::where('stripe_session_id', $sessionId)->firstOrFail();
            
            if ($payment->status !== 'paid') {
                $payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'stripe_payment_intent' => $session->payment_intent,
                ]);

                $shipment = $payment->shipment;
                $shipment->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'updated_at' => now(),
                ]);

                TrackingEvent::create([
                    'shipment_id' => $shipment->id,
                    'status' => 'confirmed',
                    'location_name' => $shipment->sender_city,
                    'description' => 'Shipment booked and payment confirmed via Stripe.',
                    'occurred_at' => now(),
                ]);

                try {
                    Mail::to(auth()->user()->email)
                        ->send(new \App\Mail\ShipmentConfirmed($shipment, $payment));
                } catch (\Throwable) {
                }
            }

            session()->forget('pending_shipment_id');
            return redirect()->route('customer.dashboard', ['booked' => $payment->shipment->tracking_number]);
        }

        return redirect()->route('customer.dashboard')->with('error', 'Payment not verified.');
    }

    public function confirmation(string $id): View
    {
        $shipment = Shipment::with(['carrier'])->findOrFail($id);

        // Ensure only owner can view
        abort_unless($shipment->user_id == auth()->id(), 403);

        return view('customer.confirmation', compact('shipment'));
    }

    private function computeFare(Carrier $carrier, array $data): array
    {
        $dimWeight = ($data['length_cm'] * $data['width_cm'] * $data['height_cm']) / 5000;
        $billable = max((float) $data['weight_kg'], $dimWeight);

        $coords = Shipment::CITY_COORDINATES;
        $origin = $coords[$data['pickup_city']] ?? [20.5937, 78.9629];
        $dest = $coords[$data['delivery_city']] ?? [20.5937, 78.9629];
        $distKm = $this->haversineKm($origin[0], $origin[1], $dest[0], $dest[1]);

        $mul = match ($data['service_type']) {
            'express' => 1.5,
            'same_day' => 2.2,
            'economy' => 0.8,
            default => 1.0,
        };

        $base_fare = round((float) $carrier->base_rate * $mul, 2);
        $weight_charge = round($billable * (float) $carrier->per_kg_rate * $mul, 2);
        $distance_charge = round($distKm * (float) $carrier->per_km_rate, 2);
        $subtotal = $base_fare + $weight_charge + $distance_charge;
        $gst = round($subtotal * 0.18, 2);

        $speedKmPerDay = match ($data['service_type']) {
            'express' => 800,
            'same_day' => 2000,
            'economy' => 250,
            default => 400, // standard
        };
        $estDays = max(1, ceil($distKm / $speedKmPerDay));

        return [
            'base_fare' => $base_fare,
            'weight_charge' => $weight_charge,
            'distance_charge' => $distance_charge,
            'gst' => $gst,
            'total' => round($subtotal + $gst, 2),
            'est_days' => $estDays,
        ];
    }

    public function simulatePaymentSuccess(Request $request): RedirectResponse
    {
        $shipmentId = session('pending_shipment_id');
        if (!$shipmentId) {
            return redirect()->route('customer.dashboard')->with('error', 'No pending shipment found.');
        }

        $shipment = Shipment::findOrFail($shipmentId);
        $payment = Payment::where('shipment_id', $shipment->id)->first();

        if ($payment) {
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
                'gateway' => 'swiftpay',
                'transaction_id' => 'TXN' . strtoupper(Str::random(12)),
            ]);
        }

        $shipment->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'updated_at' => now(),
        ]);

        TrackingEvent::create([
            'shipment_id' => $shipment->id,
            'status' => 'confirmed',
            'location_name' => $shipment->sender_city,
            'description' => 'Shipment booked and payment confirmed via SwiftPay Local Gateway.',
            'occurred_at' => now(),
        ]);

        try {
            Mail::to(auth()->user()->email)
                ->send(new \App\Mail\ShipmentConfirmed($shipment, $payment));
        } catch (\Throwable) {
        }

        session()->forget('pending_shipment_id');

        return redirect()->route('customer.dashboard', ['booked' => $shipment->tracking_number])
            ->with('success', 'Payment successful! Your shipment is now confirmed and tracking is active.');
    }

    public function resumePayment(string $id): RedirectResponse
    {
        $shipment = Shipment::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('payment_status', 'pending')
            ->firstOrFail();

        session(['pending_shipment_id' => $shipment->id]);
        return redirect()->route('customer.shipments.pay');
    }

    private function haversineKm(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $R = 6371;
        $dL = deg2rad($lat2 - $lat1);
        $dO = deg2rad($lon2 - $lon1);
        $a = sin($dL / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dO / 2) ** 2;
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}

