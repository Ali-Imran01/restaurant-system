<?php
use Illuminate\Support\Facades\DB;
try {
    $itemsUpdated = DB::table('order_items')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->whereNull('order_items.restaurant_id')
        ->update(['order_items.restaurant_id' => DB::raw('orders.restaurant_id')]);
    echo "Rescued $itemsUpdated orphaned order items.";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
