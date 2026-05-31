@extends('layouts.app')

@section('title', 'My Dashboard - TranspoGo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-house me-2"></i>Welcome, {{ Auth::user()->name }}!</h1>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="bi bi-ticket-perforated"></i></div>
            <div class="stat-value">{{ $totalTrips }}</div>
            <div class="stat-label">Trips Booked</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon success"><i class="bi bi-cash-coin"></i></div>
            <div class="stat-value">FRW {{ number_format($totalSpent, 2) }}</div>
            <div class="stat-label">Total Spent</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-clock-history"></i></div>
            <div class="stat-value">{{ $upcomingTrips->count() }}</div>
            <div class="stat-label">Available Trips</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-white fw-bold mb-0"><i class="bi bi-calendar-event me-2"></i>Available Trips</h5>
                <a href="{{ route('client.trips') }}" class="btn btn-outline-glass btn-sm">View All</a>
            </div>
            <div class="row g-3">
                @forelse($upcomingTrips as $trip)
                <div class="col-md-6">
                    <div class="trip-card">
                        <div class="route-display">
                            <span class="city">{{ $trip->route->origin }}</span>
                            <span class="arrow"><i class="bi bi-arrow-right"></i></span>
                            <span class="city">{{ $trip->route->destination }}</span>
                        </div>
                        <div class="trip-detail"><i class="bi bi-calendar"></i>{{ $trip->date->format('D, M d, Y') }}</div>
                        <div class="trip-detail"><i class="bi bi-bus-front"></i>{{ $trip->bus->plate_number }}</div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="price-tag">FRW {{ number_format($trip->base_price, 2) }}</span>
                            <a href="{{ route('client.trips.book', $trip) }}" class="btn btn-primary-glass btn-sm">
                                <i class="bi bi-ticket me-1"></i>Book
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-white-50 mb-0 text-center py-3">No upcoming trips available right now.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-white fw-bold mb-0"><i class="bi bi-ticket-perforated me-2"></i>My Recent Bookings</h5>
                <a href="{{ route('client.bookings') }}" class="btn btn-outline-glass btn-sm">View All</a>
            </div>
            @forelse($myBookings as $booking)
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                <div>
                    <strong class="text-white">#{{ $booking->id }} - {{ $booking->passenger_name }}</strong>
                    <div class="text-white-50" style="font-size: 0.8rem;">
                        {{ $booking->trip->route->origin }} <i class="bi bi-arrow-right"></i> {{ $booking->trip->route->destination }}
                    </div>
                    <div class="text-white-50" style="font-size: 0.75rem;">
                        <i class="bi bi-calendar me-1"></i>{{ $booking->trip->date->format('M d, Y') }}
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge badge-glass {{ $booking->status === 'confirmed' ? 'success' : 'danger' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                    <div class="text-white mt-1" style="font-size: 0.85rem;">FRW {{ number_format($booking->price, 2) }}</div>
                </div>
            </div>
            @empty
            <p class="text-white-50 mb-0 text-center py-3">No bookings yet. Start exploring trips!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
