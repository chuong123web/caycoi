<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$o = new \App\Models\Order();
$o->order_number = 'ORD-TEST';
$o->customer_name = 'Test';
$o->customer_email = 't@t.com';
$o->shipping_address = 'Address';
$o->total_amount = 530000;
$o->gift_code_id = 3;
$o->discount_amount = 200000;
$o->status = 'pending';
$o->save();
echo "OK\n";
