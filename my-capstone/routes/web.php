<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->patient) {
        return redirect()->route('patient.dashboard');
    }
    return view('doctor.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // EMR - Patients Routes
    Route::resource('patients', PatientController::class);
    Route::get('patients/{patient}/details', [PatientController::class, 'getPatientDetails'])->name('patients.details');
    Route::get('patients/{patient}/medical-records', [\App\Http\Controllers\MedicalRecordController::class, 'index'])->name('patients.medicalRecords.index');
    Route::get('patients/{patient}/medical-records/create', [\App\Http\Controllers\MedicalRecordController::class, 'create'])->name('patients.medicalRecords.create');
    Route::post('patients/{patient}/medical-records', [\App\Http\Controllers\MedicalRecordController::class, 'store'])->name('patients.medicalRecords.store');
    Route::get('patients/{patient}/medical-records/{medical_record}', [\App\Http\Controllers\MedicalRecordController::class, 'show'])->name('patients.medicalRecords.show');
    Route::get('patients/{patient}/medical-records/{medical_record}/edit', [\App\Http\Controllers\MedicalRecordController::class, 'edit'])->name('patients.medicalRecords.edit');
});

// Patient Routes
Route::middleware(['web', 'auth', 'patient'])->group(function () {
    Route::get('/patient/dashboard', [\App\Http\Controllers\Patient\DashboardController::class, 'index'])->name('patient.dashboard');
    Route::get('/patient/appointments', [\App\Http\Controllers\Patient\AppointmentController::class, 'index'])->name('patient.appointments.index');
    Route::get('/patient/appointments/create', [\App\Http\Controllers\Patient\AppointmentController::class, 'create'])->name('patient.appointments.create');
    Route::post('/patient/appointments', [\App\Http\Controllers\Patient\AppointmentController::class, 'store'])->name('patient.appointments.store');
    Route::get('/patient/appointments/{appointment}', [\App\Http\Controllers\Patient\AppointmentController::class, 'show'])->name('patient.appointments.show');
    Route::get('/patient/appointments/{appointment}/edit', [\App\Http\Controllers\Patient\AppointmentController::class, 'edit'])->name('patient.appointments.edit');
    Route::patch('/patient/appointments/{appointment}/cancel', [\App\Http\Controllers\Patient\AppointmentController::class, 'cancel'])->name('patient.appointments.cancel');
    Route::get('/patient/billing', [\App\Http\Controllers\Patient\BillingController::class, 'index'])->name('patient.billing.index');
    Route::get('/patient/prescriptions', [\App\Http\Controllers\Patient\PrescriptionController::class, 'index'])->name('patient.prescriptions.index');

    // Patient Profile Routes
    Route::get('/patient/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'edit'])->name('patient.profile.edit');
    Route::get('/patient/profile/view', [\App\Http\Controllers\Patient\ProfileController::class, 'show'])->name('patient.profile.show');
    Route::patch('/patient/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'update'])->name('patient.profile.update');
    Route::delete('/patient/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'destroy'])->name('patient.profile.destroy');
});

require __DIR__.'/auth.php';
