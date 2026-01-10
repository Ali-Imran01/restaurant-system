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
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.orders.index', compact('orders'));
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

        return back()->with('success', 'Order status updated.');
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
}
