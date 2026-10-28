<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $patients = Patient::with('user')
            ->where('status', 'active')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('assistant.patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        return view('assistant.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Basic Information
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female',
            'marital_status' => 'nullable|string|max:50',
            'philhealth_number' => 'nullable|string|max:255|unique:patients',
            
            // Contact Information
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            
            // Address
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            
            // Additional Information
            'employment_status' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:255',
            'race' => 'nullable|string|max:255',
            
            // Emergency Contact
            'emergency_first_name' => 'nullable|string|max:255',
            'emergency_last_name' => 'nullable|string|max:255',
            'emergency_relationship' => 'nullable|string|max:255',
            'emergency_region' => 'nullable|string|max:255',
            'emergency_province' => 'nullable|string|max:255',
            'emergency_city' => 'nullable|string|max:255',
            'emergency_barangay' => 'nullable|string|max:255',
            'emergency_zip_code' => 'nullable|string|max:20',
            'emergency_home_phone' => 'nullable|string|max:255',
            'emergency_work_phone' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Create user account for patient
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make('password123'), // Default password
                'role' => 'patient',
                'email_verified_at' => now(),
            ]);

            // Create patient record
            $patient = Patient::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'marital_status' => $validated['marital_status'] ?? null,
                'philhealth_number' => $validated['philhealth_number'] ?? null,
                'phone_number' => $validated['phone_number'],
                'email' => $validated['email'],
                'region' => $validated['region'] ?? null,
                'province' => $validated['province'] ?? null,
                'city' => $validated['city'] ?? null,
                'barangay' => $validated['barangay'] ?? null,
                'zip_code' => $validated['zip_code'] ?? null,
                'employment_status' => $validated['employment_status'] ?? null,
                'language' => $validated['language'] ?? null,
                'race' => $validated['race'] ?? null,
                'emergency_first_name' => $validated['emergency_first_name'] ?? null,
                'emergency_last_name' => $validated['emergency_last_name'] ?? null,
                'emergency_relationship' => $validated['emergency_relationship'] ?? null,
                'emergency_region' => $validated['emergency_region'] ?? null,
                'emergency_province' => $validated['emergency_province'] ?? null,
                'emergency_city' => $validated['emergency_city'] ?? null,
                'emergency_barangay' => $validated['emergency_barangay'] ?? null,
                'emergency_zip_code' => $validated['emergency_zip_code'] ?? null,
                'emergency_home_phone' => $validated['emergency_home_phone'] ?? null,
                'emergency_work_phone' => $validated['emergency_work_phone'] ?? null,
                'status' => 'active',
            ]);

            DB::commit();

            return redirect()->route('assistant.patients.index')
                ->with('success', 'Patient registered successfully! Default password: password123');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to register patient: ' . $e->getMessage()]);
        }
    }

    public function show(Patient $patient)
    {
        // Assistant can only view basic info, not medical records
        $patient->load('user');
        
        // Calculate age
        $age = Carbon::parse($patient->date_of_birth)->age;

        return view('assistant.patients.show', compact('patient', 'age'));
    }

    public function edit(Patient $patient)
    {
        return view('assistant.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            // Basic Information
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female',
            'marital_status' => 'nullable|string|max:50',
            'philhealth_number' => 'nullable|string|max:255|unique:patients,philhealth_number,' . $patient->id,
            
            // Contact Information
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $patient->user_id,
            
            // Address
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            
            // Additional Information
            'employment_status' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:255',
            'race' => 'nullable|string|max:255',
            
            // Emergency Contact
            'emergency_first_name' => 'nullable|string|max:255',
            'emergency_last_name' => 'nullable|string|max:255',
            'emergency_relationship' => 'nullable|string|max:255',
            'emergency_region' => 'nullable|string|max:255',
            'emergency_province' => 'nullable|string|max:255',
            'emergency_city' => 'nullable|string|max:255',
            'emergency_barangay' => 'nullable|string|max:255',
            'emergency_zip_code' => 'nullable|string|max:20',
            'emergency_home_phone' => 'nullable|string|max:255',
            'emergency_work_phone' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Update patient record
            $patient->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'marital_status' => $validated['marital_status'] ?? null,
                'philhealth_number' => $validated['philhealth_number'] ?? null,
                'phone_number' => $validated['phone_number'],
                'email' => $validated['email'],
                'region' => $validated['region'] ?? null,
                'province' => $validated['province'] ?? null,
                'city' => $validated['city'] ?? null,
                'barangay' => $validated['barangay'] ?? null,
                'zip_code' => $validated['zip_code'] ?? null,
                'employment_status' => $validated['employment_status'] ?? null,
                'language' => $validated['language'] ?? null,
                'race' => $validated['race'] ?? null,
                'emergency_first_name' => $validated['emergency_first_name'] ?? null,
                'emergency_last_name' => $validated['emergency_last_name'] ?? null,
                'emergency_relationship' => $validated['emergency_relationship'] ?? null,
                'emergency_region' => $validated['emergency_region'] ?? null,
                'emergency_province' => $validated['emergency_province'] ?? null,
                'emergency_city' => $validated['emergency_city'] ?? null,
                'emergency_barangay' => $validated['emergency_barangay'] ?? null,
                'emergency_zip_code' => $validated['emergency_zip_code'] ?? null,
                'emergency_home_phone' => $validated['emergency_home_phone'] ?? null,
                'emergency_work_phone' => $validated['emergency_work_phone'] ?? null,
            ]);

            // Update user record
            $patient->user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
            ]);

            DB::commit();

            return redirect()->route('assistant.patients.show', $patient)
                ->with('success', 'Patient information updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update patient: ' . $e->getMessage()]);
        }
    }
}
