<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard()
    {
        $upcomingTrips = Trip::with(['bus', 'route', 'bookings'])
            ->where('date', '>=', now())
            ->orderBy('date')
            ->take(6)
            ->get();

        $myBookings = Booking::with(['trip.bus', 'trip.route'])
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $totalSpent = Booking::where('user_id', Auth::id())->sum('price');
        $totalTrips = Booking::where('user_id', Auth::id())->count();

        return view('client.dashboard', compact('upcomingTrips', 'myBookings', 'totalSpent', 'totalTrips'));
    }

    public function trips(Request $request)
    {
        $query = Trip::with(['bus', 'route', 'bookings'])
            ->where('date', '>=', now());

        if ($request->filled('from')) {
            $query->whereHas('route', function ($q) use ($request) {
                $q->where('origin', 'like', '%' . $request->from . '%');
            });
        }

        if ($request->filled('to')) {
            $query->whereHas('route', function ($q) use ($request) {
                $q->where('destination', 'like', '%' . $request->to . '%');
            });
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        $trips = $query->orderBy('date')->paginate(9);
        return view('client.trips', compact('trips'));
    }

    public function bookForm(Trip $trip)
    {
        $trip->load(['bus', 'route', 'bookings']);
        return view('client.book', compact('trip'));
    }

    public function book(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'passenger_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $trip->load(['bus', 'bookings']);

        if ($trip->bookings()->count() >= $trip->bus->capacity) {
            return back()->withInput()->with('error', 'Sorry, this trip is fully booked.');
        }

        $booking = Booking::create([
            'trip_id' => $trip->id,
            'user_id' => Auth::id(),
            'passenger_name' => $validated['passenger_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? Auth::user()->email,
            'price' => $trip->base_price,
            'status' => 'confirmed',
        ]);

        return redirect()->route('client.bookings')->with('success', 'Ticket booked successfully! Your ticket reference #' . $booking->id);
    }

    public function myBookings()
    {
        $bookings = Booking::with(['trip.bus', 'trip.route'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('client.bookings', compact('bookings'));
    }

    public function cancelBooking(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled successfully.');
    }
}
