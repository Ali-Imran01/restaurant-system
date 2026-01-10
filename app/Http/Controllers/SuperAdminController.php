<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        // TenantScope is automatically disabled for super_admin in the scope itself
        // But we can be explicit if needed using withoutGlobalScopes()
        
        $totalRestaurants = Restaurant::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $restaurants = Restaurant::withCount('menuItems')->latest()->take(5)->get();

        return view('super_admin.dashboard', compact('totalRestaurants', 'totalOrders', 'totalRevenue', 'restaurants'));
    }

    public function restaurants()
    {
        $restaurants = Restaurant::withCount(['menuItems', 'tables'])->paginate(15);
        return view('super_admin.restaurants.index', compact('restaurants'));
    }

    public function createRestaurant()
    {
        return view('super_admin.restaurants.create');
    }

    public function storeRestaurant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|string|min:8',
        ]);

        $restaurant = Restaurant::create([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        User::create([
            'restaurant_id' => $restaurant->id,
            'name' => $request->owner_name,
            'email' => $request->owner_email,
            'password' => Hash::make($request->owner_password),
            'role' => 'admin',
        ]);

        return redirect()->route('super_admin.restaurants')->with('success', 'Restaurant and Owner account created successfully.');
    }

    public function editRestaurant(Restaurant $restaurant)
    {
        // Get the primary admin for this restaurant
        $owner = User::where('restaurant_id', $restaurant->id)->where('role', 'admin')->first();
        return view('super_admin.restaurants.edit', compact('restaurant', 'owner'));
    }

    public function updateRestaurant(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'owner_id' => 'required|exists:users,id',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email,' . $request->owner_id,
            'owner_password' => 'nullable|string|min:8',
        ]);

        $restaurant->update($request->only('name', 'address'));

        $ownerData = [
            'name' => $request->owner_name,
            'email' => $request->owner_email,
        ];

        if ($request->owner_password) {
            $ownerData['password'] = Hash::make($request->owner_password);
        }

        User::where('id', $request->owner_id)->update($ownerData);

        return redirect()->route('super_admin.restaurants')->with('success', 'Restaurant and Owner updated successfully.');
    }

    public function destroyRestaurant(Restaurant $restaurant)
    {
        // Everything else (menu, tables, orders) will be deleted via cascade
        $restaurant->delete();
        return redirect()->route('super_admin.restaurants')->with('success', 'Restaurant and all associated data permanently removed.');
    }

    // Platform Team Management
    public function users()
    {
        $users = User::where('role', 'super_admin')->get();
        return view('super_admin.users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'super_admin',
            'restaurant_id' => null,
        ]);

        return redirect()->route('super_admin.users')->with('success', 'New Super Admin added to the team.');
    }

    public function destroyUser(User $user)
    {
        if ($user->email === 'super_admin@restoqr.com') {
            return back()->with('error', 'The primary system account cannot be deleted.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('super_admin.users')->with('success', 'Team member removed.');
    }
}
