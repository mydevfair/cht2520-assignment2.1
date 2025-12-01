<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Medication;
use App\Models\MedicalRecord;
use Illuminate\Support\Collection;

class SearchService
{
    public function searchAll(string $query, array $filters = []): Collection
    {
        $results = collect();

        if (empty($filters) || in_array('patients', $filters)) {
            $patients = $this->searchPatients($query);
            $results = $results->merge($patients);
        }

        if (empty($filters) || in_array('doctors', $filters)) {
            $doctors = $this->searchDoctors($query);
            $results = $results->merge($doctors);
        }

        if (empty($filters) || in_array('appointments', $filters)) {
            $appointments = $this->searchAppointments($query);
            $results = $results->merge($appointments);
        }

        if (empty($filters) || in_array('medications', $filters)) {
            $medications = $this->searchMedications($query);
            $results = $results->merge($medications);
        }

        if (empty($filters) || in_array('medical_records', $filters)) {
            $medicalRecords = $this->searchMedicalRecords($query);
            $results = $results->merge($medicalRecords);
        }

        return $results;
    }

    protected function searchPatients(string $query): Collection
    {
        return Patient::search($query)
            ->get()
            ->map(function ($patient) {
                return [
                    'type' => 'Patient',
                    'id' => $patient->id,
                    'title' => $patient->name,
                    'subtitle' => "Age: {$patient->age} | Blood Type: {$patient->blood_type}",
                    'details' => "Phone: {$patient->phone}",
                    'url' => route('patients.show', $patient->id),
                    'badge_color' => 'primary',
                ];
            });
    }

    protected function searchDoctors(string $query): Collection
    {
        return Doctor::search($query)
            ->get()
            ->map(function ($doctor) {
                return [
                    'type' => 'Doctor',
                    'id' => $doctor->id,
                    'title' => $doctor->name,
                    'subtitle' => "Specialty: {$doctor->specialty}",
                    'details' => "Email: {$doctor->email}",
                    'url' => route('doctors.show', $doctor->id),
                    'badge_color' => 'success',
                ];
            });
    }

    protected function searchAppointments(string $query): Collection
    {
        return Appointment::search($query)
            ->get()
            ->map(function ($appointment) {
                return [
                    'type' => 'Appointment',
                    'id' => $appointment->id,
                    'title' => $appointment->reason,
                    'subtitle' => "Patient: {$appointment->patient->name} | Doctor: {$appointment->doctor->name}",
                    'details' => "Date: {$appointment->appointment_date->format('d/m/Y')} | Status: {$appointment->status}",
                    'url' => route('appointments.show', $appointment->id),
                    'badge_color' => 'info',
                ];
            });
    }

    protected function searchMedications(string $query): Collection
    {
        return Medication::search($query)
            ->get()
            ->map(function ($medication) {
                return [
                    'type' => 'Medication',
                    'id' => $medication->id,
                    'title' => $medication->name,
                    'subtitle' => "Type: {$medication->type}",
                    'details' => "Manufacturer: " . ($medication->manufacturer ?? 'N/A'),
                    'url' => route('medications.show', $medication->id),
                    'badge_color' => 'warning',
                ];
            });
    }

    protected function searchMedicalRecords(string $query): Collection
    {
        return MedicalRecord::search($query)
            ->get()
            ->map(function ($record) {
                return [
                    'type' => 'Medical Record',
                    'id' => $record->id,
                    'title' => $record->filename,
                    'subtitle' => "Patient: {$record->patient->name}",
                    'details' => "Description: " . ($record->description ?? 'No description'),
                    'url' => route('medical-records.show', $record->id),
                    'badge_color' => 'danger',
                ];
            });
    }

    public function getFilterCounts(string $query): array
    {
        return [
            'patients' => Patient::search($query)->get()->count(),
            'doctors' => Doctor::search($query)->get()->count(),
            'appointments' => Appointment::search($query)->get()->count(),
            'medications' => Medication::search($query)->get()->count(),
            'medical_records' => MedicalRecord::search($query)->get()->count(),
        ];
    }
}
