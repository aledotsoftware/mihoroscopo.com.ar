<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::enableQueryLog();

$query = DB::table('email_logs')->insertGetId([
    'subscription_id' => 1,
    'service_type' => 'horoscope',
    'content_id' => 1,
    'sent_at' => \Carbon\Carbon::now(),
    'status' => 'sent'
]);

print_r(DB::getQueryLog());
