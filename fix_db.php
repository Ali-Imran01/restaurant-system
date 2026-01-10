<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "<pre>";
echo "Checking order_items table...\n";
if (Schema::hasTable('order_items')) {
    $columns = Schema::getColumnListing('order_items');
    echo "Columns: " . implode(', ', $columns) . "\n";
    if (in_array('is_received', $columns)) {
        echo "SUCCESS: is_received column exists.\n";
    } else {
        echo "MISSING: is_received column does not exist. Attempting manual addition...\n";
        try {
            DB::statement("ALTER TABLE order_items ADD COLUMN is_received BOOLEAN DEFAULT 0 AFTER notes");
            echo "SUCCESS: Added is_received column manually.\n";
        } catch (\Exception $e) {
            echo "ERROR adding column: " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "ERROR: order_items table not found.\n";
}
echo "</pre>";
