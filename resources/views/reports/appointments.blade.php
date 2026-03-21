@extends('layouts.app')

@section('title', 'Appointment Reports')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Appointment Reports</h2>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    Back to Reports
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Filter Appointments</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.appointments') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-12 d-flex align-items-end gap-2 mt-2">
                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                            <a href="{{ route('reports.appointments') }}" class="btn btn-secondary">Clear</a>
                            @can('export-reports')
                                <a href="{{ route('reports.export.appointments', request()->all()) }}" class="btn btn-success">Export CSV</a>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Appointments by Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Appointments by Doctor</h5>
                </div>
                <div class="card-body">
                    <canvas id="doctorChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Appointments by Month</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Appointment Details</h5>
                </div>
                <div class="card-body">
                    <table id="appointmentsTable" class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->patient->name }}</td>
                                <td>{{ $appointment->doctor->name }}</td>
                                <td>{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                                <td>
                                    @if($appointment->status === 'scheduled')
                                        <span class="badge bg-primary">Scheduled</span>
                                    @elseif($appointment->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>{{ $appointment->reason }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#appointmentsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    'pdf',
                    'print',
                    'colvis'
                ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                responsive: true,
                order: [[3, 'desc']],
                language: {
                    search: "Search appointments:",
                    searchPlaceholder: "Patient, doctor, status..."
                }
            });
        });

        const statusLabels = {!! json_encode($statusStats->pluck('status')->map(fn($s) => ucfirst($s))) !!};
        const statusData = {!! json_encode($statusStats->pluck('count')) !!};

        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Number of Appointments',
                    data: statusData,
                    backgroundColor: ['#3498db', '#27ae60', '#e74c3c']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        const doctorLabels = {!! json_encode($appointmentsByDoctor->pluck('doctor.name')) !!};
        const doctorData = {!! json_encode($appointmentsByDoctor->pluck('count')) !!};

        const doctorCtx = document.getElementById('doctorChart').getContext('2d');
        new Chart(doctorCtx, {
            type: 'doughnut',
            data: {
                labels: doctorLabels,
                datasets: [{
                    data: doctorData,
                    backgroundColor: [
                        '#e74c3c', '#3498db', '#2ecc71', '#f39c12',
                        '#9b59b6', '#1abc9c', '#e67e22', '#34495e'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthData = Array(12).fill(0);

        {!! json_encode($appointmentsByMonth) !!}.forEach(item => {
            monthData[item.month - 1] = item.count;
        });

        const monthCtx = document.getElementById('monthChart').getContext('2d');
        new Chart(monthCtx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Appointments',
                    data: monthData,
                    borderColor: '#f39c12',
                    backgroundColor: 'rgba(243, 156, 18, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
