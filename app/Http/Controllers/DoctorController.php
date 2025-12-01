<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;

class DoctorController
{
    public function index(){

        $doctors = Doctor::orderBy('id', 'asc')->get();

        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(DoctorRequest $request)
    {
        Doctor::create($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully!');
    }

    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }
}
