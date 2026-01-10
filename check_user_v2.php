<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'bistro@owner.com')->first();
$output = $user ? "RES_ID:" . $user->restaurant_id : "USER_NOT_FOUND";
file_put_contents('user_debug.txt', $output);
echo "Done\n";
