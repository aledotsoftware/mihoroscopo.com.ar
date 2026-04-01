<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::enableQueryLog();

$query = \App\Models\Subscription::with('extradata_horoscopes')
    ->select(['id', 'email', 'external_reference', 'payment_type', 'subscription_id', 'status'])
    ->whereIn('status', ['authorized', 'pending']);

$query->chunkById(100, function ($subscriptions) {
    echo "Chunk processed.\n";
});

print_r(DB::getQueryLog());
