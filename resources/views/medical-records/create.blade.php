@extends('layouts.app')

@section('title', 'Upload Medical Record')

@section('content')
    <h2>Upload Medical Record</h2>

    <form method="POST" action="{{ route('medical-records.store') }}" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="form-group">
            @error('patient_id')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="patient_id">Patient: <span style="color: red;">*</span></label>
            <select id="patient_id" name="patient_id" class="@error('patient_id') is-invalid @enderror" required>
                <option value="">-- Select Patient --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }} (ID: {{ $patient->id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            @error('file')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="file">Medical Record File: <span style="color: red;">*</span></label>
            <input type="file"
                   id="file"
                   name="file"
                   class="@error('file') is-invalid @enderror"
                   accept=".pdf,.jpg,.jpeg,.png"
                   required>
            <small style="color: #666; display: block; margin-top: 5px;">
                Allowed file types: PDF, JPG, JPEG, PNG (Max 10MB)
            </small>
        </div>

        <div class="form-group">
            @error('description')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="description">Description:</label>
            <textarea id="description"
                      name="description"
                      rows="4"
                      class="@error('description') is-invalid @enderror"
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: Arial, sans-serif;"
                      placeholder="Brief description of the medical record (optional)">{{ old('description') }}</textarea>
            <small style="color: #666; display: block; margin-top: 5px;">
                Optional: Add notes about this medical record (max 500 characters)
            </small>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-success">Upload Record</button>
            <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
