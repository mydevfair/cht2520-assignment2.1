@extends('layouts.app')

@section('title', 'Medication Details')

@section('content')
    <div class="detail-card">
        <h2>Medication Details</h2>

        <div class="detail-item">
            <strong>ID:</strong>
            <span>{{ $medication->id }}</span>
        </div>

        <div class="detail-item">
            <strong>Name:</strong>
            <span>{{ $medication->name }}</span>
        </div>

        <div class="detail-item">
            <strong>Type:</strong>
            <span>{{ $medication->type }}</span>
        </div>

        <div class="detail-item">
            <strong>Manufacturer:</strong>
            <span>{{ $medication->manufacturer ?? 'Not specified' }}</span>
        </div>

        <div class="detail-item">
            <strong>Description:</strong>
            <span>{{ $medication->description ?? 'No description available' }}</span>
        </div>

        <div class="detail-item">
            <strong>Patients Taking This Medication:</strong>
            <span>{{ $medication->patients->count() }}</span>
        </div>

        <div class="detail-item">
            <strong>Created:</strong>
            <span>{{ $medication->created_at->format('d M Y H:i') }}</span>
        </div>

        <div class="detail-item">
            <strong>Last Updated:</strong>
            <span>{{ $medication->updated_at->format('d M Y H:i') }}</span>
        </div>

        <div class="form-buttons">
            @can('edit-medications')
                <a href="{{ route('medications.edit', $medication->id) }}" class="btn btn-warning">Edit Medication</a>
            @endcan
            <a href="{{ route('medications.index') }}" class="btn btn-primary">Back to List</a>
        </div>
    </div>
@endsection
