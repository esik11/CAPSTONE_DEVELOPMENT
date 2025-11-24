<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PatientController extends Controller
{
    /**
     * Display a listing of the patients.
     */
    public function index(): View
    {
        $patients = Patient::latest()->paginate(10);
        return view('doctor.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create(): View
    {
        return view('doctor.patients.create');
    }

    /**
     * Store a newly created patient in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'philhealth_number' => 'nullable|string|max:255|unique:patients,philhealth_number',
            'gender' => 'required|string|in:Male,Female',
            'marital_status' => 'nullable|string|in:Married,Single,Divorced,Separated,Widowed,Other',
            'language' => 'nullable|string|max:255',
            'race' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email|unique:users,email',
            'employment_status' => 'nullable|string|in:Active duty military,Employed,Student,Child,Disabled,Retired,Self employed,Other',

            // Emergency/Next of Kin Contact Information
            'emergency_last_name' => 'nullable|string|max:255',
            'emergency_first_name' => 'nullable|string|max:255',
            'emergency_relationship' => 'nullable|string|max:255',
            'emergency_address' => 'nullable|string',
            'emergency_apt_num' => 'nullable|string|max:255',
            'emergency_city' => 'nullable|string|max:255',
            'emergency_state' => 'nullable|string|max:255',
            'emergency_zip_code' => 'nullable|string|max:20',
            'emergency_home_phone' => 'nullable|string|max:255',
            'emergency_work_phone' => 'nullable|string|max:255',
            'emergency_other_phone' => 'nullable|string|max:255',
            'emergency_other_phone_cell' => 'nullable|boolean',
            'emergency_other_phone_pager' => 'nullable|boolean',
            'emergency_other_phone_fax' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos/patients', 'public');
            $validated['photo'] = $path;
        }

        // Create a new User for the patient
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('123'), // Default password
        ]);

        // Assign the user_id to the patient data
        $validated['user_id'] = $user->id;

        Patient::create($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified patient.
     */
    public function show(Patient $patient): View
    {
        // Log patient profile view
        AuditLog::log(
            $patient,
            'viewed',
            'Patient profile viewed'
        );

        // Load all necessary relationships for the patient overview
        $patient->load([
            'medicalRecords.surgicalHistories',
            'medicalRecords.hospitalizations',
            'medicalRecords.medications',
            'medicalRecords.allergies',
            'medicalRecords.familyHistories',
            'medicalRecords.socialHistories',
            'medicalRecords.medicalConditions',
            'vitalSigns' => function($query) {
                $query->latest('recorded_at')->limit(10);
            }
        ]);

        return view('doctor.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient): View
    {
        return view('doctor.patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'philhealth_number' => 'nullable|string|max:255|unique:patients,philhealth_number,' . $patient->id,
            'gender' => 'required|string|in:Male,Female',
            'marital_status' => 'nullable|string|in:Married,Single,Divorced,Separated,Widowed,Other',
            'language' => 'nullable|string|max:255',
            'race' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'phone_number' => 'required|string|max:255',
            'email' => 'nullable|email|unique:patients,email,' . $patient->id,
            'employment_status' => 'nullable|string|in:Active duty military,Employed,Student,Child,Disabled,Retired,Self employed,Other',

            // Emergency/Next of Kin Contact Information
            'emergency_last_name' => 'nullable|string|max:255',
            'emergency_first_name' => 'nullable|string|max:255',
            'emergency_relationship' => 'nullable|string|max:255',
            'emergency_address' => 'nullable|string',
            'emergency_apt_num' => 'nullable|string|max:255',
            'emergency_city' => 'nullable|string|max:255',
            'emergency_state' => 'nullable|string|max:255',
            'emergency_zip_code' => 'nullable|string|max:20',
            'emergency_home_phone' => 'nullable|string|max:255',
            'emergency_work_phone' => 'nullable|string|max:255',
            'emergency_other_phone' => 'nullable|string|max:255',
            'emergency_other_phone_cell' => 'nullable|boolean',
            'emergency_other_phone_pager' => 'nullable|boolean',
            'emergency_other_phone_fax' => 'nullable|boolean',

            // Other Contact Information (Not Living with Patient)
            'other_last_name' => 'nullable|string|max:255',
            'other_first_name' => 'nullable|string|max:255',
            'other_relationship' => 'nullable|string|max:255',
            'other_address' => 'nullable|string',
            'other_apt_num' => 'nullable|string|max:255',
            'other_city' => 'nullable|string|max:255',
            'other_state' => 'nullable|string|max:255',
            'other_zip_code' => 'nullable|string|max:20',
            'other_home_phone' => 'nullable|string|max:255',
            'other_work_phone' => 'nullable|string|max:255',
            'other_other_phone' => 'nullable|string|max:255',
            'other_other_phone_cell' => 'nullable|boolean',
            'other_other_phone_pager' => 'nullable|boolean',
            'other_other_phone_fax' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($patient->photo) {
                Storage::disk('public')->delete($patient->photo);
            }
            $path = $request->file('photo')->store('photos/patients', 'public');
            $validated['photo'] = $path;
        }

        $patient->update($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified patient from storage.
     */
    public function destroy(Patient $patient): RedirectResponse
    {
        if ($patient->photo) {
            Storage::disk('public')->delete($patient->photo);
        }
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient deleted successfully.');
    }

    /**
     * Get patient details as JSON.
     */
    public function getPatientDetails(Patient $patient): JsonResponse
    {
        // Log patient details access
        AuditLog::log(
            $patient,
            'accessed',
            'Patient details accessed via modal'
        );

        return response()->json($patient);
    }

    /**
     * Toggle patient status (active/inactive).
     */
    public function toggleStatus(Patient $patient): RedirectResponse
    {
        $newStatus = $patient->status === 'active' ? 'inactive' : 'active';
        $patient->update(['status' => $newStatus]);

        AuditLog::log(
            $patient,
            'status_changed',
            "Patient status changed to {$newStatus}"
        );

        return redirect()->back()
            ->with('success', "Patient status changed to {$newStatus}.");
    }

    /**
     * Get audit logs for a patient.
     */
    public function auditLogs(Patient $patient): JsonResponse
    {
        $logs = $patient->auditLogs()
            ->with('user:id,name')
            ->latest()
            ->take(50)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'action' => $log->action,
                    'description' => $log->description,
                    'user_name' => $log->user ? $log->user->name : 'System',
                    'created_at' => $log->created_at->format('M d, Y h:i A'),
                    'created_at_human' => $log->created_at->diffForHumans(),
                ];
            });

        return response()->json($logs);
    }
}
