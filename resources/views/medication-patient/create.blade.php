@extends('layouts.app')

@section('title', 'Assign Medication to Patient')

@section('content')
    <h2>Assign Medication to {{ $patient->name }}</h2>

    <div class="mb-3">
        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-secondary">
            ← Back to Patient Details
        </a>
    </div>

    <form method="POST" action="{{ route('patients.medications.store', $patient->id) }}">
        @csrf

        <div class="form-group">
            @error('medication_id')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="medication_id">Select Medication: <span style="color: red;">*</span></label>
            <select id="medication_id" name="medication_id" required>
                <option value="">-- Select Medication --</option>
                @foreach($medications as $medication)
                    <option value="{{ $medication->id }}"
                        {{ old('medication_id') == $medication->id ? 'selected' : '' }}
                        {{ in_array($medication->id, $assignedMedications) ? 'disabled' : '' }}>
                        {{ $medication->name }} ({{ $medication->type }})
                        {{ in_array($medication->id, $assignedMedications) ? ' - Already Assigned' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            @error('frequency')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="frequency">Frequency: <span style="color: red;">*</span></label>
            <select id="frequency" name="frequency" required>
                <option value="">-- Select Frequency --</option>
                <option value="Once daily" {{ old('frequency') == 'Once daily' ? 'selected' : '' }}>Once daily</option>
                <option value="Twice daily" {{ old('frequency') == 'Twice daily' ? 'selected' : '' }}>Twice daily</option>
                <option value="Three times daily" {{ old('frequency') == 'Three times daily' ? 'selected' : '' }}>Three times daily</option>
                <option value="Four times daily" {{ old('frequency') == 'Four times daily' ? 'selected' : '' }}>Four times daily</option>
                <option value="Every 4 hours" {{ old('frequency') == 'Every 4 hours' ? 'selected' : '' }}>Every 4 hours</option>
                <option value="Every 6 hours" {{ old('frequency') == 'Every 6 hours' ? 'selected' : '' }}>Every 6 hours</option>
                <option value="Every 8 hours" {{ old('frequency') == 'Every 8 hours' ? 'selected' : '' }}>Every 8 hours</option>
                <option value="Once weekly" {{ old('frequency') == 'Once weekly' ? 'selected' : '' }}>Once weekly</option>
                <option value="As needed" {{ old('frequency') == 'As needed' ? 'selected' : '' }}>As needed</option>
                <option value="Before bed" {{ old('frequency') == 'Before bed' ? 'selected' : '' }}>Before bed</option>
                <option value="With meals" {{ old('frequency') == 'With meals' ? 'selected' : '' }}>With meals</option>
            </select>
        </div>

        <div class="form-group">
            @error('start_date')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="start_date">Start Date: <span style="color: red;">*</span></label>
            <input type="date" id="start_date" name="start_date"
                   value="{{ old('start_date', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            @error('end_date')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}">
            <small style="color: #666; display: block; margin-top: 5px;">Leave blank if ongoing</small>
        </div>

        <div class="form-group">
            @error('instructions')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" rows="4"
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: Arial, sans-serif;">{{ old('instructions') }}</textarea>
            <small style="color: #666; display: block; margin-top: 5px;">e.g., Take with food, Avoid alcohol, etc.</small>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-success">Assign Medication</button>
            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
