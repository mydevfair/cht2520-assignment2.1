@extends('layouts.app')

@section('title', 'Medical Records')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Medical Records</h2>
        @can('upload-medical-records')
            <a href="{{ route('medical-records.create') }}" class="btn btn-success">
                Upload New Record
            </a>
        @endcan
    </div>

    <table id="medicalRecordsTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Filename</th>
            <th>Type</th>
            <th>Size</th>
            <th>Uploaded</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($medicalRecords as $record)
            <tr>
                <td>{{ $record->id }}</td>
                <td>{{ $record->patient->name }}</td>
                <td>{{ $record->filename }}</td>
                <td>
                    @if(str_contains($record->mime_type, 'pdf'))
                        <span class="badge bg-danger">PDF</span>
                    @elseif(str_contains($record->mime_type, 'image'))
                        <span class="badge bg-info">Image</span>
                    @else
                        <span class="badge bg-secondary">File</span>
                    @endif
                </td>
                <td>{{ $record->formatted_size }}</td>
                <td>{{ $record->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="d-flex justify-content-end gap-2">
                        @can('view-medical-records')
                            <a href="{{ route('medical-records.show', $record->id) }}" class="btn btn-primary btn-sm">View</a>
                        @endcan
                        @can('download-medical-records')
                            <a href="{{ route('medical-records.download', $record->id) }}" class="btn btn-info btn-sm">Download</a>
                        @endcan
                        @can('delete-medical-records')
                            <form method="POST" action="{{ route('medical-records.destroy', $record->id) }}" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this medical record?')">
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
            $('#medicalRecordsTable').DataTable({
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
                    { width: '220px', targets: 6 }
                ],
                order: [[0, 'desc']],
                language: {
                    search: "Search records:",
                    searchPlaceholder: "Patient, filename..."
                }
            });
        });
    </script>
@endpush
