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
    .cta-btn { display: block; width: fit-content; 
               margin: 24px auto; padding: 14px 32px;
               background: #F59E0B; color: #000; 
               text-decoration: none; border-radius: 8px; 
               font-weight: bold; font-size: 16px; }
    .footer { background: #F9FAFB; padding: 20px; 
              text-align: center; color: #6B7280; font-size: 13px; }
    ul { padding-left: 20px; }
    li { margin-bottom: 10px; color: #111827; }
  </style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>SwiftShip</h1>
    <p>Welcome aboard!</p>
  </div>
  <div class="body">
    <p>Hi {{ $user->name }},</p>
    <p>Welcome to SwiftShip, the future of logistics! We're thrilled to have you on board.</p>
    
    <p>With your new account, you can enjoy:</p>
    <ul>
      <li>✓ Real-time GPS tracking across 15+ carriers</li>
      <li>✓ Instant delay alerts and SMS notifications</li>
      <li>✓ Secure role-based access</li>
    </ul>

    <a href="{{ url('/shipments/new') }}" class="cta-btn">
      Book Your First Shipment →
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
