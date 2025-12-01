@extends('layouts.app')

@section('title', 'All Appointments')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Appointments</h2>
        <div class="d-flex gap-2">
            @can('view-calendar')
                <a href="{{ route('appointments.calendar') }}" class="btn btn-info">
                    <i class="bi bi-calendar"></i> Calendar View
                </a>
            @endcan
            @can('create-appointments')
                <a href="{{ route('appointments.create') }}" class="btn btn-success">
                    Schedule Appointment
                </a>
            @endcan
        </div>
    </div>

    <table id="appointmentsTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->id }}</td>
                <td>{{ $appointment->patient->name }}</td>
                <td>{{ $appointment->doctor->name }}</td>
                <td>{{ $appointment->appointment_date->format('d M Y') }}</td>
                <td>{{ date('H:i', strtotime($appointment->appointment_time)) }}</td>
                <td>{{ Str::limit($appointment->reason, 30) }}</td>
                <td>
                    @if($appointment->status === 'scheduled')
                        <span class="badge bg-primary">Scheduled</span>
                    @elseif($appointment->status === 'completed')
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex justify-content-end gap-2">
                        @can('view-appointments')
                            <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-primary btn-sm">View</a>
                        @endcan
                        @can('edit-appointments')
                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('delete-appointments')
                            <form method="POST" action="{{ route('appointments.destroy', $appointment->id) }}" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this appointment?')">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
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
                columnDefs: [
                    { orderable: false, targets: 7 },
                    { className: 'dt-body-right', targets: 7 },
                    { width: '200px', targets: 7 }
                ],
                order: [[3, 'desc'], [4, 'desc']], // Sort by date and time descending
                language: {
                    search: "Search appointments:",
                    searchPlaceholder: "Patient, doctor, reason..."
                }
            });
        });
    </script>
@endpush
