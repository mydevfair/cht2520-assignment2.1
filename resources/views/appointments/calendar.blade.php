@extends('layouts.app')

@section('title', 'Appointments Calendar')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Appointments Calendar</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('appointments.index') }}" class="btn btn-primary">
                <i class="bi bi-list"></i> List View
            </a>
            @can('create-appointments')
                <a href="{{ route('appointments.create') }}" class="btn btn-success">
                    Schedule Appointment
                </a>
            @endcan
        </div>
    </div>

    <div class="mb-3 p-3" style="background-color: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <form method="GET" action="{{ route('appointments.calendar') }}" class="row g-3">
            <div class="col-md-4">
                <label for="filter_doctor" class="form-label">Filter by Doctor:</label>
                <select name="doctor_id" id="filter_doctor" class="form-select">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="filter_patient" class="form-label">Filter by Patient:</label>
                <select name="patient_id" id="filter_patient" class="form-select">
                    <option value="">All Patients</option>
                    @foreach($patients as $patient)
                        <option
                            value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="filter_status" class="form-label">Filter by Status:</label>
                <select name="status" id="filter_status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled
                    </option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('appointments.calendar') }}" class="btn btn-secondary">Clear Filters</a>
            </div>
        </form>
    </div>

    <div class="mb-3 p-3" style="background-color: #f8f9fa; border-radius: 5px;">
        <strong>Legend:</strong>
        <span class="badge" style="background-color: #3498db; margin-left: 10px;">Scheduled</span>
        <span class="badge" style="background-color: #27ae60; margin-left: 10px;">Completed</span>
        <span class="badge" style="background-color: #e74c3c; margin-left: 10px;">Cancelled</span>
    </div>

    <div class="table-responsive">
        <div id="calendar"
             style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); min-width: 300px;"></div>
    </div>

    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="appointmentModalBody">
                    <!-- Modal content -->
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        @can('edit-appointments')
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="statusDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Quick Status Change
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                                    <li><a class="dropdown-item" href="#"
                                           onclick="quickStatusChange('scheduled'); return false;">
                                            <span class="badge" style="background-color: #3498db;">Scheduled</span>
                                        </a></li>
                                    <li><a class="dropdown-item" href="#"
                                           onclick="quickStatusChange('completed'); return false;">
                                            <span class="badge" style="background-color: #27ae60;">Completed</span>
                                        </a></li>
                                    <li><a class="dropdown-item" href="#"
                                           onclick="quickStatusChange('cancelled'); return false;">
                                            <span class="badge" style="background-color: #e74c3c;">Cancelled</span>
                                        </a></li>
                                </ul>
                            </div>
                        @endcan
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="#" id="viewAppointmentBtn" class="btn btn-primary">View Details</a>
                        @can('edit-appointments')
                            <a href="#" id="editAppointmentBtn" class="btn btn-warning">Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet'/>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <script>
        let currentAppointmentId = null;

        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',

                headerToolbar: window.innerWidth < 768 ? {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                } : {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },

                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day',
                    list: 'List'
                },

                height: 'auto',
                navLinks: true,
                editable: false,
                dayMaxEvents: true,

                events: [
                        @foreach($appointments as $appointment)
                    {
                        id: '{{ $appointment->id }}',
                        title: '{{ addslashes($appointment->patient->name) }} - {{ addslashes($appointment->doctor->name) }}',
                        start: '{{ $appointment->appointment_date->format('Y-m-d') }}T{{ date('H:i:s', strtotime($appointment->appointment_time)) }}',
                        backgroundColor: '{{ $appointment->status === "scheduled" ? "#3498db" : ($appointment->status === "completed" ? "#27ae60" : "#e74c3c") }}',
                        borderColor: '{{ $appointment->status === "scheduled" ? "#2980b9" : ($appointment->status === "completed" ? "#229954" : "#c0392b") }}',
                        extendedProps: {
                            patient: '{{ addslashes($appointment->patient->name) }}',
                            doctor: '{{ addslashes($appointment->doctor->name) }}',
                            specialty: '{{ addslashes($appointment->doctor->specialty) }}',
                            reason: '{{ addslashes($appointment->reason) }}',
                            status: '{{ $appointment->status }}',
                            time: '{{ date('H:i', strtotime($appointment->appointment_time)) }}',
                            notes: '{{ addslashes($appointment->notes ?? '') }}'
                        }
                    },
                    @endforeach
                ],

                eventClick: function (info) {
                    showAppointmentModal(info.event);
                },

                eventDidMount: function (info) {
                    info.el.title = info.event.extendedProps.reason;
                }
            });

            calendar.render();
        });

        /**
         * Show appointment details in modal
         */
        function showAppointmentModal(event) {
            const props = event.extendedProps;

            currentAppointmentId = event.id;

            const statusBadge = getStatusBadge(props.status);

            const modalBody = `
                <div style="line-height: 2;">
                    <p><strong>Patient:</strong> ${escapeHtml(props.patient)}</p>
                    <p><strong>Doctor:</strong> ${escapeHtml(props.doctor)} (${escapeHtml(props.specialty)})</p>
                    <p><strong>Date:</strong> ${formatDate(event.start)}</p>
                    <p><strong>Time:</strong> ${escapeHtml(props.time)}</p>
                    <p><strong>Reason:</strong> ${escapeHtml(props.reason)}</p>
                    <p><strong>Status:</strong> ${statusBadge}</p>
                    ${props.notes ? '<p><strong>Notes:</strong> ' + escapeHtml(props.notes) + '</p>' : ''}
                </div>
            `;

            document.getElementById('appointmentModalBody').innerHTML = modalBody;
            document.getElementById('viewAppointmentBtn').href = '/appointments/' + event.id;

            const editBtn = document.getElementById('editAppointmentBtn');
            if (editBtn) {
                editBtn.href = '/appointments/' + event.id + '/edit';
            }

            const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
            modal.show();
        }

        /**
         * Get status badge HTML
         */
        function getStatusBadge(status) {
            const badges = {
                'scheduled': '<span class="badge" style="background-color: #3498db;">Scheduled</span>',
                'completed': '<span class="badge" style="background-color: #27ae60;">Completed</span>',
                'cancelled': '<span class="badge" style="background-color: #e74c3c;">Cancelled</span>'
            };
            return badges[status] || '<span class="badge" style="background-color: #95a5a6;">Unknown</span>';
        }

        /**
         * Format date for display
         */
        function formatDate(date) {
            return date.toLocaleDateString('en-GB', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        /**
         * Escape HTML to prevent XSS
         */
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }

        /**
         * Handle quick status change
         */
        function quickStatusChange(newStatus) {
            if (!currentAppointmentId) {
                alert('No appointment selected');
                return;
            }

            const statusText = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

            if (!confirm(`Are you sure you want to change the status to ${statusText}?`)) {
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/appointments/${currentAppointmentId}/quick-status`;

            form.appendChild(createHiddenInput('_token', '{{ csrf_token() }}'));

            form.appendChild(createHiddenInput('_method', 'PATCH'));

            form.appendChild(createHiddenInput('status', newStatus));

            document.body.appendChild(form);
            form.submit();
        }

        /**
         * Create hidden input element
         */
        function createHiddenInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }
    </script>
@endpush
