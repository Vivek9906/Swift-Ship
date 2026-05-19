<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StripeController extends Controller
{
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $sessionId = $session->id;

            if ($session->payment_status === 'paid') {
                $payment = Payment::where('stripe_session_id', $sessionId)->first();

                if ($payment && $payment->status !== 'paid') {
                    $payment->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                        'stripe_payment_intent' => $session->payment_intent,
                    ]);

                    $shipment = $payment->shipment;
                    if ($shipment && $shipment->payment_status !== 'paid') {
                        $shipment->update([
                            'status' => 'confirmed',
                            'payment_status' => 'paid',
                            'updated_at' => now(),
                        ]);

                        TrackingEvent::create([
                            'shipment_id' => $shipment->id,
                            'status' => 'confirmed',
                            'location_name' => $shipment->sender_city,
                            'description' => 'Shipment booked and payment confirmed via Stripe webhook.',
                            'occurred_at' => now(),
                        ]);

                        try {
                            Mail::to($shipment->user->email)
                                ->send(new \App\Mail\ShipmentConfirmed($shipment, $payment));
                        } catch (\Throwable $e) {
                            Log::error('Failed to send confirmation email: ' . $e->getMessage());
                        }
                    }
                }
            }
        } elseif ($event->type === 'checkout.session.async_payment_failed') {
            $session = $event->data->object;
            $payment = Payment::where('stripe_session_id', $session->id)->first();
            if ($payment) {
                $payment->update(['status' => 'failed']);
            }
        }

        return response('Webhook handled', 200);
    }
}
