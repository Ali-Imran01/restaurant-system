<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant;

class OrderItem extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = ['restaurant_id', 'order_id', 'menu_item_id', 'quantity', 'price_at_order', 'subtotal', 'notes', 'is_received'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
