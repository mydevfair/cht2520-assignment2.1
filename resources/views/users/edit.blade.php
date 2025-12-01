@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>Edit User: {{ $user->name }}</h2>

            <form method="POST" action="{{ route('users.update', $user->id) }}" class="mt-4">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror"
                            id="role"
                            name="role"
                            required>
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">
                <h5 class="mb-3">Change Password (Optional)</h5>
                <p class="text-muted small">Leave blank to keep current password</p>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Minimum 8 characters</small>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password"
                           class="form-control"
                           id="password_confirmation"
                           name="password_confirmation">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Update User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
