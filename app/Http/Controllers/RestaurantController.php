<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function edit()
    {
        $restaurant = Auth::user()->restaurant;
        return view('admin.customisation.index', compact('restaurant'));
    }

    public function update(Request $request)
    {
        $restaurant = Auth::user()->restaurant;

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|url', // Using URL for now as per previous design decisions
        ]);

        $restaurant->update($request->only('name', 'address', 'logo'));

        return back()->with('success', 'Restaurant settings updated successfully.');
    }
}
