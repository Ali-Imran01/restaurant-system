<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();

        if (!$restaurant->show_public_profile) {
            // If they have an external website, redirect there, otherwise show booking form
            if ($restaurant->external_website_url) {
                return redirect($restaurant->external_website_url);
            }
            return redirect()->route('public.reservation', $slug);
        }

        return view('public.profile', compact('restaurant'));
    }

    public function showBookingForm($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        return view('public.reservation', compact('restaurant'));
    }

    public function storeReservation(Request $request, $slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'reservation_datetime' => 'required|date|after:now',
            'guest_count' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $reservation = new Reservation($request->all());
        $reservation->restaurant_id = $restaurant->id;
        $reservation->status = 'pending';
        $reservation->save();

        return back()->with('success', 'Reservation requested successfully! We will contact you to confirm.');
    }
}
