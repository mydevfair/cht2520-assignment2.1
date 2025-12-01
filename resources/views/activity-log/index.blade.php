@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>System Activity Log</h2>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            Back to Dashboard
        </a>
    </div>

    <div class="mb-3 p-3" style="background-color: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="filter_model" class="form-label">Filter by Model:</label>
                <select id="filter_model" class="form-select">
                    <option value="">All Models</option>
                    @foreach($modelTypes as $modelType)
                        <option value="{{ $modelType }}">{{ $modelType }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="filter_event" class="form-label">Filter by Event:</label>
                <select id="filter_event" class="form-select">
                    <option value="">All Events</option>
                    <option value="created">Created</option>
                    <option value="updated">Updated</option>
                    <option value="deleted">Deleted</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="filter_user" class="form-label">Filter by User:</label>
                <select id="filter_user" class="form-select">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="button" id="clear_filters" class="btn btn-secondary w-100">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    <table id="activityTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date/Time</th>
            <th>User</th>
            <th>Event</th>
            <th>Subject</th>
            <th>Description</th>
            <th>Changes</th>
        </tr>
        </thead>
        <tbody>
        @foreach($activities as $activity)
            <tr>
                <td>{{ $activity->id }}</td>
                <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    @if($activity->causer)
                        <a href="{{ route('users.show', $activity->causer_id) }}">
                            {{ $activity->causer->name }}
                        </a>
                    @else
                        <span class="text-muted">System</span>
                    @endif
                </td>
                <td>
                    @if($activity->event === 'created')
                        <span class="badge bg-success">Created</span>
                    @elseif($activity->event === 'updated')
                        <span class="badge bg-warning text-dark">Updated</span>
                    @elseif($activity->event === 'deleted')
                        <span class="badge bg-danger">Deleted</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($activity->event) }}</span>
                    @endif
                </td>
                <td>
                    @if($activity->subject)
                        @php
                            $subjectName = $activity->subject->name ?? $activity->subject->title ?? 'Record #' . $activity->subject_id;
                        @endphp
                        {{ $subjectName }} (#{{ $activity->subject_id }})
                    @else
                        <span class="text-muted">Deleted Record (#{{ $activity->subject_id }})</span>
                    @endif
                </td>
                <td>{{ $activity->description }}</td>
                <td>
                    @php
                        $properties = $activity->properties ?? collect();
                        $changes = [];

                        if ($properties->has('attributes') && $properties->has('old')) {
                            $attributes = $properties->get('attributes');
                            $old = $properties->get('old');

                            foreach ($attributes as $key => $newValue) {
                                if (isset($old[$key]) && $old[$key] != $newValue) {
                                    $oldDisplay = is_string($old[$key]) && strlen($old[$key]) > 20
                                        ? substr($old[$key], 0, 20) . '...'
                                        : $old[$key];
                                    $newDisplay = is_string($newValue) && strlen($newValue) > 20
                                        ? substr($newValue, 0, 20) . '...'
                                        : $newValue;
                                    $changes[] = "{$key}: {$oldDisplay} → {$newDisplay}";
                                }
                            }
                        }
                    @endphp

                    @if(count($changes) > 0)
                        <small>{{ implode(', ', $changes) }}</small>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#activityTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    'pdf',
                    'print',
                    'colvis'
                ],
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                responsive: true,
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: true, targets: '_all' }
                ],
                language: {
                    search: "Search activity log:",
                    searchPlaceholder: "User, description..."
                }
            });

            $('#filter_model').on('change', function() {
                table.column(5).search(this.value).draw();
            });

            $('#filter_event').on('change', function() {
                table.column(3).search(this.value).draw();
            });

            $('#filter_user').on('change', function() {
                table.column(2).search(this.value).draw();
            });

            $('#clear_filters').on('click', function() {
                $('#filter_model').val('');
                $('#filter_event').val('');
                $('#filter_user').val('');
                table.search('').columns().search('').draw();
            });
        });
    </script>
@endpush
