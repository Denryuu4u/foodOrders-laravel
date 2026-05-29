@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="d-flex align-items-center mb-4 gap-2">
    <a href="{{ route('dashboard') }}" class="text-white text-decoration-none">
        <i class="bi bi-arrow-left fs-5"></i>
    </a>
    <h2 class="fw-bold mb-0">MY PROFILE</h2>
</div>

<div class="d-flex gap-3 flex-wrap">

    {{-- ─── LEFT: Profile Picture ─────────────────────────────── --}}
    <div class="card-dark p-3 rounded d-flex flex-column align-items-center" style="width: 220px; min-width: 220px;">
        <img src="{{ $user->profile_picture_url }}"
             alt="Profile Picture"
             class="rounded-circle mb-3"
             style="width: 130px; height: 130px; object-fit: cover; border: 3px solid #343a40;">

        <p class="fw-semibold mb-0 text-center">{{ $user->name }}</p>
        <p class="text-secondary small mb-3">{{ $user->email }}</p>

        <span class="badge {{ $user->role === 'Admin' ? 'bg-danger' : 'bg-secondary' }} mb-3">
            {{ $user->role }}
        </span>

        {{-- Upload picture form --}}
        <form method="POST" action="{{ route('profile.picture') }}" enctype="multipart/form-data" class="w-100">
            @csrf
            <div class="mb-2">
                <input type="file" class="form-control form-control-sm" name="profile_picture"
                       accept=".jpg,.jpeg,.png" required>
                <small class="text-secondary">JPG, JPEG, PNG — max 2MB</small>
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100">
                <i class="bi bi-camera-fill me-1"></i> Change Photo
            </button>
        </form>
    </div>

    {{-- ─── RIGHT: Info + Password ─────────────────────────────── --}}
    <div class="card-dark p-4 rounded flex-grow-1">
        <h5 class="fw-bold mb-4">User Profile</h5>

        {{-- Info form --}}
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Address:</label>
                    <input type="text" class="form-control" name="address"
                           value="{{ old('address', $user->address) }}" placeholder="Optional">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gender:</label>
                    <select class="form-select" name="gender">
                        <option value="">— Select —</option>
                        @foreach(['Male','Female','Other','Prefer not to say'] as $g)
                        <option value="{{ $g }}" {{ old('gender', $user->gender) === $g ? 'selected' : '' }}>
                            {{ $g }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mb-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save-fill me-1"></i> Save Changes
                </button>
                <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

        <hr class="border-secondary">

        {{-- Password form --}}
        <h6 class="fw-bold mb-3">Change Password</h6>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Current Password:</label>
                <input type="password" class="form-control" name="current_password"
                       placeholder="Enter current password">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">New Password:</label>
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                           name="new_password" placeholder="Enter new password">
                    @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control"
                           name="new_password_confirmation" placeholder="Confirm new password">
                </div>
            </div>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-lock-fill me-1"></i> Update Password
            </button>
        </form>
    </div>

</div>
@endsection
