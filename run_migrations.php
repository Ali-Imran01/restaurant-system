<?php

use Illuminate\Support\Facades\Artisan;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = Artisan::call('migrate', ['--force' => true]);
echo "Migration Status: " . $status . "\n";
echo "Output: \n" . Artisan::output();
