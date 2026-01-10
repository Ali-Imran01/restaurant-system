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
            'slug' => 'required|string|max:255|unique:restaurants,slug,' . $restaurant->id,
            'external_website_url' => 'nullable|url',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|url',
        ]);

        $restaurant->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'external_website_url' => $request->external_website_url,
            'address' => $request->address,
            'logo' => $request->logo,
            'show_public_profile' => $request->has('show_public_profile'),
        ]);

        return back()->with('success', 'Restaurant settings updated successfully.');
    }
}
