@extends('layouts.app')

@section('title', 'Edit Route - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-pencil me-2"></i>Edit Route</h1>
    <a href="{{ route('admin.routes.index') }}" class="btn btn-outline-glass"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="glass-card p-4" style="max-width: 600px;">
    <form action="{{ route('admin.routes.update', $route) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-geo-alt me-1"></i>Origin</label>
            <input type="text" name="origin" class="glass-input form-control @error('origin') is-invalid @enderror"
                   value="{{ old('origin', $route->origin) }}" required>
            @error('origin') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-geo-alt-fill me-1"></i>Destination</label>
            <input type="text" name="destination" class="glass-input form-control @error('destination') is-invalid @enderror"
                   value="{{ old('destination', $route->destination) }}" required>
            @error('destination') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary-glass"><i class="bi bi-save me-1"></i>Update Route</button>
    </form>
</div>
@endsection
