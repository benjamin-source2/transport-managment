@extends('layouts.app')

@section('title', 'Booking Report - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-journal-text me-2"></i>Booking Report</h1>
    <button type="button" class="btn btn-primary-glass" onclick="window.print()"><i class="bi bi-printer me-1"></i>Print</button>
</div>

<form method="GET" class="glass-card p-3 mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label"><i class="bi bi-search me-1"></i>Search</label>
            <input type="text" name="search" class="glass-input form-control" placeholder="Passenger name..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label"><i class="bi bi-tag me-1"></i>Status</label>
            <select name="status" class="glass-select form-control">
                <option value="">All</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label"><i class="bi bi-calendar me-1"></i>From</label>
            <input type="date" name="date_from" class="glass-input form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label"><i class="bi bi-calendar me-1"></i>To</label>
            <input type="date" name="date_to" class="glass-input form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-3 d-grid">
            <button type="submit" class="btn btn-glass" style="margin-top: 30px;"><i class="bi bi-funnel me-1"></i>Filter</button>
        </div>
    </div>
</form>

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Passenger</th>
                    <th>Route</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td><strong class="text-white">{{ $booking->passenger_name }}</strong></td>
                    <td>{{ $booking->trip->route->origin }} <i class="bi bi-arrow-right text-primary"></i> {{ $booking->trip->route->destination }}</td>
                    <td><i class="bi bi-calendar me-1 text-primary"></i>{{ $booking->trip->date->format('M d, Y') }}</td>
                    <td><strong class="text-white">FRW {{ number_format($booking->price, 2) }}</strong></td>
                    <td>
                        @if($booking->status === 'confirmed')
                            <span class="badge badge-glass success">Confirmed</span>
                        @else
                            <span class="badge badge-glass danger">Cancelled</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $bookings->links() }}</div>
</div>
@endsection
