@extends('layouts.app')

@section('title', 'Add Bus - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-plus-circle me-2"></i>Add Bus</h1>
    <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-glass"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="glass-card p-4" style="max-width: 600px;">
    <form action="{{ route('admin.buses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-tag me-1"></i>Plate Number</label>
            <input type="text" name="plate_number" class="glass-input form-control @error('plate_number') is-invalid @enderror"
                   value="{{ old('plate_number') }}" placeholder="e.g., RAB 1234" required>
            @error('plate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-person-seat me-1"></i>Capacity</label>
            <input type="number" name="capacity" class="glass-input form-control @error('capacity') is-invalid @enderror"
                   value="{{ old('capacity') }}" min="1" placeholder="Number of seats" required>
            @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-card-text me-1"></i>Description</label>
            <textarea name="description" class="glass-input form-control" rows="2" placeholder="Optional description...">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-image me-1"></i>Image (optional)</label>
            <input type="file" name="image" class="glass-input form-control" accept="image/*">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary-glass"><i class="bi bi-save me-1"></i>Save Bus</button>
    </form>
</div>
@endsection
