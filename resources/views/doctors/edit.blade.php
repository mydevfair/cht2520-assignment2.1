@extends('layouts.app')

@section('title', 'Edit Doctor')

@section('content')
    <h2>Edit Doctor</h2>

    <form method="POST" action="{{ route('doctors.update', $doctor->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            @error('name')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $doctor->name) }}">
        </div>

        <div class="form-group">
            @error('specialty')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="specialty">Specialty:</label>
            <input type="text" id="specialty" name="specialty" value="{{ old('specialty', $doctor->specialty) }}">
        </div>

        <div class="form-group">
            @error('phone')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}">
        </div>

        <div class="form-group">
            @error('email')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $doctor->email) }}">
        </div>

        <button type="submit" class="btn btn-success">Update Doctor</button>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

@endsection
