@extends('layouts.app')

@section('title', 'My Bookings - TranspoGo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-ticket-perforated me-2"></i>My Tickets</h1>
    <a href="{{ route('client.trips') }}" class="btn btn-primary-glass"><i class="bi bi-search me-1"></i>Browse Trips</a>
</div>

<div class="row g-4">
    @forelse($bookings as $booking)
    <div class="col-md-6">
        <div class="trip-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="badge badge-glass primary">Ticket #{{ $booking->id }}</span>
                    @if($booking->status === 'confirmed')
                        <span class="badge badge-glass success ms-1"><i class="bi bi-check me-1"></i>Confirmed</span>
                    @else
                        <span class="badge badge-glass danger ms-1"><i class="bi bi-x me-1"></i>Cancelled</span>
                    @endif
                </div>
                <span class="badge badge-glass info">{{ $booking->trip->bus->plate_number }}</span>
            </div>

            <div class="route-display mt-3">
                <span class="city">{{ $booking->trip->route->origin }}</span>
                <span class="arrow"><i class="bi bi-arrow-right-circle-fill"></i></span>
                <span class="city">{{ $booking->trip->route->destination }}</span>
            </div>

            <div class="row mt-3">
                <div class="col-6">
                    <div class="trip-detail"><i class="bi bi-calendar"></i>{{ $booking->trip->date->format('D, M d, Y') }}</div>
                    <div class="trip-detail mt-1"><i class="bi bi-person"></i>{{ $booking->passenger_name }}</div>
                    @if($booking->phone)
                    <div class="trip-detail mt-1"><i class="bi bi-phone"></i>{{ $booking->phone }}</div>
                    @endif
                </div>
                <div class="col-6 text-end">
                    <div class="price-tag">FRW {{ number_format($booking->price, 2) }}</div>
                    <div class="text-white-50" style="font-size: 0.8rem;">Paid</div>
                </div>
            </div>

            @if($booking->status === 'confirmed' && $booking->trip->date->isFuture())
            <hr style="border-color: rgba(255,255,255,0.1);">
            <div class="text-end">
                <form action="{{ route('client.bookings.cancel', $booking) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Cancel this booking?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger-glass btn-sm"><i class="bi bi-x-circle me-1"></i>Cancel Ticket</button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="glass-card p-5 text-center">
            <i class="bi bi-ticket-perforated" style="font-size: 3rem; color: rgba(255,255,255,0.2);"></i>
            <h4 class="text-white mt-3">No tickets yet</h4>
            <p class="text-white-50">You haven't booked any trips yet. Start exploring available trips!</p>
            <a href="{{ route('client.trips') }}" class="btn btn-primary-glass mt-2">
                <i class="bi bi-search me-1"></i>Browse Available Trips
            </a>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $bookings->links() }}
</div>
@endsection
