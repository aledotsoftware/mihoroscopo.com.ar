<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::enableQueryLog();

$query = DB::table('subscriptions')
    ->select(['id', 'subscription_id', 'email'])
    ->where('status', 'pending')
    ->whereBetween('created_at', [
        \Carbon\Carbon::now()->subDays(3)->startOfDay(),
        \Carbon\Carbon::now()->endOfDay()
    ]);

echo $query->toSql() . "\n";
