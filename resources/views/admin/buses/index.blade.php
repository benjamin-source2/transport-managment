@extends('layouts.app')

@section('title', 'Buses - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-bus-front me-2"></i>Buses</h1>
    <a href="{{ route('admin.buses.create') }}" class="btn btn-primary-glass"><i class="bi bi-plus-circle me-1"></i>Add Bus</a>
</div>

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plate Number</th>
                    <th>Description</th>
                    <th>Capacity</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                <tr>
                    <td>{{ $bus->id }}</td>
                    <td><span class="badge badge-glass info"><i class="bi bi-bus-front me-1"></i>{{ $bus->plate_number }}</span></td>
                    <td class="text-white-50">{{ $bus->description ?? '—' }}</td>
                    <td><span class="badge badge-glass primary"><i class="bi bi-people me-1"></i>{{ $bus->capacity }} seats</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.buses.edit', $bus) }}" class="btn btn-outline-glass btn-sm me-1"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.buses.destroy', $bus) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this bus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger-glass btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $buses->links() }}</div>
</div>
@endsection
