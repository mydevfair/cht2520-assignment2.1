@extends('layouts.app')

@section('title', 'Patient Reports')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Patient Reports</h2>
                <div class="d-flex gap-2">
                    @can('export-reports')
                        <a href="{{ route('reports.export.patients') }}" class="btn btn-success">
                            Export CSV
                        </a>
                    @endcan
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                        Back to Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Blood Type Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="bloodTypeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Age Group Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="ageGroupChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Gender Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="sexChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Statistics Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        @foreach($bloodTypeStats as $stat)
                            <tr>
                                <td><strong>{{ $stat->blood_type }}</strong></td>
                                <td>{{ $stat->count }} patients</td>
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
        const bloodTypeLabels = {!! json_encode($bloodTypeStats->pluck('blood_type')) !!};
        const bloodTypeData = {!! json_encode($bloodTypeStats->pluck('count')) !!};

        const bloodTypeCtx = document.getElementById('bloodTypeChart').getContext('2d');
        new Chart(bloodTypeCtx, {
            type: 'pie',
            data: {
                labels: bloodTypeLabels,
                datasets: [{
                    data: bloodTypeData,
                    backgroundColor: [
                        '#e74c3c',
                        '#3498db',
                        '#2ecc71',
                        '#f39c12',
                        '#9b59b6',
                        '#1abc9c',
                        '#e67e22',
                        '#34495e'
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

        const ageGroupLabels = {!! json_encode(array_keys($ageGroups)) !!};
        const ageGroupData = {!! json_encode(array_values($ageGroups)) !!};

        const ageGroupCtx = document.getElementById('ageGroupChart').getContext('2d');
        new Chart(ageGroupCtx, {
            type: 'bar',
            data: {
                labels: ageGroupLabels,
                datasets: [{
                    label: 'Number of Patients',
                    data: ageGroupData,
                    backgroundColor: '#27ae60'
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

        const sexLabels = {!! json_encode($sexStats->pluck('sex')) !!};
        const sexData = {!! json_encode($sexStats->pluck('count')) !!};

        const sexCtx = document.getElementById('sexChart').getContext('2d');
        new Chart(sexCtx, {
            type: 'doughnut',
            data: {
                labels: sexLabels,
                datasets: [{
                    data: sexData,
                    backgroundColor: ['#3498db', '#e74c3c']
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
    </script>
@endpush
