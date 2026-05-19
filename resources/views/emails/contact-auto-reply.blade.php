<!DOCTYPE html><html><head><meta charset="UTF-8"><title>We received your message</title>
<style>body{margin:0;padding:0;background:#f1f5f9;font-family:Inter,Arial,sans-serif;}.wrap{max-width:600px;margin:32px auto;background:#fff;border-radius:12px;overflow:hidden;}.header{background:#0f172a;padding:24px 32px;text-align:center;}.logo{font-size:20px;font-weight:800;color:#fff;}.logo span{color:#f59e0b;}.body{padding:32px;}.footer{background:#f8fafc;border-top:1px solid #e2e8f0;padding:16px 32px;text-align:center;font-size:12px;color:#94a3b8;}</style>
</head><body>
<div class="wrap">
  <div class="header"><div class="logo">Swift<span>Ship</span></div></div>
  <div class="body">
    <p style="font-size:16px;font-weight:700;color:#0f172a;">Hi {{ $lead->name }}, we received your message! 👋</p>
    <p style="color:#475569;">Thanks for reaching out to SwiftShip Sales. Our team will review your requirements and get back to you within <strong>24 hours</strong>.</p>
    <p style="color:#475569;"><strong>Your inquiry summary:</strong><br>Company: {{ $lead->company }}<br>Business Type: {{ $lead->business_type }}<br>Monthly Volume: {{ $lead->monthly_volume }}</p>
    <p style="color:#475569;">Questions? Email us at <a href="mailto:ops@swiftship.in" style="color:#f59e0b;">ops@swiftship.in</a></p>
  </div>
  <div class="footer">© {{ date('Y') }} SwiftShip. All rights reserved.</div>
</div>
</body></html>
