<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::enableQueryLog();

$query = \App\Models\Subscription::with(['extradata_horoscopes' => function($q) {
    $q->select('subscription_id', 'signo', 'name');
}])->select(['id', 'email', 'external_reference', 'payment_type', 'subscription_id', 'status'])
->whereIn('status', ['authorized', 'pending']);

echo $query->toSql() . "\n";
print_r($query->getBindings());

