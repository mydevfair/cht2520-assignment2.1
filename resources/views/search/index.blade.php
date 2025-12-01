@extends('layouts.app')

@section('title', 'Advanced Search')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2>Advanced Search</h2>
            <p class="text-muted">Search across patients, doctors, appointments, medications, and medical records</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('search.search') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="query" class="form-label">Search Query</label>
                                <input type="text"
                                       class="form-control @error('query') is-invalid @enderror"
                                       id="query"
                                       name="query"
                                       placeholder="Enter search term..."
                                       value="{{ $query ?? old('query') }}"
                                       required>
                                @error('query')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="form-label">Filter by Type:</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="filters[]"
                                               value="patients"
                                               id="filter_patients"
                                            {{ in_array('patients', $filters ?? []) || empty($filters ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filter_patients">
                                            <span class="badge bg-primary">Patients</span>
                                            @if(isset($filterCounts))
                                                ({{ $filterCounts['patients'] }})
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="filters[]"
                                               value="doctors"
                                               id="filter_doctors"
                                            {{ in_array('doctors', $filters ?? []) || empty($filters ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filter_doctors">
                                            <span class="badge bg-success">Doctors</span>
                                            @if(isset($filterCounts))
                                                ({{ $filterCounts['doctors'] }})
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="filters[]"
                                               value="appointments"
                                               id="filter_appointments"
                                            {{ in_array('appointments', $filters ?? []) || empty($filters ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filter_appointments">
                                            <span class="badge bg-info">Appointments</span>
                                            @if(isset($filterCounts))
                                                ({{ $filterCounts['appointments'] }})
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="filters[]"
                                               value="medications"
                                               id="filter_medications"
                                            {{ in_array('medications', $filters ?? []) || empty($filters ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filter_medications">
                                            <span class="badge bg-warning text-dark">Medications</span>
                                            @if(isset($filterCounts))
                                                ({{ $filterCounts['medications'] }})
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="filters[]"
                                               value="medical_records"
                                               id="filter_medical_records"
                                            {{ in_array('medical_records', $filters ?? []) || empty($filters ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filter_medical_records">
                                            <span class="badge bg-danger">Medical Records</span>
                                            @if(isset($filterCounts))
                                                ({{ $filterCounts['medical_records'] }})
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($results) && $results->isNotEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Search Results ({{ $results->count() }} found)</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($results as $result)
                                <a href="{{ $result['url'] }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1">
                                                <span class="badge bg-{{ $result['badge_color'] }} me-2">{{ $result['type'] }}</span>
                                                {{ $result['title'] }}
                                            </h5>
                                            <p class="mb-1">{{ $result['subtitle'] }}</p>
                                            <small class="text-muted">{{ $result['details'] }}</small>
                                        </div>
                                        <small class="text-muted">ID: {{ $result['id'] }}</small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(isset($query))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5 class="alert-heading">No Results Found</h5>
                    <p class="mb-0">No results found for "<strong>{{ $query }}</strong>". Try a different search term or adjust your filters.</p>
                </div>
            </div>
        </div>
    @endif
@endsection
