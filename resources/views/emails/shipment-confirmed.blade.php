<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; }
    .container { max-width: 600px; margin: 30px auto; 
                 background: #ffffff; border-radius: 12px; 
                 overflow: hidden; }
    .header { background: #0F172A; padding: 30px; text-align: center; }
    .header h1 { color: #F59E0B; margin: 0; font-size: 28px; }
    .header p { color: #94A3B8; margin: 5px 0 0; }
    .body { padding: 32px; }
    .shipment-id { background: #FEF3C7; border: 2px solid #F59E0B;
                   border-radius: 8px; padding: 16px; 
                   text-align: center; margin: 20px 0; }
    .shipment-id span { font-size: 24px; font-weight: bold; 
                        color: #92400E; letter-spacing: 2px; }
    .info-row { display: flex; justify-content: space-between;
                padding: 10px 0; border-bottom: 1px solid #E5E7EB; }
    .info-row:last-child { border-bottom: none; }
    .label { color: #6B7280; font-size: 14px; }
    .value { color: #111827; font-weight: 500; }
    .fare-table { width: 100%; border-collapse: collapse; 
                  margin: 20px 0; }
    .fare-table td { padding: 8px 12px; }
    .fare-table .total-row td { font-weight: bold; 
                                 border-top: 2px solid #E5E7EB;
                                 font-size: 16px; }
    .cta-btn { display: block; width: fit-content; 
               margin: 24px auto; padding: 14px 32px;
               background: #F59E0B; color: #000; 
               text-decoration: none; border-radius: 8px; 
               font-weight: bold; font-size: 16px; }
    .footer { background: #F9FAFB; padding: 20px; 
              text-align: center; color: #6B7280; font-size: 13px; }
  </style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>SwiftShip</h1>
    <p>Your shipment has been confirmed</p>
  </div>
  <div class="body">
    <p>Hi {{ $shipment->sender_name }},</p>
    <p>Great news! Your shipment has been successfully booked 
       and payment confirmed. Here are your details:</p>

    <div class="shipment-id">
      <div style="color:#6B7280;font-size:13px;margin-bottom:6px">
        YOUR SHIPMENT ID
      </div>
      <span>{{ $shipment->tracking_number }}</span>
    </div>

    <div class="info-row">
      <span class="label">From</span>
      <span class="value">
        {{ $shipment->pickup_city }}, {{ $shipment->pickup_state }}
      </span>
    </div>
    <div class="info-row">
      <span class="label">To</span>
      <span class="value">
        {{ $shipment->delivery_city }}, {{ $shipment->delivery_state }}
      </span>
    </div>
    <div class="info-row">
      <span class="label">Recipient</span>
      <span class="value">{{ $shipment->receiver_name }}</span>
    </div>
    <div class="info-row">
      <span class="label">Carrier</span>
      <span class="value">{{ $shipment->carrier->name ?? 'N/A' }}</span>
    </div>
    <div class="info-row">
      <span class="label">Service Type</span>
      <span class="value">{{ ucfirst($shipment->service_type) }}</span>
    </div>
    <div class="info-row">
      <span class="label">Estimated Delivery</span>
      <span class="value">
        {{ $shipment->estimated_delivery ? \Carbon\Carbon::parse($shipment->estimated_delivery)->format('D, d M Y') : 'Pending' }}
      </span>
    </div>
    <div class="info-row">
      <span class="label">Package Weight</span>
      <span class="value">{{ $shipment->weight }} kg</span>
    </div>

    <h3 style="margin-top:24px">Payment Summary</h3>
    <table class="fare-table">
      <tr>
        <td class="label">Base Fare</td>
        <td style="text-align:right">
          ₹{{ number_format($shipment->base_fare, 2) }}
        </td>
      </tr>
      <tr>
        <td class="label">Weight Charges</td>
        <td style="text-align:right">
          ₹{{ number_format($shipment->weight_charge, 2) }}
        </td>
      </tr>
      <tr>
        <td class="label">Distance Charges</td>
        <td style="text-align:right">
          ₹{{ number_format($shipment->distance_charge, 2) }}
        </td>
      </tr>
      <tr>
        <td class="label">GST (18%)</td>
        <td style="text-align:right">
          ₹{{ number_format($shipment->gst_amount, 2) }}
        </td>
      </tr>
      <tr class="total-row">
        <td>Total Paid</td>
        <td style="text-align:right;color:#F59E0B">
          ₹{{ number_format($payment->amount, 2) }}
        </td>
      </tr>
    </table>

    <p style="color:#6B7280;font-size:14px">
      Payment ID: {{ $payment->razorpay_payment_id }}
    </p>

    <a href="{{ url('/track/' . $shipment->tracking_number) }}" 
       class="cta-btn">
      Track Your Shipment →
    </a>

    <p style="color:#6B7280;font-size:13px;margin-top:24px">
      Need help? Email us at 
      <a href="mailto:ops@swiftship.in">ops@swiftship.in</a> 
      or call 1800-SHIP-NOW (toll free).
    </p>
  </div>
  <div class="footer">
    © {{ date('Y') }} SwiftShip. All rights reserved.<br>
    Mumbai HQ · Pan-India Network
  </div>
</div>
</body>
</html>
