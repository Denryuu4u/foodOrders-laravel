@extends('layouts.app')
@section('title', 'Users Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">USERS MANAGEMENT</h2>
    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus-fill me-1"></i> Add New User
    </button>
</div>

{{-- ─── USERS TABLE ──────────────────────────────────────────── --}}
<div class="card-dark p-3 rounded">
    <table class="table table-dark table-bordered table-hover mb-0">
        <thead class="table-light text-dark">
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge {{ $user->role === 'Admin' ? 'bg-danger' : 'bg-secondary' }}">
                        {{ $user->role }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal{{ $user->id }}">
                        <i class="bi bi-pencil-fill"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal{{ $user->id }}">
                        <i class="bi bi-trash-fill"></i> Delete
                    </button>
                </td>
            </tr>

            {{-- Edit Modal --}}
            <div class="modal fade" id="editUserModal{{ $user->id }}" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <form method="POST" action="{{ route('users.update', $user) }}">
                            @csrf @method('PUT')
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title">Edit User</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Full Name:</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email:</label>
                                    <input type="email" class="form-control" name="email"
                                           value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Role:</label>
                                    <select class="form-select" name="role">
                                        <option value="User"  {{ $user->role === 'User'  ? 'selected' : '' }}>User</option>
                                        <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-save-fill me-1"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <form method="POST" action="{{ route('users.destroy', $user) }}">
                            @csrf @method('DELETE')
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title">Delete User</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <strong>{{ $user->name }}</strong>?</p>
                                <p class="text-danger small">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash-fill me-1"></i> Confirm Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @empty
            <tr>
                <td colspan="6" class="text-center text-secondary py-4">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ─── ADD USER MODAL ──────────────────────────────────────────── --}}
<div class="modal fade" id="addUserModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name:</label>
                        <input type="text" class="form-control" name="name"
                               placeholder="Enter full name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email"
                               placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password"
                               placeholder="Enter password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role:</label>
                        <select class="form-select" name="role">
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus-fill me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
