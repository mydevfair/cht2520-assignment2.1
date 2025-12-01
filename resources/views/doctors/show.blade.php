@extends('layouts.app')

@section('title', 'Doctor Details')

@section('content')
    <div class="detail-card">
        <h2>Doctor Details</h2>

        <div class="detail-item">
            <strong>ID:</strong>
            <span>{{ $doctor->id }}</span>
        </div>

        <div class="detail-item">
            <strong>Name:</strong>
            <span>{{ $doctor->name }}</span>
        </div>

        <div class="detail-item">
            <strong>Specialty:</strong>
            <span>{{ $doctor->specialty }}</span>
        </div>

        <div class="detail-item">
            <strong>Phone:</strong>
            <span>{{ $doctor->phone }}</span>
        </div>

        <div class="detail-item">
            <strong>Email:</strong>
            <span>{{ $doctor->email }}</span>
        </div>

        <div class="form-buttons">
            <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning">Edit Doctor</a>
            <a href="{{ route('doctors.index') }}" class="btn btn-primary">Back to List</a>
        </div>
    </div>
@endsection
