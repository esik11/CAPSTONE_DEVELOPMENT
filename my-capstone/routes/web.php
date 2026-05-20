<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::check()) {
        $user = Auth::user();
        
        if ($user->isPatient()) {
            return redirect()->route('patient.dashboard');
        }
        
        if ($user->isAssistant()) {
            return redirect()->route('assistant.dashboard');
        }
        
        if ($user->isDoctor()) {
            return app(\App\Http\Controllers\Doctor\DashboardController::class)->index();
        }
    }
    
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Real-time Notifications Pulse
    Route::get('/notifications/latest', [\App\Http\Controllers\NotificationController::class, 'latest'])->name('notifications.latest');
    Route::post('/notifications/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/clear-all', [\App\Http\Controllers\NotificationController::class, 'clearAll'])->name('notifications.clear-all');
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
    Route::get('/patient/billing/{billing}/receipt', [\App\Http\Controllers\Patient\BillingController::class, 'downloadReceipt'])->name('patient.billing.receipt');
    Route::get('/patient/prescriptions', [\App\Http\Controllers\Patient\PrescriptionController::class, 'index'])->name('patient.prescriptions.index');
    Route::get('/patient/prescriptions/{consultation}/pdf', [\App\Http\Controllers\Patient\PrescriptionController::class, 'downloadPrescriptionPdf'])->name('patient.prescriptions.pdf');
    Route::get('/patient/health-record', [\App\Http\Controllers\Patient\HealthRecordController::class, 'index'])->name('patient.health-record');
    Route::get('/patient/consultations/{consultation}/pdf', [\App\Http\Controllers\Patient\HealthRecordController::class, 'downloadConsultationPdf'])->name('patient.consultations.pdf');

    // Lab Results
    Route::get('/patient/lab-results', [\App\Http\Controllers\Patient\LabResultController::class, 'index'])->name('patient.lab-results.index');
    Route::post('/patient/lab-results', [\App\Http\Controllers\Patient\LabResultController::class, 'store'])->name('patient.lab-results.store');

    // Patient Profile Routes
    Route::get('/patient/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'edit'])->name('patient.profile.edit');
    Route::get('/patient/profile/view', [\App\Http\Controllers\Patient\ProfileController::class, 'show'])->name('patient.profile.show');
    Route::patch('/patient/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'update'])->name('patient.profile.update');
    Route::delete('/patient/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'destroy'])->name('patient.profile.destroy');
});

// Assistant Routes
Route::middleware(['web', 'auth', 'assistant'])->prefix('assistant')->name('assistant.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Assistant\DashboardController::class, 'index'])->name('dashboard');
    
    // Patient Management
    Route::get('/patients', [\App\Http\Controllers\Assistant\PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [\App\Http\Controllers\Assistant\PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [\App\Http\Controllers\Assistant\PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}', [\App\Http\Controllers\Assistant\PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/edit', [\App\Http\Controllers\Assistant\PatientController::class, 'edit'])->name('patients.edit');
    Route::patch('/patients/{patient}', [\App\Http\Controllers\Assistant\PatientController::class, 'update'])->name('patients.update');
    
    // Appointment Management
    Route::get('/appointments', [\App\Http\Controllers\Assistant\AppointmentController::class, 'index'])->name('appointments.index');

    Route::post('/appointments/{appointment}/approve', [\App\Http\Controllers\Assistant\AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('/appointments/{appointment}/cancel', [\App\Http\Controllers\Assistant\AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{appointment}/reschedule', [\App\Http\Controllers\Assistant\AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
    Route::post('/appointments/{appointment}/check-in', [\App\Http\Controllers\Assistant\AppointmentController::class, 'checkIn'])->name('appointments.checkIn'); // Legacy fast check-in
    
    // Triage / Vital Signs
    Route::get('/appointments/{appointment}/triage', [\App\Http\Controllers\Assistant\AppointmentController::class, 'triage'])->name('appointments.triage');
    Route::post('/appointments/{appointment}/triage', [\App\Http\Controllers\Assistant\AppointmentController::class, 'storeTriage'])->name('appointments.storeTriage');
    
    // Billing & Payments
    Route::get('/billing', [\App\Http\Controllers\Assistant\BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/{billing}', [\App\Http\Controllers\Assistant\BillingController::class, 'show'])->name('billing.show');
    Route::get('/billing/{billing}/process', [\App\Http\Controllers\Assistant\BillingController::class, 'process'])->name('billing.process');
    Route::post('/billing/{billing}/pay', [\App\Http\Controllers\Assistant\BillingController::class, 'pay'])->name('billing.pay');
    Route::get('/billing/{billing}/receipt', [\App\Http\Controllers\Assistant\BillingController::class, 'receipt'])->name('billing.receipt');

    // Lab Results
    Route::get('/lab-results', [\App\Http\Controllers\Assistant\LabResultController::class, 'index'])->name('lab-results.index');
    Route::post('/lab-results', [\App\Http\Controllers\Assistant\LabResultController::class, 'store'])->name('lab-results.store');

    // Reports
    Route::get('/reports/patients', [\App\Http\Controllers\Assistant\ReportController::class, 'patientRoster'])->name('reports.patients');
    Route::get('/reports/schedule', [\App\Http\Controllers\Assistant\ReportController::class, 'dailySchedule'])->name('reports.schedule');
});

// Doctor Routes
Route::middleware(['web', 'auth', 'doctor'])->group(function () {
    // EMR - Patients Routes (Doctor Access Only)
    Route::resource('patients', PatientController::class);
    Route::get('patients/{patient}/details', [PatientController::class, 'getPatientDetails'])->name('patients.details');
    Route::post('patients/{patient}/toggle-status', [PatientController::class, 'toggleStatus'])->name('patients.toggleStatus');
    Route::get('patients/{patient}/audit-logs', [PatientController::class, 'auditLogs'])->name('patients.auditLogs');
    Route::get('patients/{patient}/medical-records', [\App\Http\Controllers\MedicalRecordController::class, 'index'])->name('patients.medicalRecords.index');
    Route::get('patients/{patient}/medical-records/create', [\App\Http\Controllers\MedicalRecordController::class, 'create'])->name('patients.medicalRecords.create');
    Route::post('patients/{patient}/medical-records', [\App\Http\Controllers\MedicalRecordController::class, 'store'])->name('patients.medicalRecords.store');
    Route::get('patients/{patient}/medical-records/{medical_record}', [\App\Http\Controllers\MedicalRecordController::class, 'show'])->name('patients.medicalRecords.show');
    Route::get('patients/{patient}/medical-records/{medical_record}/edit', [\App\Http\Controllers\MedicalRecordController::class, 'edit'])->name('patients.medicalRecords.edit');
    
    Route::get('/doctor/appointments', [\App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('doctor.appointments.index');
    Route::get('/doctor/appointments/{appointment}', [\App\Http\Controllers\Doctor\AppointmentController::class, 'show'])->name('doctor.appointments.show');
    
    // Appointment Actions
    Route::post('/doctor/appointments/{appointment}/approve', [\App\Http\Controllers\Doctor\AppointmentController::class, 'approve'])->name('doctor.appointments.approve');
    Route::post('/doctor/appointments/{appointment}/decline', [\App\Http\Controllers\Doctor\AppointmentController::class, 'decline'])->name('doctor.appointments.decline');
    Route::post('/doctor/appointments/{appointment}/check-in', [\App\Http\Controllers\Doctor\AppointmentController::class, 'checkIn'])->name('doctor.appointments.checkIn');
    Route::get('/doctor/appointments/{appointment}/start-consultation', [\App\Http\Controllers\Doctor\AppointmentController::class, 'startConsultation'])->name('doctor.appointments.startConsultation');
    
    Route::get('/doctor/patients/{patient}/details', [\App\Http\Controllers\Doctor\PatientController::class, 'showDetails'])->name('doctor.patients.details');
    Route::get('/doctor/patients/{patient}/medical-records', [\App\Http\Controllers\Doctor\MedicalRecordController::class, 'index'])->name('doctor.patients.medicalRecords.index');
    
    // E-Prescription Routes (Controller missing - commented out)
    // Route::get('/doctor/e-prescription', [\App\Http\Controllers\Doctor\EPrescriptionController::class, 'index'])->name('doctor.ePrescription.index');
    // Route::get('/doctor/e-prescription/search', [\App\Http\Controllers\Doctor\EPrescriptionController::class, 'searchPatients'])->name('doctor.ePrescription.search');
    // Route::get('/doctor/e-prescription/patient/{patient}', [\App\Http\Controllers\Doctor\EPrescriptionController::class, 'getPatientDetails'])->name('doctor.ePrescription.patientDetails');
    // Route::post('/doctor/e-prescription/create', [\App\Http\Controllers\Doctor\EPrescriptionController::class, 'createStandalonePrescription'])->name('doctor.ePrescription.create');
    // Route::post('/doctor/e-prescription/consultation/{consultation}/update', [\App\Http\Controllers\Doctor\EPrescriptionController::class, 'updateConsultationPrescription'])->name('doctor.ePrescription.updateConsultation');
    
    // Consultation Routes
    Route::get('/patients/{patient}/consultation/start', [\App\Http\Controllers\ConsultationController::class, 'start'])->name('consultations.start');
    Route::get('/consultations/{consultation}', [\App\Http\Controllers\ConsultationController::class, 'show'])->name('consultations.show');
    Route::post('/consultations/{consultation}/save-draft', [\App\Http\Controllers\ConsultationController::class, 'saveDraft'])->name('consultations.saveDraft');
    Route::post('/consultations/{consultation}/continue', [\App\Http\Controllers\ConsultationController::class, 'continue'])->name('consultations.continue');
    Route::delete('/consultations/{consultation}', [\App\Http\Controllers\ConsultationController::class, 'destroy'])->name('consultations.destroy');
    
    // Consultation Summary & Finalization
    Route::get('/consultations/{consultation}/summary', [\App\Http\Controllers\ConsultationController::class, 'summary'])->name('consultations.summary');
    Route::post('/consultations/{consultation}/finalize', [\App\Http\Controllers\ConsultationController::class, 'finalize'])->name('consultations.finalize');
    Route::get('/consultations/{consultation}/pdf', [\App\Http\Controllers\ConsultationController::class, 'generatePdf'])->name('consultations.pdf');
    
    // Billing Routes
    Route::get('/consultations/{consultation}/billing/create', [\App\Http\Controllers\Doctor\BillingController::class, 'create'])->name('doctor.billing.create');
    Route::post('/consultations/{consultation}/billing', [\App\Http\Controllers\Doctor\BillingController::class, 'store'])->name('doctor.billing.store');
    Route::get('/billing/{billing}', [\App\Http\Controllers\Doctor\BillingController::class, 'show'])->name('doctor.billing.show');
    Route::get('/billing/{billing}/receipt', [\App\Http\Controllers\Doctor\BillingController::class, 'receipt'])->name('doctor.billing.receipt');
    Route::get('/billing', [\App\Http\Controllers\Doctor\BillingController::class, 'index'])->name('doctor.billing.index');
    
    // Reports Routes
    Route::get('/reports', [\App\Http\Controllers\Doctor\ReportController::class, 'index'])->name('doctor.reports.index');
    Route::get('/reports/consultations', [\App\Http\Controllers\Doctor\ReportController::class, 'consultations'])->name('doctor.reports.consultations');
    Route::get('/reports/billing', [\App\Http\Controllers\Doctor\ReportController::class, 'billing'])->name('doctor.reports.billing');
    Route::get('/reports/prescriptions', [\App\Http\Controllers\Doctor\ReportController::class, 'prescriptions'])->name('doctor.reports.prescriptions');
    Route::get('/reports/patients', [\App\Http\Controllers\Doctor\ReportController::class, 'patients'])->name('doctor.reports.patients');

    // Availability Routes
    Route::get('/doctor/availability', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'index'])->name('doctor.availability.index');
    Route::post('/doctor/availability', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'update'])->name('doctor.availability.update');
    
    // Audit Log Routes (Simplified)
    Route::get('/doctor/audit-logs', [\App\Http\Controllers\Doctor\AuditLogController::class, 'index'])->name('doctor.audit-logs.index');
    Route::get('/doctor/audit-logs/{auditLog}', [\App\Http\Controllers\Doctor\AuditLogController::class, 'show'])->name('doctor.audit-logs.show');
});

require __DIR__.'/auth.php';
