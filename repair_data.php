<?php

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use App\Models\Table;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

try {
    echo "Starting data repair...\n";

    // 1. Fix Menu Items (Link to Restaurant via Category)
    $menuItemsUpdated = DB::table('menu_items')
        ->join('categories', 'menu_items.category_id', '=', 'categories.id')
        ->whereNull('menu_items.restaurant_id')
        ->update(['menu_items.restaurant_id' => DB::raw('categories.restaurant_id')]);
    echo "Updated $menuItemsUpdated menu items.\n";

    // 2. Fix Orders (Link to Restaurant via Table)
    $ordersUpdated = DB::table('orders')
        ->join('tables', 'orders.table_id', '=', 'tables.id')
        ->whereNull('orders.restaurant_id')
        ->update(['orders.restaurant_id' => DB::raw('tables.restaurant_id')]);
    echo "Updated $ordersUpdated orders.\n";

    // 3. Fix Order Items (Link to Restaurant via Order)
    $orderItemsUpdated = DB::table('order_items')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->whereNull('order_items.restaurant_id')
        ->update(['order_items.restaurant_id' => DB::raw('orders.restaurant_id')]);
    echo "Updated $orderItemsUpdated order items.\n";

    echo "Data repair complete!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
