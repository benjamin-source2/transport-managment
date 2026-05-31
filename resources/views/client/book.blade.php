@extends('layouts.app')

@section('title', 'Book Ticket - TranspoGo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-header mb-0"><i class="bi bi-ticket me-2"></i>Book Your Ticket</h1>
            <a href="{{ route('client.trips') }}" class="btn btn-outline-glass"><i class="bi bi-arrow-left me-1"></i>Back to Trips</a>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-5">
                <div class="glass-card p-4 text-center">
                    <div style="font-size: 3rem; color: var(--primary);">
                        <i class="bi bi-bus-front"></i>
                    </div>
                    <h3 class="text-white mt-3 fw-bold">{{ $trip->route->origin }}</h3>
                    <div class="my-3">
                        <i class="bi bi-arrow-down" style="color: var(--primary); font-size: 1.5rem;"></i>
                    </div>
                    <h3 class="text-white fw-bold">{{ $trip->route->destination }}</h3>
                    <hr style="border-color: rgba(255,255,255,0.1);">
                    <div class="text-white-50">
                        <div><i class="bi bi-calendar me-2 text-primary"></i>{{ $trip->date->format('l, F d, Y') }}</div>
                        <div class="mt-1"><i class="bi bi-bus-front me-2 text-primary"></i>{{ $trip->bus->plate_number }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-white-50">Ticket Price</span>
                        <span class="text-white fw-bold fs-4">FRW {{ number_format($trip->base_price, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-white-50">Available Seats</span>
                        @if($trip->remainingSeats() > 0)
                            <span class="badge badge-glass success">{{ $trip->remainingSeats() }} seats</span>
                        @else
                            <span class="badge badge-glass danger">Fully Booked</span>
                        @endif
                    </div>
                    <hr style="border-color: rgba(255,255,255,0.1);">

                    @if($trip->isFull())
                        <div class="glass-alert danger">This trip is fully booked. Please choose another trip.</div>
                    @else
                        <form action="{{ route('client.trips.book', $trip) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person me-1"></i>Passenger Name</label>
                                <input type="text" name="passenger_name" class="glass-input form-control @error('passenger_name') is-invalid @enderror"
                                       value="{{ old('passenger_name', Auth::user()->name) }}" placeholder="Full name" required>
                                @error('passenger_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-phone me-1"></i>Phone Number</label>
                                <input type="text" name="phone" class="glass-input form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}" placeholder="Phone number" required>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-envelope me-1"></i>Email (optional)</label>
                                <input type="email" name="email" class="glass-input form-control"
                                       value="{{ old('email', Auth::user()->email) }}" placeholder="Email address">
                            </div>
                            <div class="glass-alert info mb-3">
                                <i class="bi bi-info-circle me-2"></i>
                                You'll be charged <strong>FRW {{ number_format($trip->base_price, 2) }}</strong> for this ticket.
                            </div>
                            <button type="submit" class="btn btn-primary-glass w-100 py-2">
                                <i class="bi bi-check-circle me-2"></i>Confirm Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
