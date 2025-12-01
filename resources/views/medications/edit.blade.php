@extends('layouts.app')

@section('title', 'Edit Medication')

@section('content')
    <h2>Edit Medication</h2>

    <form method="POST" action="{{ route('medications.update', $medication->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            @error('name')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="name">Medication Name: <span style="color: red;">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $medication->name) }}" required>
        </div>

        <div class="form-group">
            @error('type')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="type">Type: <span style="color: red;">*</span></label>
            <input type="text" id="type" name="type" value="{{ old('type', $medication->type) }}" required>
        </div>

        <div class="form-group">
            @error('manufacturer')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="manufacturer">Manufacturer:</label>
            <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $medication->manufacturer) }}">
        </div>

        <div class="form-group">
            @error('description')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: Arial, sans-serif;">{{ old('description', $medication->description) }}</textarea>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-success">Update Medication</button>
            <a href="{{ route('medications.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
