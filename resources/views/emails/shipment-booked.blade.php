<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shipment Confirmed | SwiftShip</title>
  <style>
    body { margin:0;padding:0;background:#f1f5f9;font-family:Inter,Arial,sans-serif; }
    .wrap { max-width:600px;margin:32px auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .header { background:#0f172a;padding:28px 32px;text-align:center; }
    .logo-icon { display:inline-block;width:44px;height:44px;background:#f59e0b;border-radius:10px;line-height:44px;font-weight:900;font-size:16px;color:#0f172a;font-family:monospace; }
    .logo-text { font-size:22px;font-weight:800;color:#fff;vertical-align:middle;margin-left:10px; }
    .logo-text span { color:#f59e0b; }
    .body { padding:32px; }
    .tracking-box { background:#0f172a;border-radius:10px;padding:20px 24px;text-align:center;margin-bottom:24px; }
    .tracking-label { font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#64748b;margin-bottom:6px; }
    .tracking-id { font-size:22px;font-weight:900;color:#f59e0b;font-family:monospace;letter-spacing:.05em; }
    .row { display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px; }
    .row:last-child { border-bottom:none; }
    .row-label { color:#64748b;font-weight:500; }
    .row-value { color:#0f172a;font-weight:600;text-align:right; }
    .fare-box { background:#fefce8;border:1px solid #fde68a;border-radius:8px;padding:16px 20px;margin:20px 0; }
    .fare-row { display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px;color:#713f12; }
    .fare-total { display:flex;justify-content:space-between;font-size:16px;font-weight:700;color:#0f172a;border-top:2px solid #fde68a;padding-top:10px;margin-top:10px; }
    .cta { display:block;background:#f59e0b;color:#0f172a;font-weight:700;font-size:15px;padding:14px;border-radius:10px;text-decoration:none;text-align:center;margin:20px 0; }
    .footer { background:#f8fafc;border-top:1px solid #e2e8f0;padding:16px 32px;text-align:center; }
    .footer p { font-size:12px;color:#94a3b8;margin:0; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="header">
      <span class="logo-icon">SS</span>
      <span class="logo-text">Swift<span>Ship</span></span>
    </div>
    <div class="body">
      <p style="font-size:16px;color:#0f172a;font-weight:700;margin-bottom:20px;">✅ Your shipment has been confirmed!</p>
      <div class="tracking-box">
        <div class="tracking-label">Tracking Number</div>
        <div class="tracking-id">{{ $shipment->tracking_number }}</div>
      </div>
      <div class="row"><span class="row-label">Carrier</span><span class="row-value">{{ $shipment->carrier?->name ?? 'TBD' }}</span></div>
      <div class="row"><span class="row-label">Service</span><span class="row-value">{{ ucfirst($shipment->service_type) }}</span></div>
      <div class="row"><span class="row-label">From</span><span class="row-value">{{ $shipment->sender_city }}</span></div>
      <div class="row"><span class="row-label">To</span><span class="row-value">{{ $shipment->receiver_city }}</span></div>
      <div class="row"><span class="row-label">Recipient</span><span class="row-value">{{ $shipment->receiver_name }}</span></div>
      <div class="row"><span class="row-label">Package</span><span class="row-value">{{ $shipment->package_type }} · {{ $shipment->weight }} kg</span></div>
      <div class="row"><span class="row-label">Est. Delivery</span><span class="row-value">{{ $shipment->estimated_delivery?->format('D, M d Y') ?? 'TBD' }}</span></div>
      <div class="fare-box">
        <div class="fare-row"><span>Base Fare</span><span>₹{{ number_format($shipment->base_fare, 2) }}</span></div>
        <div class="fare-row"><span>Weight Charges</span><span>₹{{ number_format($shipment->weight_charge, 2) }}</span></div>
        <div class="fare-row"><span>Distance Charges</span><span>₹{{ number_format($shipment->distance_charge, 2) }}</span></div>
        <div class="fare-row"><span>GST (18%)</span><span>₹{{ number_format($shipment->gst_amount, 2) }}</span></div>
        <div class="fare-total"><span>Total Paid</span><span>₹{{ number_format($shipment->cost, 2) }}</span></div>
      </div>
      <a href="{{ url('/track/'.$shipment->tracking_number) }}" class="cta">Track Your Shipment →</a>
      <p style="font-size:13px;color:#64748b;">For support: <a href="mailto:ops@swiftship.in" style="color:#f59e0b;">ops@swiftship.in</a></p>
    </div>
    <div class="footer">
      <p>© {{ date('Y') }} SwiftShip. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
