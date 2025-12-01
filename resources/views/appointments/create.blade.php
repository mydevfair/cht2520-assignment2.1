@extends('layouts.app')

@section('title', 'Schedule New Appointment')

@section('content')
    <h2>Schedule New Appointment</h2>

    <form method="POST" action="{{ route('appointments.store') }}" novalidate>
        @csrf

        <div class="form-group">
            @error('patient_id')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="patient_id">Patient: <span style="color: red;">*</span></label>
            <select id="patient_id" name="patient_id" class="@error('patient_id') is-invalid @enderror">
                <option value="">-- Select Patient --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }} (ID: {{ $patient->id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            @error('doctor_id')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="doctor_id">Doctor: <span style="color: red;">*</span></label>
            <select id="doctor_id" name="doctor_id" class="@error('doctor_id') is-invalid @enderror">
                <option value="">-- Select Doctor --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->name }} - {{ $doctor->specialty }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            @error('appointment_date')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="appointment_date">Appointment Date: <span style="color: red;">*</span></label>
            <input type="date"
                   id="appointment_date"
                   name="appointment_date"
                   value="{{ old('appointment_date', date('Y-m-d')) }}"
                   class="@error('appointment_date') is-invalid @enderror">
            <small style="color: #666; display: block; margin-top: 5px;">Select a date for the appointment</small>
        </div>

        <div class="form-group">
            @error('appointment_time')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="appointment_time">Appointment Time: <span style="color: red;">*</span></label>
            <input type="time"
                   id="appointment_time"
                   name="appointment_time"
                   value="{{ old('appointment_time', '09:00') }}"
                   class="@error('appointment_time') is-invalid @enderror">
            <small style="color: #666; display: block; margin-top: 5px;">Select time in 24-hour format</small>
        </div>

        <div class="form-group">
            @error('reason')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="reason">Reason for Visit: <span style="color: red;">*</span></label>
            <input type="text"
                   id="reason"
                   name="reason"
                   value="{{ old('reason') }}"
                   class="@error('reason') is-invalid @enderror"
                   placeholder="e.g., General Checkup, Follow-up, Blood Test">
            <small style="color: #666; display: block; margin-top: 5px;">Brief description of the visit reason</small>
        </div>

        <div class="form-group">
            @error('status')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="status">Status: <span style="color: red;">*</span></label>
            <select id="status" name="status" class="@error('status') is-invalid @enderror">
                <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            @error('notes')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="notes">Notes:</label>
            <textarea id="notes"
                      name="notes"
                      rows="4"
                      class="@error('notes') is-invalid @enderror"
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: Arial, sans-serif;"
                      placeholder="Additional notes or instructions (optional)">{{ old('notes') }}</textarea>
            <small style="color: #666; display: block; margin-top: 5px;">Optional: Add any additional notes</small>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-success">Schedule Appointment</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
