@extends('layouts.app')

@section('title', 'My Profile - TranspoGo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-header mb-0"><i class="bi bi-person-circle me-2"></i>My Profile</h1>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="glass-card p-4 text-center">
                    <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                        @csrf
                        <div class="profile-photo-wrapper mx-auto">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" id="profilePreview">
                            <label class="upload-overlay">
                                <i class="bi bi-camera-fill"></i>
                                <input type="file" name="photo" accept="image/*" class="d-none" id="photoInput" onchange="document.getElementById('photoForm').submit()">
                            </label>
                        </div>
                    </form>
                    <h5 class="text-white mt-3 fw-bold">{{ $user->name }}</h5>
                    <span class="badge badge-glass {{ $user->isAdmin() ? 'warning' : 'primary' }}">
                        <i class="bi bi-{{ $user->isAdmin() ? 'shield' : 'person' }} me-1"></i>
                        {{ $user->isAdmin() ? 'Administrator' : 'Client' }}
                    </span>
                    <hr style="border-color: rgba(255,255,255,0.1);">
                    <div class="text-white-50 text-start" style="font-size: 0.85rem;">
                        <div class="mb-1"><i class="bi bi-envelope me-2 text-primary"></i>{{ $user->email }}</div>
                        <div><i class="bi bi-calendar me-2 text-primary"></i>Joined {{ $user->created_at->format('M Y') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="glass-card p-4">
                    <h5 class="text-white fw-bold mb-3"><i class="bi bi-pencil me-2"></i>Edit Profile</h5>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-person me-1"></i>Name</label>
                            <input type="text" name="name" class="glass-input form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-envelope me-1"></i>Email</label>
                            <input type="email" name="email" class="glass-input form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary-glass"><i class="bi bi-save me-1"></i>Update Profile</button>
                    </form>
                </div>

                @if($user->isClient() && $user->bookings()->count() > 0)
                <div class="glass-card p-4 mt-4">
                    <h5 class="text-white fw-bold mb-3"><i class="bi bi-bar-chart me-2"></i>My Stats</h5>
                    <div class="row g-3">
                        <div class="col-4 text-center">
                            <div class="text-white fs-3 fw-bold">{{ $user->bookings()->count() }}</div>
                            <div class="text-white-50" style="font-size: 0.8rem;">Total Tickets</div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="text-white fs-3 fw-bold">FRW {{ number_format($user->bookings()->sum('price'), 0) }}</div>
                            <div class="text-white-50" style="font-size: 0.8rem;">Total Spent</div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="text-white fs-3 fw-bold">{{ $user->bookings()->where('status', 'confirmed')->count() }}</div>
                            <div class="text-white-50" style="font-size: 0.8rem;">Active Tickets</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('photoInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
