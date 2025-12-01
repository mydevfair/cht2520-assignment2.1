@extends('layouts.app')

@section('title', 'All Patients')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Patients</h2>
        @can('create-patients')
            <a href="{{ route('patients.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Patient
            </a>
        @endcan
    </div>

    <table id="patientsTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Blood Type</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->age }}</td>
                <td>{{ $patient->sex }}</td>
                <td>{{ $patient->blood_type }}</td>
                <td>{{ $patient->phone }}</td>
                <td>
                    <div class="d-flex justify-content-end gap-2">
                        @can('view-patients')
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-primary btn-sm">View</a>
                        @endcan
                        @can('edit-patients')
                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('delete-patients')
                            <form method="POST" action="{{ route('patients.destroy', $patient->id) }}" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this patient?')">
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
            $('#patientsTable').DataTable({
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
                    { orderable: false, targets: 6 },
                    { className: 'dt-body-right', targets: 6 },
                    { width: '200px', targets: 6 }
                ],
                order: [[0, 'asc']],
                language: {
                    search: "Search patients:",
                    searchPlaceholder: "Name, blood type, phone..."
                }
            });
        });
    </script>
@endpush
