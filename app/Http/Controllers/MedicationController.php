<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicationRequest;
use App\Models\Medication;

class MedicationController extends Controller
{
    /**
     * Display a listing of medications.
     */
    public function index()
    {
        $medications = Medication::orderBy('id', 'asc')->get();

        return view('medications.index', compact('medications'));
    }

    /**
     * Show the form for creating a new medication.
     */
    public function create()
    {
        return view('medications.create');
    }

    /**
     * Store a newly created medication in storage.
     */
    public function store(MedicationRequest $request)
    {
        Medication::create($request->validated());

        return redirect()->route('medications.index')->with('success', 'Medication created successfully!');
    }

    /**
     * Display the specified medication.
     */
    public function show(Medication $medication)
    {
        $medication->load('patients');

        return view('medications.show', compact('medication'));
    }

    /**
     * Show the form for editing the specified medication.
     */
    public function edit(Medication $medication)
    {
        return view('medications.edit', compact('medication'));
    }

    /**
     * Update the specified medication in storage.
     */
    public function update(MedicationRequest $request, Medication $medication)
    {
        $medication->update($request->validated());

        return redirect()->route('medications.index')->with('success', 'Medication updated successfully!');
    }

    /**
     * Remove the specified medication from storage.
     */
    public function destroy(Medication $medication)
    {
        if ($medication->patients()->count() > 0) {
            return redirect()->route('medications.index')
                ->with('error', 'Cannot delete medication that is assigned to patients!');
        }

        $medication->delete();

        return redirect()->route('medications.index')->with('success', 'Medication deleted successfully!');
    }
}
