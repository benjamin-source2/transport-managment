@extends('layouts.app')

@section('title', 'Routes - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-signpost-2 me-2"></i>Routes</h1>
    <a href="{{ route('admin.routes.create') }}" class="btn btn-primary-glass"><i class="bi bi-plus-circle me-1"></i>Add Route</a>
</div>

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($routes as $route)
                <tr>
                    <td>{{ $route->id }}</td>
                    <td><span class="badge badge-glass success"><i class="bi bi-geo-alt me-1"></i>{{ $route->origin }}</span></td>
                    <td><span class="badge badge-glass primary"><i class="bi bi-geo-alt-fill me-1"></i>{{ $route->destination }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.routes.edit', $route) }}" class="btn btn-outline-glass btn-sm me-1"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this route?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger-glass btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $routes->links() }}</div>
</div>
@endsection
