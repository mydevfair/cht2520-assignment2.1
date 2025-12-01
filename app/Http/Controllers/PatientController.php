<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::orderBy('id', 'asc')->get();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(PatientRequest $request)
    {
        Patient::create($request->validated());

        return redirect()->route('patients.index')->with('success', 'Patient created successfully!');
    }

    public function show(Patient $patient)
    {
        $patient->load('medications');

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(PatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully!');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully!');
    }
}
