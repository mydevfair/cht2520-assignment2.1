@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">User Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">ID:</div>
                        <div class="col-md-9">{{ $user->id }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Name:</div>
                        <div class="col-md-9">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Email:</div>
                        <div class="col-md-9">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Role:</div>
                        <div class="col-md-9">
                            <span class="badge bg-info">{{ $user->role_names }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Created:</div>
                        <div class="col-md-9">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Last Updated:</div>
                        <div class="col-md-9">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit User</a>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
