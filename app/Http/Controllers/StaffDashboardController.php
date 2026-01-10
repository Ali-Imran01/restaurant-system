<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $activeOrdersCount = Order::whereHas('table', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            })
            ->whereIn('status', ['waiting_payment', 'paid', 'sent_to_kitchen'])
            ->count();

        return view('staff.dashboard', compact('activeOrdersCount'));
    }

    public function orders()
    {
        $orders = Order::whereHas('table', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            })
            ->with(['table', 'items.menuItem'])
            ->whereIn('status', ['waiting_payment', 'paid', 'preparing'])
            ->orderBy('created_at', 'asc')
            ->get();

        $groupedOrders = $orders->groupBy('table_id');
        $lastOrderId = Order::whereHas('table', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            })->max('id') ?: 0;

        return view('staff.orders.index', compact('groupedOrders', 'lastOrderId'));
    }

    public function menu()
    {
        $menuItems = MenuItem::whereHas('category', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            })
            ->with('category')
            ->get();

        return view('staff.menu.index', compact('menuItems'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        if ($order->table->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:waiting_payment,paid,preparing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // If marked as paid, we can let the frontend handle the 5s transition 
        // OR we just return success and the frontend will trigger the 'preparing' update later.
        
        return response()->json(['success' => true, 'status' => $order->status]);
    }

    public function toggleItemReceived(\App\Models\OrderItem $item)
    {
        if ($item->order->table->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }

        $item->update(['is_received' => !$item->is_received]);

        // Check if all items are received
        $order = $item->order;
        $totalItems = $order->items()->count();
        $receivedItems = $order->items()->where('is_received', true)->count();

        if ($totalItems > 0 && $totalItems === $receivedItems) {
            $order->update(['status' => 'completed']);
        }

        return response()->json([
            'success' => true, 
            'is_received' => $item->is_received,
            'order_status' => $order->status
        ]);
    }

    public function receiveAllItems(Order $order)
    {
        if ($order->table->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }

        $order->items()->update(['is_received' => true]);
        $order->update(['status' => 'completed']);

        return response()->json(['success' => true, 'order_status' => 'completed']);
    }

    public function editOrder(Order $order)
    {
        if ($order->table->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }

        $menuItems = MenuItem::whereHas('category', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            })
            ->where('is_available', true)
            ->get();

        return view('staff.orders.edit', compact('order', 'menuItems'));
    }

    public function printOrder(Order $order)
    {
        if ($order->table->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }

        $order->load(['table.restaurant', 'items.menuItem']);
        return view('staff.orders.print', compact('order'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        if ($order->table->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.quantity' => 'required|integer|min:0',
        ]);

        $totalAmount = 0;
        foreach ($request->items as $itemId => $data) {
            $quantity = (int)$data['quantity'];
            
            if ($quantity <= 0) {
                $order->items()->where('menu_item_id', $itemId)->delete();
                continue;
            }

            $menuItem = MenuItem::findOrFail($itemId);
            $subtotal = $menuItem->price * $quantity;
            $totalAmount += $subtotal;

            $order->items()->updateOrCreate(
                ['menu_item_id' => $itemId],
                ['quantity' => $quantity, 'notes' => $data['notes'] ?? null, 'price_at_order' => $menuItem->price, 'subtotal' => $subtotal]
            );
        }

        $order->update(['total_amount' => $totalAmount]);

        return redirect()->route('staff.orders')->with('success', 'Order updated successfully.');
    }

    public function toggleMenuAvailability(MenuItem $menuItem)
    {
        if ($menuItem->category->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }

        $menuItem->update(['is_available' => !$menuItem->is_available]);

        return back()->with('success', 'Menu availability updated.');
    }

    public function history()
    {
        $orders = Order::whereHas('table', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            })
            ->with(['table', 'items.menuItem'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('staff.history.index', compact('orders'));
    }

    public function checkNewOrders()
    {
        $lastOrderId = Order::whereHas('table', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            })
            ->max('id');

        return response()->json(['last_order_id' => $lastOrderId ?: 0]);
    }
}
