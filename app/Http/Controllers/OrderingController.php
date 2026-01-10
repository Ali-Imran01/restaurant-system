<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class OrderingController extends Controller
{
    public function showMenu($token)
    {
        $table = Table::where('qr_token', $token)->firstOrFail();
        $restaurant = $table->restaurant;
        
        // Store table info in session for subsequent order submission
        session(['table_id' => $table->id, 'restaurant_id' => $restaurant->id]);
        
        $categories = Category::where('restaurant_id', $restaurant->id)
            ->with(['menuItems' => function ($query) {
                $query->where('is_available', true);
            }])
            ->orderBy('sort_order')
            ->get();

        return view('ordering.menu', compact('table', 'restaurant', 'categories'));
    }

    public function checkout(Request $request)
    {
        $tableId = session('table_id');
        $restaurantId = session('restaurant_id');

        if (!$tableId) {
            return redirect()->back()->withErrors(['error' => 'Table session expired. Please scan QR again.']);
        }

        $cart = json_decode($request->cart, true);
        if (empty($cart)) {
            return redirect()->back()->withErrors(['error' => 'Your cart is empty.']);
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * (isset($item['quantity']) ? $item['quantity'] : 1);
        }

        $order = \App\Models\Order::create([
            'restaurant_id' => $restaurantId,
            'table_id' => $tableId,
            'status' => 'waiting_payment',
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method ?? 'cash',
        ]);

        foreach ($cart as $itemId => $details) {
            \App\Models\OrderItem::create([
                'restaurant_id' => $restaurantId,
                'order_id' => $order->id,
                'menu_item_id' => $itemId,
                'quantity' => $details['quantity'],
                'notes' => $details['notes'] ?? null,
                'price_at_order' => $details['price'],
                'subtotal' => $details['price'] * $details['quantity'],
            ]);
        }

        return redirect()->route('order.success', $order->id);
    }

    public function success($orderId)
    {
        $order = \App\Models\Order::with(['table.restaurant', 'items.menuItem'])->findOrFail($orderId);
        return view('ordering.success', compact('order'));
    }
}
