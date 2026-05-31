<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['trip.bus', 'trip.route', 'user']);

        if ($request->filled('search')) {
            $query->where('passenger_name', 'like', '%' . $request->search . '%');
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
        return view('admin.reports.bookings', compact('bookings'));
    }
}
