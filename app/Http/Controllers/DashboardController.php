<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Trip;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuses = Bus::count();
        $totalRoutes = Route::count();
        $totalTrips = Trip::count();
        $totalBookings = Booking::count();
        $totalUsers = User::where('role', 'client')->count();
        $totalRevenue = Booking::sum('price');

        $recentBookings = Booking::with(['trip.bus', 'trip.route', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingTrips = Trip::with(['bus', 'route'])
            ->where('date', '>=', now())
            ->orderBy('date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuses', 'totalRoutes', 'totalTrips',
            'totalBookings', 'totalUsers', 'totalRevenue',
            'recentBookings', 'upcomingTrips'
        ));
    }
}
