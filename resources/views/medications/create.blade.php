@extends('layouts.app')

@section('title', 'Add New Medication')

@section('content')
    <h2>Add New Medication</h2>

    <form method="POST" action="{{ route('medications.store') }}">
        @csrf

        <div class="form-group">
            @error('name')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="name">Medication Name: <span style="color: red;">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            <small style="color: #666; display: block; margin-top: 5px;">e.g., Paracetamol, Ibuprofen</small>
        </div>

        <div class="form-group">
            @error('type')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="type">Type: <span style="color: red;">*</span></label>
            <input type="text" id="type" name="type" value="{{ old('type') }}" required>
            <small style="color: #666; display: block; margin-top: 5px;">e.g., Analgesic, Antibiotic, NSAID</small>
        </div>

        <div class="form-group">
            @error('manufacturer')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="manufacturer">Manufacturer:</label>
            <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer') }}">
            <small style="color: #666; display: block; margin-top: 5px;">e.g., GSK, Pfizer (optional)</small>
        </div>

        <div class="form-group">
            @error('description')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: Arial, sans-serif;">{{ old('description') }}</textarea>
            <small style="color: #666; display: block; margin-top: 5px;">Brief description of the medication (optional, max 500 characters)</small>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-success">Add Medication</button>
            <a href="{{ route('medications.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
