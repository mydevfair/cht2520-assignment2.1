@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2>Dashboard</h2>
                <p class="text-muted">Welcome back, <strong>{{ Auth::user()->name }}</strong></p>
            </div>
        </div>

        <!-- Quick Stats Row -->
        <div class="row mb-4">
            @can('view-patients')
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h3 class="text-primary">{{ $totalPatients }}</h3>
                            <p class="mb-0">Total Patients</p>
                        </div>
                    </div>
                </div>
            @endcan

            @can('view-doctors')
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h3 class="text-success">{{ $totalDoctors }}</h3>
                            <p class="mb-0">Total Doctors</p>
                        </div>
                    </div>
                </div>
            @endcan

            @can('view-appointments')
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h3 class="text-info">{{ $scheduledAppointments }}</h3>
                            <p class="mb-0">Scheduled Appointments</p>
                        </div>
                    </div>
                </div>
            @endcan

            @can('view-medications')
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h3 class="text-warning">{{ $totalMedications }}</h3>
                            <p class="mb-0">Total Medications</p>
                        </div>
                    </div>
                </div>
            @endcan
        </div>

        <!-- Main Navigation Cards -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="mb-3">Management Sections</h4>
            </div>

            <!-- Patients Card -->
            @can('view-patients')
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-person-lines-fill"></i> Patient Management
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage patient records, view details, and update information.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('patients.index') }}" class="btn btn-primary">
                                    View All Patients
                                </a>
                                @can('create-patients')
                                    <a href="{{ route('patients.create') }}" class="btn btn-outline-primary">
                                        Add New Patient
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- Doctors Card -->
            @can('view-doctors')
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-person-badge"></i> Doctor Management
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage doctor profiles, specialties, and contact information.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('doctors.index') }}" class="btn btn-success">
                                    View All Doctors
                                </a>
                                @can('create-doctors')
                                    <a href="{{ route('doctors.create') }}" class="btn btn-outline-success">
                                        Add New Doctor
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- Appointments Card -->
            @can('view-appointments')
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar-check"></i> Appointments
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Schedule and manage patient appointments with doctors.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('appointments.index') }}" class="btn btn-info">
                                    View All Appointments
                                </a>
                                @can('create-appointments')
                                    <a href="{{ route('appointments.create') }}" class="btn btn-outline-info">
                                        Schedule Appointment
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- Medications Card -->
            @can('view-medications')
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-capsule"></i> Medications
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage medication database and patient prescriptions.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('medications.index') }}" class="btn btn-warning text-white">
                                    View All Medications
                                </a>
                                @can('create-medications')
                                    <a href="{{ route('medications.create') }}" class="btn btn-outline-warning">
                                        Add New Medication
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- Medical Records Card -->
            @can('view-medical-records')
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-file-medical"></i> Medical Records
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Upload and manage patient medical documents and files.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('medical-records.index') }}" class="btn btn-danger">
                                    View All Records
                                </a>
                                @can('upload-medical-records')
                                    <a href="{{ route('medical-records.create') }}" class="btn btn-outline-danger">
                                        Upload New Record
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- Activity Log Card (Admin Only) -->
            @can('view-activity-log')
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-clock-history"></i> Activity Log
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">View system activity and audit trail of all actions and user usage</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('activity-log.index') }}" class="btn btn-dark">
                                    View Activity Log
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- User Management Card (Admin Only) -->
            @can('view-users')
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-people-fill"></i> User Management
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage system users, roles, and permissions.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    View All Users
                                </a>
                                @can('create-users')
                                    <a href="{{ route('users.create') }}" class="btn btn-outline-secondary">
                                        Add New User
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- Reports Card -->
            @can('view-reports')
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header" style="background-color: #795548; color: white;">
                            <h5 class="mb-0">
                                <i class="bi bi-file-earmark-bar-graph"></i> Reports
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Generate and export system reports for analysis.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('reports.index') }}" class="btn" style="background-color: #795548; color: white;">
                                    View Reports
                                </a>
                                @can('export-reports')
                                    <a href="{{ route('reports.patients') }}" class="btn btn-outline-secondary">
                                        Patient Reports
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- Advanced Search Card -->
            @can('use-advanced-search')
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-header" style="background-color: #607d8b; color: white;">
                            <h5 class="mb-0">
                                <i class="bi bi-search"></i> Advanced Search
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Search across all records in the system all from one place.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('search.index') }}" class="btn" style="background-color: #607d8b; color: white;">
                                    Search Records
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection
