<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Medication;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('dashboard', function ($view) {

            $totalPatients = Patient::count();
            $totalDoctors = Doctor::count();
            $scheduledAppointments = Appointment::where('status', 'scheduled')->count();
            $totalMedications = Medication::count();

            $view->with([
                'totalPatients' => $totalPatients,
                'totalDoctors' => $totalDoctors,
                'scheduledAppointments' => $scheduledAppointments,
                'totalMedications' => $totalMedications,
            ]);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ...
    }
}
