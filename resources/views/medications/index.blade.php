@extends('layouts.app')

@section('title', 'All Medications')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Medications</h2>
        @can('create-medications')
            <a href="{{ route('medications.create') }}" class="btn btn-success">
                Add New Medication
            </a>
        @endcan
    </div>

    <table id="medicationsTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Manufacturer</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($medications as $medication)
            <tr>
                <td>{{ $medication->id }}</td>
                <td>{{ $medication->name }}</td>
                <td>{{ $medication->type }}</td>
                <td>{{ $medication->manufacturer ?? 'N/A' }}</td>
                <td>
                    <div class="d-flex justify-content-end gap-2">
                        @can('view-medications')
                            <a href="{{ route('medications.show', $medication->id) }}" class="btn btn-primary btn-sm">View</a>
                        @endcan
                        @can('edit-medications')
                            <a href="{{ route('medications.edit', $medication->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('delete-medications')
                            <form method="POST" action="{{ route('medications.destroy', $medication->id) }}" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this medication?')">
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
            $('#medicationsTable').DataTable({
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
                    { orderable: false, targets: 4 },
                    { className: 'dt-body-right', targets: 4 },
                    { width: '180px', targets: 4 }
                ],
                order: [[0, 'asc']],
                language: {
                    search: "Search medications:",
                    searchPlaceholder: "Name, type, manufacturer..."
                }
            });
        });
    </script>
@endpush
