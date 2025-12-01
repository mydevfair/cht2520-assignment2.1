<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        return view('reports.index');
    }

    public function patients()
    {
        $stats = $this->reportService->getPatientStatistics();

        return view('reports.patients', $stats);
    }

    public function appointments(Request $request)
    {
        $appointments = $this->reportService->getFilteredAppointments(
            $request->start_date,
            $request->end_date
        );

        $stats = $this->reportService->getAppointmentStatistics(
            $request->start_date,
            $request->end_date
        );

        return view('reports.appointments', array_merge(compact('appointments'), $stats));
    }

    public function exportPatients()
    {
        $csv = $this->reportService->generatePatientsCsv();

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="patients_report.csv"');
    }

    public function exportAppointments(Request $request)
    {
        $csv = $this->reportService->generateAppointmentsCsv(
            $request->start_date,
            $request->end_date
        );

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="appointments_report.csv"');
    }
}
