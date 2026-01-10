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

        // Data for Sales Chart (Last 7 Days)
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = Order::whereHas('table', function($query) use ($restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })
                ->whereDate('created_at', $date)
                ->whereIn('status', ['paid', 'preparing', 'completed'])
                ->sum('total_amount');
            
            $salesData[] = [
                'date' => $date->format('M d'),
                'revenue' => (float)$revenue
            ];
        }

        // Top Selling Items
        $topItems = \App\Models\OrderItem::whereHas('order.table', function($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })
            ->select('menu_item_id', \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('menu_item_id')
            ->orderByDesc('total_quantity')
            ->with('menuItem')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrdersToday', 
            'totalRevenueToday', 
            'activeTablesCount', 
            'menuItemsCount',
            'salesData',
            'topItems'
        ));
    }
}
