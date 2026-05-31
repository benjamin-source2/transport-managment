@extends('layouts.app')

@section('title', 'Bookings - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-ticket-perforated me-2"></i>Bookings</h1>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary-glass"><i class="bi bi-plus-circle me-1"></i>Add Booking</a>
</div>

<form method="GET" class="glass-card p-3 mb-4">
    <div class="row g-2">
        <div class="col-md-3">
            <input type="text" name="search" class="glass-input form-control" placeholder="Search passenger or ID..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="glass-select form-control">
                <option value="">All Status</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_from" class="glass-input form-control" value="{{ request('date_from') }}" placeholder="From">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_to" class="glass-input form-control" value="{{ request('date_to') }}" placeholder="To">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-glass w-100"><i class="bi bi-funnel me-1"></i>Filter</button>
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
                    <th>Bus</th>
                    <th>Route</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>
                        <strong class="text-white">{{ $booking->passenger_name }}</strong>
                        @if($booking->user)<br><small class="text-white-50">{{ $booking->user->name }}</small>@endif
                    </td>
                    <td><span class="badge badge-glass info">{{ $booking->trip->bus->plate_number }}</span></td>
                    <td>{{ $booking->trip->route->origin }} <i class="bi bi-arrow-right text-primary"></i> {{ $booking->trip->route->destination }}</td>
                    <td><i class="bi bi-calendar me-1 text-primary"></i>{{ $booking->trip->date->format('M d, Y') }}</td>
                    <td><strong class="text-white">FRW {{ number_format($booking->price, 2) }}</strong></td>
                    <td>
                        @if($booking->status === 'confirmed')
                            <span class="badge badge-glass success"><i class="bi bi-check me-1"></i>Confirmed</span>
                        @else
                            <span class="badge badge-glass danger"><i class="bi bi-x me-1"></i>Cancelled</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if($booking->status === 'confirmed')
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this booking?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger-glass btn-sm"><i class="bi bi-x-circle"></i> Cancel</button>
                        </form>
                        @else
                        <span class="text-white-50">—</span>
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
