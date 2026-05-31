@extends('layouts.app')

@section('title', 'Browse Trips - TranspoGo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-search me-2"></i>Browse Trips</h1>
</div>

<form method="GET" class="glass-card p-3 mb-4">
    <div class="row g-2">
        <div class="col-md-3">
            <input type="text" name="from" class="glass-input form-control" placeholder="From city..." value="{{ request('from') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="to" class="glass-input form-control" placeholder="To city..." value="{{ request('to') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="glass-input form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-glass w-100"><i class="bi bi-search me-1"></i>Search</button>
        </div>
    </div>
</form>

<div class="row g-4">
    @forelse($trips as $trip)
    <div class="col-md-4">
        <div class="trip-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge badge-glass info"><i class="bi bi-bus-front me-1"></i>{{ $trip->bus->plate_number }}</span>
                @if($trip->remainingSeats() <= 3 && $trip->remainingSeats() > 0)
                    <span class="badge badge-glass warning">{{ $trip->remainingSeats() }} left!</span>
                @elseif($trip->isFull())
                    <span class="badge badge-glass danger">Full</span>
                @else
                    <span class="badge badge-glass success">{{ $trip->remainingSeats() }} seats</span>
                @endif
            </div>

            <div class="route-display">
                <span class="city">{{ $trip->route->origin }}</span>
                <span class="arrow"><i class="bi bi-arrow-right-circle-fill"></i></span>
                <span class="city">{{ $trip->route->destination }}</span>
            </div>

            <div class="trip-detail"><i class="bi bi-calendar"></i>{{ $trip->date->format('l, F d, Y') }}</div>
            <div class="trip-detail"><i class="bi bi-clock"></i>{{ $trip->date->format('g:i A') }}</div>

            <hr style="border-color: rgba(255,255,255,0.1);">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="price-tag">FRW {{ number_format($trip->base_price, 2) }}</span>
                    <small class="text-white-50 d-block">/ per seat</small>
                </div>
                @if(!$trip->isFull())
                    <a href="{{ route('client.trips.book', $trip) }}" class="btn btn-primary-glass">
                        <i class="bi bi-ticket me-1"></i>Book Now
                    </a>
                @else
                    <button class="btn btn-outline-glass" disabled>Full</button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="glass-card p-5 text-center">
            <i class="bi bi-search" style="font-size: 3rem; color: rgba(255,255,255,0.2);"></i>
            <h4 class="text-white mt-3">No trips found</h4>
            <p class="text-white-50">Try adjusting your search criteria or check back later for new trips.</p>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $trips->links() }}
</div>
@endsection
