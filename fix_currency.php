<?php
$files = [
    'resources/views/shipments/show.blade.php',
    'resources/views/customer/dashboard.blade.php',
    'resources/views/customer/confirmation.blade.php',
    'resources/views/customer/book.blade.php',
    'resources/views/emails/shipment-confirmed.blade.php',
    'resources/views/emails/shipment-booked.blade.php',
    'resources/views/customer/shipments.blade.php',
    'resources/views/customer/shipment-detail.blade.php',
    'resources/views/customer/pay.blade.php',
    'resources/views/admin/dashboard.blade.php'
];

foreach ($files as $f) {
    if (file_exists($f)) {
        $c = file_get_contents($f);
        // Replace â‚¹ with ₹
        $c = str_replace("â‚¹", "₹", $c);
        file_put_contents($f, $c);
    }
}
echo "Done.";
