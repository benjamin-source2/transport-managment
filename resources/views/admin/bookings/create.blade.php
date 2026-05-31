@extends('layouts.app')

@section('title', 'Add Booking - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-plus-circle me-2"></i>Add Booking</h1>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-glass"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="glass-card p-4" style="max-width: 600px;">
    <form action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-calendar-event me-1"></i>Trip</label>
            <select name="trip_id" class="glass-select form-control @error('trip_id') is-invalid @enderror" required>
                <option value="">Select Trip</option>
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}" {{ old('trip_id') == $trip->id ? 'selected' : '' }}>
                        {{ $trip->bus->plate_number }} - {{ $trip->route->origin }} → {{ $trip->route->destination }} ({{ $trip->date->format('Y-m-d') }}) - FRW {{ number_format($trip->base_price, 2) }}
                    </option>
                @endforeach
            </select>
            @error('trip_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-person me-1"></i>Passenger Name</label>
            <input type="text" name="passenger_name" class="glass-input form-control @error('passenger_name') is-invalid @enderror"
                   value="{{ old('passenger_name') }}" placeholder="Full name" required>
            @error('passenger_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-phone me-1"></i>Phone (optional)</label>
            <input type="text" name="phone" class="glass-input form-control" value="{{ old('phone') }}" placeholder="Phone number">
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-envelope me-1"></i>Email (optional)</label>
            <input type="email" name="email" class="glass-input form-control" value="{{ old('email') }}" placeholder="Email address">
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-cash me-1"></i>Price in FRW (leave blank for trip price)</label>
            <input type="number" step="0.01" min="0" name="price" class="glass-input form-control" value="{{ old('price') }}" placeholder="Auto from trip">
        </div>
        <button type="submit" class="btn btn-primary-glass"><i class="bi bi-save me-1"></i>Save Booking</button>
    </form>
</div>
@endsection
