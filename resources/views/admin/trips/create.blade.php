@extends('layouts.app')

@section('title', 'Add Trip - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-plus-circle me-2"></i>Add Trip</h1>
    <a href="{{ route('admin.trips.index') }}" class="btn btn-outline-glass"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="glass-card p-4" style="max-width: 600px;">
    <form action="{{ route('admin.trips.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-bus-front me-1"></i>Bus</label>
            <select name="bus_id" class="glass-select form-control @error('bus_id') is-invalid @enderror" required>
                <option value="">Select Bus</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>{{ $bus->plate_number }} ({{ $bus->capacity }} seats)</option>
                @endforeach
            </select>
            @error('bus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-signpost-2 me-1"></i>Route</label>
            <select name="route_id" class="glass-select form-control @error('route_id') is-invalid @enderror" required>
                <option value="">Select Route</option>
                @foreach($routes as $route)
                    <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>{{ $route->origin }} → {{ $route->destination }}</option>
                @endforeach
            </select>
            @error('route_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-calendar me-1"></i>Date</label>
            <input type="date" name="date" class="glass-input form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-cash me-1"></i>Base Price (FRW)</label>
            <input type="number" step="0.01" min="0" name="base_price" class="glass-input form-control @error('base_price') is-invalid @enderror"
                   value="{{ old('base_price', '0.00') }}" placeholder="0.00" required>
            @error('base_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary-glass"><i class="bi bi-save me-1"></i>Save Trip</button>
    </form>
</div>
@endsection
