@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <div class="container">
        <h2 class="mb-4">System Reports</h2>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-people"></i> Patient Reports</h5>
                    </div>
                    <div class="card-body">
                        <p>View comprehensive patient statistics and demographics.</p>
                        <a href="{{ route('reports.patients') }}" class="btn btn-primary">View Patient Reports</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Appointment Reports</h5>
                    </div>
                    <div class="card-body">
                        <p>View appointment statistics and scheduling data.</p>
                        <a href="{{ route('reports.appointments') }}" class="btn btn-info">View Appointment Reports</a>
                    </div>
                </div>
            </div>
        </div>

        @can('export-reports')
            <div class="card mt-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-download"></i> Export Data</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('reports.export.patients') }}" class="btn btn-success">
                            <i class="bi bi-file-earmark-excel"></i> Export Patients (CSV)
                        </a>
                        <a href="{{ route('reports.export.appointments') }}" class="btn btn-success">
                            <i class="bi bi-file-earmark-excel"></i> Export Appointments (CSV)
                        </a>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
