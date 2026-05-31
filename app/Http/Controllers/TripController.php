<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['bus', 'route', 'bookings'])->latest()->paginate(10);
        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        $buses = Bus::all();
        $routes = Route::all();
        return view('admin.trips.create', compact('buses', 'routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'date' => 'required|date',
            'base_price' => 'required|numeric|min:0',
        ]);

        Trip::create($validated);
        return redirect()->route('admin.trips.index')->with('success', 'Trip created successfully.');
    }

    public function edit(Trip $trip)
    {
        $buses = Bus::all();
        $routes = Route::all();
        return view('admin.trips.edit', compact('trip', 'buses', 'routes'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'date' => 'required|date',
            'base_price' => 'required|numeric|min:0',
        ]);

        $trip->update($validated);
        return redirect()->route('admin.trips.index')->with('success', 'Trip updated successfully.');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('admin.trips.index')->with('success', 'Trip deleted successfully.');
    }
}
