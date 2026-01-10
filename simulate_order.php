<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Table;

$restaurant = Restaurant::where('name', 'The Grand Bistro')->first();
if (!$restaurant) {
    die("Restaurant not found\n");
}

$table = Table::where('restaurant_id', $restaurant->id)->first();
if (!$table) {
    die("Table not found\n");
}

$order = Order::create([
    'restaurant_id' => $restaurant->id,
    'table_id' => $table->id,
    'status' => 'waiting_payment',
    'total_amount' => 99.99,
    'payment_method' => 'cash'
]);

echo "Order created successfully! ID: " . $order->id . " for Restaurant: " . $restaurant->name . " (ID: " . $restaurant->id . ")\n";
