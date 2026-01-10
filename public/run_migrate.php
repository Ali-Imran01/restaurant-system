<?php
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

try {
    echo "Starting Migration...<br>";
    Artisan::call('migrate', ['--force' => true]);
    echo "Migration Completed!<br>";
    echo nl2br(Artisan::output());
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
