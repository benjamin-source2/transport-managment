@extends('layouts.app')

@section('title', 'Trips - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-calendar-event me-2"></i>Trips</h1>
    <a href="{{ route('admin.trips.create') }}" class="btn btn-primary-glass"><i class="bi bi-plus-circle me-1"></i>Add Trip</a>
</div>

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bus</th>
                    <th>Route</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Availability</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trips as $trip)
                <tr>
                    <td>{{ $trip->id }}</td>
                    <td><span class="badge badge-glass info"><i class="bi bi-bus-front me-1"></i>{{ $trip->bus->plate_number }}</span></td>
                    <td>{{ $trip->route->origin }} <i class="bi bi-arrow-right text-primary"></i> {{ $trip->route->destination }}</td>
                    <td><i class="bi bi-calendar me-1 text-primary"></i>{{ $trip->date->format('M d, Y') }}</td>
                    <td><strong class="text-white">FRW {{ number_format($trip->base_price, 2) }}</strong></td>
                    <td>
                        @php $remaining = $trip->remainingSeats(); @endphp
                        @if($remaining > 5)
                            <span class="badge badge-glass success">{{ $remaining }} left</span>
                        @elseif($remaining > 0)
                            <span class="badge badge-glass warning">{{ $remaining }} left</span>
                        @else
                            <span class="badge badge-glass danger">Full</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.trips.edit', $trip) }}" class="btn btn-outline-glass btn-sm me-1"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this trip?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger-glass btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $trips->links() }}</div>
</div>
@endsection
