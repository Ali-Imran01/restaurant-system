<?php
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

try {
    echo "Starting Seeding...<br>";
    Artisan::call('db:seed', ['--force' => true]);
    echo "Seeding Completed Successfully!<br>";
    echo Artisan::output();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
