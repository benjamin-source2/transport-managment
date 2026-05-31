<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::with(['bus', 'route', 'bookings']);

        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        $trips = $query->latest()->paginate(15);
        return view('admin.reports.trips', compact('trips'));
    }
}
