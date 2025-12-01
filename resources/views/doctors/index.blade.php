@extends('layouts.app')

@section('title', 'All Doctors')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Doctors</h2>
        @can('create-doctors')
            <a href="{{ route('doctors.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Doctor
            </a>
        @endcan
    </div>

    <table id="doctorsTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Speciality</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($doctors as $doctor)
            <tr>
                <td>{{ $doctor->id }}</td>
                <td>{{ $doctor->name }}</td>
                <td>{{ $doctor->specialty }}</td>
                <td>
                    <div class="d-flex justify-content-end gap-2">
                        @can('view-doctors')
                            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-primary btn-sm">View</a>
                        @endcan
                        @can('edit-doctors')
                            <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('delete-doctors')
                            <form method="POST" action="{{ route('doctors.destroy', $doctor->id) }}" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this doctor?')">
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
            $('#doctorsTable').DataTable({
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
                    { orderable: false, targets: 3 },
                    { className: 'dt-body-right', targets: 3 },
                    { width: '200px', targets: 3 }
                ],
                order: [[0, 'asc']],
                language: {
                    search: "Search doctors:",
                    searchPlaceholder: "Name, speciality..."
                }
            });
        });
    </script>
@endpush
