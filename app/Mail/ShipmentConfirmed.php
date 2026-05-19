<?php
namespace App\Mail;

use App\Models\Shipment;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class ShipmentConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Shipment $shipment;
    public Payment $payment;

    public function __construct(Shipment $shipment, Payment $payment)
    {
        $this->shipment = $shipment;
        $this->payment  = $payment;
    }

    public function build()
    {
        return $this
            ->subject('Shipment Confirmed — ' 
                     . $this->shipment->tracking_number 
                     . ' | SwiftShip')
            ->view('emails.shipment-confirmed');
    }
}
