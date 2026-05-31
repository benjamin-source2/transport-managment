<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['trip.bus', 'trip.route', 'user']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('passenger_name', 'like', '%' . $request->search . '%')
                  ->orWhere('id', $request->search);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereHas('trip', function ($q) use ($request) {
                $q->where('date', '>=', $request->date_from);
            });
        }

        if ($request->filled('date_to')) {
            $query->whereHas('trip', function ($q) use ($request) {
                $q->where('date', '<=', $request->date_to);
            });
        }

        $bookings = $query->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $trips = Trip::with(['bus', 'route'])->get();
        return view('admin.bookings.create', compact('trips'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'passenger_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'price' => 'nullable|numeric|min:0',
        ]);

        $trip = Trip::withCount('bookings')->findOrFail($validated['trip_id']);

        if ($trip->bookings_count >= $trip->bus->capacity) {
            return back()->withInput()->with('error', 'This trip is fully booked.');
        }

        if (!isset($validated['price']) || $validated['price'] <= 0) {
            $validated['price'] = $trip->base_price;
        }

        $validated['status'] = 'confirmed';

        Booking::create($validated);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking cancelled successfully.');
    }
}
