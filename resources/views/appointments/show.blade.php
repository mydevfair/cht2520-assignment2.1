@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
    <div class="detail-card">
        <h2>Appointment Details</h2>

        <div class="detail-item">
            <strong>ID:</strong>
            <span>{{ $appointment->id }}</span>
        </div>

        <div class="detail-item">
            <strong>Patient:</strong>
            <span>
                <a href="{{ route('patients.show', $appointment->patient->id) }}" style="color: #3498db; text-decoration: none;">
                    {{ $appointment->patient->name }}
                </a>
            </span>
        </div>

        <div class="detail-item">
            <strong>Doctor:</strong>
            <span>
                <a href="{{ route('doctors.show', $appointment->doctor->id) }}" style="color: #3498db; text-decoration: none;">
                    {{ $appointment->doctor->name }}
                </a> ({{ $appointment->doctor->specialty }})
            </span>
        </div>

        <div class="detail-item">
            <strong>Appointment Date:</strong>
            <span>{{ $appointment->appointment_date->format('l, d F Y') }}</span>
        </div>

        <div class="detail-item">
            <strong>Appointment Time:</strong>
            <span>{{ date('H:i', strtotime($appointment->appointment_time)) }}</span>
        </div>

        <div class="detail-item">
            <strong>Reason:</strong>
            <span>{{ $appointment->reason }}</span>
        </div>

        <div class="detail-item">
            <strong>Status:</strong>
            <span>
                @if($appointment->status === 'scheduled')
                    <span class="badge bg-primary">Scheduled</span>
                @elseif($appointment->status === 'completed')
                    <span class="badge bg-success">Completed</span>
                @else
                    <span class="badge bg-danger">Cancelled</span>
                @endif
            </span>
        </div>

        <div class="detail-item">
            <strong>Notes:</strong>
            <span>{{ $appointment->notes ?? 'No notes available' }}</span>
        </div>

        <div class="detail-item">
            <strong>Created:</strong>
            <span>{{ $appointment->created_at->format('d M Y H:i') }}</span>
        </div>

        <div class="detail-item">
            <strong>Last Updated:</strong>
            <span>{{ $appointment->updated_at->format('d M Y H:i') }}</span>
        </div>

        <div class="form-buttons">
            @can('edit-appointments')
                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning">Edit Appointment</a>
            @endcan
            <a href="{{ route('appointments.index') }}" class="btn btn-primary">Back to List</a>
        </div>
    </div>
@endsection
