@extends('layouts.app')

@section('title', 'All Users')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Users</h2>
        @can('create-users')
            <a href="{{ route('users.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New User
            </a>
        @endcan
    </div>

    <table id="usersTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role_names }}</td>
                <td>
                    <div class="d-flex justify-content-end gap-2">
                        @can('view-users')
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary btn-sm">View</a>
                        @endcan
                        @can('edit-users')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('delete-users')
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this user?')">
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
            $('#usersTable').DataTable({
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
                    { width: '200px', targets: 4 }
                ],
                order: [[0, 'asc']],
                language: {
                    search: "Search users:",
                    searchPlaceholder: "Name, email, role..."
                }
            });
        });
    </script>
@endpush
