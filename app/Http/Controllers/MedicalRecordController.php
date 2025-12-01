<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::with('patient')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('medical-records.index', compact('medicalRecords'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name', 'asc')->get();

        return view('medical-records.create', compact('patients'));
    }

    public function store(MedicalRecordRequest $request)
    {
        $file = $request->file('file');

        $timestamp = now()->format('YmdHis');
        $originalName = $file->getClientOriginalName();
        $filename = $timestamp . '_' . $originalName;

        $file->storeAs('medical-records', $filename);

        $medicalRecord = MedicalRecord::create([
            'patient_id' => $request->patient_id,
            'filename' => $filename,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'description' => $request->description,
        ]);

        return redirect()->route('medical-records.index')
            ->with('success', "Medical record #{$medicalRecord->id} uploaded successfully!");
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('patient');

        return view('medical-records.show', compact('medicalRecord'));
    }

    public function download(MedicalRecord $medicalRecord)
    {
        $filePath = 'medical-records/' . $medicalRecord->filename;

        if (!Storage::exists($filePath)) {
            return redirect()->route('medical-records.index')
                ->with('error', 'File not found!');
        }

        return Storage::download($filePath, $medicalRecord->filename);
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $filePath = 'medical-records/' . $medicalRecord->filename;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $medicalRecord->delete();

        return redirect()->route('medical-records.index')
            ->with('success', 'Medical record deleted successfully!');
    }
}
