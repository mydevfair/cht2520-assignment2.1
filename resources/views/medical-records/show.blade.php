@extends('layouts.app')

@section('title', 'Medical Record Details')

@section('content')
    <div class="detail-card">
        <h2>Medical Record Details</h2>

        <div class="detail-item">
            <strong>ID:</strong>
            <span>{{ $medicalRecord->id }}</span>
        </div>

        <div class="detail-item">
            <strong>Patient:</strong>
            <span>
                <a href="{{ route('patients.show', $medicalRecord->patient->id) }}" style="color: #3498db; text-decoration: none;">
                    {{ $medicalRecord->patient->name }}
                </a>
            </span>
        </div>

        <div class="detail-item">
            <strong>Filename:</strong>
            <span>{{ $medicalRecord->filename }}</span>
        </div>

        <div class="detail-item">
            <strong>File Type:</strong>
            <span>
                @if(str_contains($medicalRecord->mime_type, 'pdf'))
                    <span class="badge bg-danger">PDF</span>
                @elseif(str_contains($medicalRecord->mime_type, 'image'))
                    <span class="badge bg-info">Image</span>
                @else
                    <span class="badge bg-secondary">{{ $medicalRecord->mime_type }}</span>
                @endif
            </span>
        </div>

        <div class="detail-item">
            <strong>File Size:</strong>
            <span>{{ $medicalRecord->formatted_size }}</span>
        </div>

        <div class="detail-item">
            <strong>Description:</strong>
            <span>{{ $medicalRecord->description ?? 'No description provided' }}</span>
        </div>

        <div class="detail-item">
            <strong>Uploaded:</strong>
            <span>{{ $medicalRecord->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <div class="detail-item">
            <strong>Last Updated:</strong>
            <span>{{ $medicalRecord->updated_at->format('d/m/Y H:i') }}</span>
        </div>

        <div class="form-buttons">
            @can('download-medical-records')
                <a href="{{ route('medical-records.download', $medicalRecord->id) }}" class="btn btn-info">
                    Download File
                </a>
            @endcan
            <a href="{{ route('medical-records.index') }}" class="btn btn-primary">Back to List</a>
        </div>
    </div>
@endsection
