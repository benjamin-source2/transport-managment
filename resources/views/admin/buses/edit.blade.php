@extends('layouts.app')

@section('title', 'Edit Bus - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-header mb-0"><i class="bi bi-pencil me-2"></i>Edit Bus</h1>
    <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-glass"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="glass-card p-4" style="max-width: 600px;">
    <form action="{{ route('admin.buses.update', $bus) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-tag me-1"></i>Plate Number</label>
            <input type="text" name="plate_number" class="glass-input form-control @error('plate_number') is-invalid @enderror"
                   value="{{ old('plate_number', $bus->plate_number) }}" required>
            @error('plate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-person-seat me-1"></i>Capacity</label>
            <input type="number" name="capacity" class="glass-input form-control @error('capacity') is-invalid @enderror"
                   value="{{ old('capacity', $bus->capacity) }}" min="1" required>
            @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-card-text me-1"></i>Description</label>
            <textarea name="description" class="glass-input form-control" rows="2">{{ old('description', $bus->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-image me-1"></i>Image</label>
            <input type="file" name="image" class="glass-input form-control" accept="image/*">
            @if($bus->image_path)
                <small class="text-white-50 mt-1 d-block">Current image uploaded</small>
            @endif
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary-glass"><i class="bi bi-save me-1"></i>Update Bus</button>
    </form>
</div>
@endsection
