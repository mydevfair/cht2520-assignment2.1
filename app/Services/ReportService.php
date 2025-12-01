<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getPatientStatistics()
    {
        return [
            'bloodTypeStats' => Patient::selectRaw('blood_type, COUNT(*) as count')
                ->groupBy('blood_type')
                ->get(),
            'ageGroups' => [
                '0-18' => Patient::whereBetween('age', [0, 18])->count(),
                '19-35' => Patient::whereBetween('age', [19, 35])->count(),
                '36-50' => Patient::whereBetween('age', [36, 50])->count(),
                '51-65' => Patient::whereBetween('age', [51, 65])->count(),
                '65+' => Patient::where('age', '>', 65)->count(),
            ],
            'sexStats' => Patient::selectRaw('sex, COUNT(*) as count')
                ->groupBy('sex')
                ->get(),
        ];
    }

    public function getAppointmentStatistics($startDate = null, $endDate = null)
    {
        $query = Appointment::query();

        if ($startDate) {
            $query->where('appointment_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('appointment_date', '<=', $endDate);
        }

        return [
            'statusStats' => (clone $query)->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'appointmentsByDoctor' => (clone $query)->selectRaw('doctor_id, COUNT(*) as count')
                ->with('doctor')
                ->groupBy('doctor_id')
                ->get(),
            'appointmentsByMonth' => (clone $query)->selectRaw('MONTH(appointment_date) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
        ];
    }

    public function getFilteredAppointments($startDate = null, $endDate = null)
    {
        $query = Appointment::with(['patient', 'doctor']);

        if ($startDate) {
            $query->where('appointment_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('appointment_date', '<=', $endDate);
        }

        return $query->orderBy('appointment_date', 'desc')->get();
    }

    public function generatePatientsCsv()
    {
        $patients = Patient::all();
        $csv = "ID,Name,Age,Sex,Blood Type,Phone\n";

        foreach ($patients as $patient) {
            $csv .= "{$patient->id},{$patient->name},{$patient->age},{$patient->sex},{$patient->blood_type},{$patient->phone}\n";
        }

        return $csv;
    }

    public function generateAppointmentsCsv($startDate = null, $endDate = null)
    {
        $appointments = $this->getFilteredAppointments($startDate, $endDate);
        $csv = "ID,Patient,Doctor,Date,Time,Reason,Status\n";

        foreach ($appointments as $appointment) {
            $csv .= "{$appointment->id},{$appointment->patient->name},{$appointment->doctor->name},{$appointment->appointment_date->format('Y-m-d')},{$appointment->appointment_time},{$appointment->reason},{$appointment->status}\n";
        }

        return $csv;
    }
}
