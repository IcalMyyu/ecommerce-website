<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = App\Models\Order::with('address')->get();
foreach ($orders as $o) {
    echo "Order ID: {$o->id} | User ID: {$o->user_id} | Address ID: " . ($o->address_id ?? "NULL") . " | Has Address Relation: " . ($o->address ? "YES" : "NO") . "\n";
}
