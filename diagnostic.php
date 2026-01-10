<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$data = [
    'users' => \App\Models\User::all(['id', 'name', 'email', 'role', 'restaurant_id'])->toArray(),
    'restaurants' => \App\Models\Restaurant::all(['id', 'name'])->toArray(),
    'categories' => \App\Models\Category::all(['id', 'name', 'restaurant_id'])->toArray(),
];

file_put_contents('diagnostic_data.json', json_encode($data, JSON_PRETTY_PRINT));
echo "Diagnostic data written to diagnostic_data.json\n";
 