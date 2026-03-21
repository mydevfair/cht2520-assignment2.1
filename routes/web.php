<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('patients', PatientController::class);

    Route::resource('doctors', DoctorController::class);

    Route::resource('medications', MedicationController::class);

    Route::get('appointments/calendar/view', [AppointmentController::class, 'calendar'])->name('appointments.calendar');

    Route::patch('appointments/{appointment}/quick-status', [AppointmentController::class, 'quickStatusUpdate'])
        ->name('appointments.quick-status');

    Route::resource('appointments', AppointmentController::class);


    Route::resource('medical-records', MedicalRecordController::class);
    Route::get('medical-records/{medicalRecord}/download', [MedicalRecordController::class, 'download'])
        ->name('medical-records.download');

    Route::middleware(['can:view-activity-log'])->group(function () {
        Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/patients', [ReportController::class, 'patients'])->name('patients');
        Route::get('/appointments', [ReportController::class, 'appointments'])->name('appointments');
        Route::get('/export/patients', [ReportController::class, 'exportPatients'])->name('export.patients');
        Route::get('/export/appointments', [ReportController::class, 'exportAppointments'])->name('export.appointments');
    });

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/search', [SearchController::class, 'search'])->name('search.search');

    Route::middleware(['can:view-users'])->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'show']);
    });

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class)->except(['index', 'show']);
    });
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
