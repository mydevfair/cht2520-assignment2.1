<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationPatientController extends Controller
{
    /**
     * Show form to assign medications to a patient.
     */
    public function create(Patient $patient)
    {
        $medications = Medication::orderBy('name', 'asc')->get();
        $assignedMedications = $patient->medications->pluck('id')->toArray();

        return view('medication-patient.create', compact('patient', 'medications', 'assignedMedications'));
    }

    /**
     * Store medication assignment to patient.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'medication_id' => ['required', 'exists:medications,id'],
            'frequency' => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'instructions' => ['nullable', 'string', 'max:500']
        ]);

        if ($patient->medications()->where('medication_id', $validated['medication_id'])->exists()) {
            return redirect()->back()
                ->with('error', 'This medication is already assigned to the patient!');
        }

        $patient->medications()->attach($validated['medication_id'], [
            'frequency' => $validated['frequency'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'instructions' => $validated['instructions'] ?? null,
        ]);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Medication assigned successfully!');
    }

    /**
     * Show form to edit medication assignment.
     */
    public function edit(Patient $patient, Medication $medication)
    {
        $pivotData = $patient->medications()
            ->where('medication_id', $medication->id)
            ->first()
            ->pivot;

        return view('medication-patient.edit', compact('patient', 'medication', 'pivotData'));
    }

    /**
     * Update medication assignment.
     */
    public function update(Request $request, Patient $patient, Medication $medication)
    {
        $validated = $request->validate([
            'frequency' => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'instructions' => ['nullable', 'string', 'max:500']
        ]);

        $patient->medications()->updateExistingPivot($medication->id, [
            'frequency' => $validated['frequency'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'instructions' => $validated['instructions'] ?? null,
        ]);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Medication prescription updated successfully!');
    }

    /**
     * Remove medication from patient.
     */
    public function destroy(Patient $patient, Medication $medication)
    {
        $patient->medications()->detach($medication->id);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Medication removed from patient successfully!');
    }
}
