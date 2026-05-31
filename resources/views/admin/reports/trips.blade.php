@extends('layouts.app')

@section('title', 'Trip Report - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-calendar-check me-2"></i>Trip Report</h1>
    <button type="button" class="btn btn-primary-glass" onclick="window.print()"><i class="bi bi-printer me-1"></i>Print</button>
</div>

<form method="GET" class="glass-card p-3 mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label"><i class="bi bi-calendar me-1"></i>From Date</label>
            <input type="date" name="date_from" class="glass-input form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label"><i class="bi bi-calendar me-1"></i>To Date</label>
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
                    <th>Date</th>
                    <th>Bus</th>
                    <th>Route</th>
                    <th>Booked</th>
                    <th>Available</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trips as $trip)
                <tr>
                    <td><i class="bi bi-calendar me-1 text-primary"></i>{{ $trip->date->format('M d, Y') }}</td>
                    <td><span class="badge badge-glass info">{{ $trip->bus->plate_number }}</span></td>
                    <td>{{ $trip->route->origin }} <i class="bi bi-arrow-right text-primary"></i> {{ $trip->route->destination }}</td>
                    <td><span class="badge badge-glass secondary">{{ $trip->bookings->count() }}</span></td>
                    <td>
                        @if($trip->remainingSeats() > 0)
                            <span class="badge badge-glass success">{{ $trip->remainingSeats() }} left</span>
                        @else
                            <span class="badge badge-glass danger">Full</span>
                        @endif
                    </td>
                    <td><strong class="text-white">FRW {{ number_format($trip->totalRevenue(), 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $trips->links() }}</div>
</div>
@endsection
