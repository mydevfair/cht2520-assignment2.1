@php use Carbon\Carbon; @endphp

@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
    <h2 style="margin-bottom: 20px;">Patient Details</h2>

    <div class="row">
        <!-- Left Column - Patient Information -->
        <div class="col-md-5">
            <div class="detail-card">
                <h3 style="margin-bottom: 20px; color: #2c3e50;">Basic Information</h3>

                <div class="detail-item">
                    <strong>ID:</strong>
                    <span>{{ $patient->id }}</span>
                </div>

                <div class="detail-item">
                    <strong>Name:</strong>
                    <span>{{ $patient->name }}</span>
                </div>

                <div class="detail-item">
                    <strong>Age:</strong>
                    <span>{{ $patient->age }} years old</span>
                </div>

                <div class="detail-item">
                    <strong>Sex:</strong>
                    <span>{{ $patient->sex }}</span>
                </div>

                <div class="detail-item">
                    <strong>Blood Type:</strong>
                    <span>{{ $patient->blood_type }}</span>
                </div>

                <div class="detail-item">
                    <strong>Phone:</strong>
                    <span>{{ $patient->phone }}</span>
                </div>

                <div class="detail-item">
                    <strong>Registered:</strong>
                    <span>{{ $patient->created_at->format('d M Y') }}</span>
                </div>

                <div class="form-buttons" style="margin-top: 25px;">
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning">Edit Patient</a>
                    <a href="{{ route('patients.index') }}" class="btn btn-primary">Back to List</a>
                </div>
            </div>
        </div>

        <!-- Right Column - Assigned Medications -->
        <div class="col-md-7">
            <div class="detail-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 style="margin: 0; color: #2c3e50;">Assigned Medications</h3>
                    <a href="{{ route('patients.medications.create', $patient->id) }}"
                       class="btn btn-success btn-sm">
                        + Assign Medication
                    </a>
                </div>

                @if($patient->medications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" style="background-color: white; margin-bottom: 0;">
                            <thead style="background-color: #2c3e50; color: white;">
                            <tr>
                                <th>Medication</th>
                                <th>Frequency</th>
                                <th>Dates</th>
                                <th style="width: 140px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($patient->medications as $medication)
                                <tr>
                                    <td>
                                        <strong>{{ $medication->name }}</strong>
                                        <br>
                                        <small style="color: #666;">{{ $medication->type }}</small>
                                        @if($medication->pivot->instructions)
                                            <br>
                                            <small style="color: #3498db;">
                                                <i>{{ Str::limit($medication->pivot->instructions, 50) }}</i>
                                            </small>
                                        @endif
                                    </td>
                                    <td>{{ $medication->pivot->frequency }}</td>
                                    <td>
                                        <strong>Start:</strong> {{ Carbon::parse($medication->pivot->start_date)->format('d M Y') }}
                                        <br>
                                        <strong>End:</strong>
                                        @if($medication->pivot->end_date)
                                            {{ Carbon::parse($medication->pivot->end_date)->format('d M Y') }}
                                        @else
                                            <span style="color: #27ae60; font-weight: bold;">Ongoing</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="GET"
                                              action="{{ route('patients.medications.edit', [$patient->id, $medication->id]) }}"
                                              style="margin-bottom: 2%;">
                                            <button type="submit"
                                                    class="btn btn-warning btn-sm"
                                                    style="width: 100%;">
                                                Edit
                                            </button>
                                        </form>

                                        <form method="POST"
                                              action="{{ route('patients.medications.destroy', [$patient->id, $medication->id]) }}"
                                              style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    style="width: 100%;"
                                                    onclick="return confirm('Remove this medication from patient?')">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 40px; background-color: #f8f9fa; border-radius: 5px;">
                        <p style="color: #999; margin-bottom: 15px; font-size: 16px;">
                            <i class="bi bi-capsule"
                               style="font-size: 48px; display: block; margin-bottom: 10px;"></i>
                            No medications assigned yet
                        </p>
                        <a href="{{ route('patients.medications.create', $patient->id) }}" class="btn btn-success">
                            Assign First Medication
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
