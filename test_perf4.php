<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Measure time
$start = microtime(true);
for ($i=0; $i<100; $i++) {
    $date = \Carbon\Carbon::now()->format('d/m/Y');
    $dateForDatabase = \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
}
echo "Time 1: " . (microtime(true) - $start) . "\n";

$start = microtime(true);
for ($i=0; $i<100; $i++) {
    $dateForDatabase = \Carbon\Carbon::now()->toDateString();
    $date = \Carbon\Carbon::now()->format('d/m/Y');
}
echo "Time 2: " . (microtime(true) - $start) . "\n";
