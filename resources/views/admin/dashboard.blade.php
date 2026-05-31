@extends('layouts.app')

@section('title', 'Admin Dashboard - TranspoGo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0">Admin Dashboard</h1>
    <span class="badge badge-glass primary"><i class="bi bi-shield me-1"></i>Admin Panel</span>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-bus-front"></i></div>
            <div class="stat-value">{{ $totalBuses }}</div>
            <div class="stat-label">Total Buses</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-signpost-2"></i></div>
            <div class="stat-value">{{ $totalRoutes }}</div>
            <div class="stat-label">Total Routes</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="bi bi-calendar-event"></i></div>
            <div class="stat-value">{{ $totalTrips }}</div>
            <div class="stat-label">Total Trips</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon white"><i class="bi bi-ticket-perforated"></i></div>
            <div class="stat-value">{{ $totalBookings }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon success"><i class="bi bi-people"></i></div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Registered Clients</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-cash-coin"></i></div>
            <div class="stat-value">FRW {{ number_format($totalRevenue, 2) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-bar-chart"></i></div>
            <div class="stat-value">{{ $totalTrips > 0 ? round(($totalBookings / max($totalTrips, 1)) * 100) : 0 }}%</div>
            <div class="stat-label">Booking Rate</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="glass-card p-4">
            <h5 class="text-white fw-bold mb-3"><i class="bi bi-clock-history me-2"></i>Recent Bookings</h5>
            @forelse($recentBookings as $booking)
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                <div>
                    <strong class="text-white">{{ $booking->passenger_name }}</strong>
                    <div class="text-white-50" style="font-size: 0.8rem;">
                        {{ $booking->trip->route->origin }} <i class="bi bi-arrow-right"></i> {{ $booking->trip->route->destination }}
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge badge-glass success">FRW {{ number_format($booking->price, 2) }}</span>
                    <div class="text-white-50" style="font-size: 0.75rem;">{{ $booking->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <p class="text-white-50 mb-0">No bookings yet.</p>
            @endforelse
        </div>
    </div>
    <div class="col-md-6">
        <div class="glass-card p-4">
            <h5 class="text-white fw-bold mb-3"><i class="bi bi-calendar-check me-2"></i>Upcoming Trips</h5>
            @forelse($upcomingTrips as $trip)
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                <div>
                    <strong class="text-white">{{ $trip->route->origin }} → {{ $trip->route->destination }}</strong>
                    <div class="text-white-50" style="font-size: 0.8rem;">
                        <i class="bi bi-bus-front me-1"></i>{{ $trip->bus->plate_number }}
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge badge-glass info"><i class="bi bi-calendar me-1"></i>{{ $trip->date->format('M d') }}</span>
                    <div class="text-white-50" style="font-size: 0.75rem;">FRW {{ number_format($trip->base_price, 2) }} / seat</div>
                </div>
            </div>
            @empty
            <p class="text-white-50 mb-0">No upcoming trips.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
