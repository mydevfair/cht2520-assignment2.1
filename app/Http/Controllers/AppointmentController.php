<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $patients = Patient::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('name', 'asc')->get();

        return view('appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(AppointmentRequest $request)
    {
        Appointment::create($request->validated());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment scheduled successfully!');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor']);

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('name', 'asc')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }

    /**
     * Display calendar view of appointments.
     */
    public function calendar(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor']);

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'asc')->get();

        // Add these two lines:
        $doctors = Doctor::orderBy('name')->get();
        $patients = Patient::orderBy('name')->get();

        return view('appointments.calendar', compact('appointments', 'doctors', 'patients'));
    }

    /**
     * Quick status update from calendar view.
     */
    public function quickStatusUpdate(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => ['required', 'in:scheduled,completed,cancelled']
        ]);

        $appointment->update([
            'status' => $request->status
        ]);

        return redirect()->route('appointments.calendar')
            ->with('success', 'Appointment status updated to ' . $request->status . '!');
    }
}
