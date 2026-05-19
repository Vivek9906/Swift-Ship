<?php
$map = [
    'â‚¹' => '₹',
    'â€”' => '—',
    'â†’' => '→',
    'â€¦' => '…'
];
$dirs = ['resources/views', 'resources/views/admin', 'resources/views/customer', 'resources/views/layouts', 'resources/views/shipments', 'resources/views/customers', 'resources/views/settings', 'resources/views/emails'];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    foreach (glob("$dir/*.blade.php") as $f) {
        $c = file_get_contents($f);
        $c2 = strtr($c, $map);
        if ($c !== $c2) {
            file_put_contents($f, $c2);
            echo "Fixed $f\n";
        }
    }
}
