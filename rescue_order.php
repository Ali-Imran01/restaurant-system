<?php
use Illuminate\Support\Facades\DB;
try {
    $ordersUpdated = DB::table('orders')
        ->join('tables', 'orders.table_id', '=', 'tables.id')
        ->whereNull('orders.restaurant_id')
        ->update(['orders.restaurant_id' => DB::raw('tables.restaurant_id')]);
    echo "Rescued $ordersUpdated orphaned orders.";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
