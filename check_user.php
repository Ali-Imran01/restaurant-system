<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Restaurant;

$user = User::where('email', 'bistro@owner.com')->first();
if ($user) {
    echo "User found: " . $user->name . " (ID: " . $user->id . ", Restaurant ID: " . $user->restaurant_id . ")\n";
    $restaurant = Restaurant::find($user->restaurant_id);
    if ($restaurant) {
        echo "Restaurant: " . $restaurant->name . "\n";
    } else {
        echo "Restaurant not found for ID: " . $user->restaurant_id . "\n";
    }
} else {
    echo "User bistro@owner.com not found.\n";
}
