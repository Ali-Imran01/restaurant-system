<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $restaurantId = Auth::user()->restaurant_id;
        $today = Carbon::today();

        $totalOrdersToday = Order::whereHas('table', function($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })
            ->whereDate('created_at', $today)
            ->count();

        $totalRevenueToday = Order::whereHas('table', function($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })
            ->whereDate('created_at', $today)
            ->whereIn('status', ['paid', 'preparing', 'completed'])
            ->sum('total_amount');

        $activeTablesCount = Table::where('restaurant_id', $restaurantId)->count();

        $menuItemsCount = MenuItem::whereHas('category', function($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })->count();

        return view('admin.dashboard', compact(
            'totalOrdersToday', 
            'totalRevenueToday', 
            'activeTablesCount', 
            'menuItemsCount'
        ));
    }
}
