<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\MedicalCondition;
use App\Models\SurgicalHistory;
use App\Models\Hospitalization;
use App\Models\Medication;
use App\Models\Allergy;
use App\Models\FamilyHistory;
use App\Models\SocialHistory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    /**
     * Show the form for creating a new medical record.
     */
    public function create(Patient $patient): View
    {
        $currentDate = now()->toDateString(); // Get current date in YYYY-MM-DD format
        $medicalConditions = MedicalCondition::all();
        return view('doctor.medical_records.create', compact('patient', 'currentDate', 'medicalConditions'));
    }

    /**
     * Store a newly created medical record in storage.
     */
    public function store(Request $request, Patient $patient): RedirectResponse
    {
        Log::debug('MedicalRecordController@store - Incoming Request Data:', $request->all());

        try {
            $validated = $request->validate([
                'visit_date' => 'required|date',
                'chief_complaint' => 'nullable|string',
                'history_of_present_illness' => 'nullable|string',
                'review_of_systems' => 'nullable|array', // Review of systems as an array
                'review_of_systems.*' => 'nullable|boolean',
                'consent_signed' => 'boolean',
                'medical_conditions' => 'array',
                'medical_conditions.*.id' => 'exists:medical_conditions,id',
                'medical_conditions.*.status' => 'boolean',
                'medical_conditions.*.notes' => 'nullable|string',

                'past_surgical_history_status' => 'boolean',
                'surgical_histories' => 'array',
                'surgical_histories.*.surgery_type' => 'required_if:past_surgical_history_status,true|string',
                'surgical_histories.*.year' => 'nullable|integer|min:1900|max:' . (date('Y')),
                'surgical_histories.*.notes' => 'nullable|string',

                'hospitalizations' => 'array',
                'hospitalizations.*.reason' => 'nullable|string',
                'hospitalizations.*.hospital_name' => 'nullable|string',
                'hospitalizations.*.year' => 'nullable|integer|min:1900|max:' . (date('Y')),

                'medications' => 'array',
                'medications.*.medicine_name' => 'required|string',
                'medications.*.dosage' => 'nullable|string',
                'medications.*.frequency' => 'nullable|string',

                'allergies' => 'array',
                'allergies.*.allergy_type' => 'required|in:drug,food,environment,other',
                'allergies.*.description' => 'required|string',
                'allergies.*.reaction' => 'nullable|string',

                'family_histories' => 'array',
                'family_histories.*.relative' => 'required|string',
                'family_histories.*.condition' => 'required|string',

                'social_history.smoking' => 'nullable|string',
                'social_history.alcohol' => 'nullable|string',
                'social_history.drug_use' => 'nullable|string',
                'social_history.diet_exercise' => 'nullable|string',
                'social_history.occupation' => 'nullable|string',
                'social_history.living_situation' => 'nullable|string',
            ]);

            Log::debug('MedicalRecordController@store - Validated Data:', $validated);

            $medicalRecord = $patient->medicalRecords()->create([
                'doctor_id' => Auth::id(),
                'visit_date' => $validated['visit_date'],
                'chief_complaint' => $validated['chief_complaint'] ?? null,
                'history_of_present_illness' => $validated['history_of_present_illness'] ?? null,
                'review_of_systems' => $validated['review_of_systems'] ?? null, // Save as JSON
                'consent_signed' => $request->has('consent_signed'),
            ]);

            // Save Medical Conditions
            if (isset($validated['medical_conditions'])) {
                $conditionsToAttach = [];
                foreach ($validated['medical_conditions'] as $conditionData) {
                    if (isset($conditionData['id'])) {
                        $conditionsToAttach[$conditionData['id']] = [
                            'status' => (bool)($conditionData['status'] ?? false),
                            'notes' => $conditionData['notes'] ?? null,
                        ];
                    }
                }
                $medicalRecord->medicalConditions()->attach($conditionsToAttach);
            }

            // Save Surgical Histories
            if (isset($validated['surgical_histories']) && $validated['past_surgical_history_status']) {
                foreach ($validated['surgical_histories'] as $surgicalHistoryData) {
                    $medicalRecord->surgicalHistories()->create($surgicalHistoryData);
                }
            }

            // Save Hospitalizations
            if (isset($validated['hospitalizations'])) {
                foreach ($validated['hospitalizations'] as $hospitalizationData) {
                    $medicalRecord->hospitalizations()->create($hospitalizationData);
                }
            }

            // Save Medications
            if (isset($validated['medications'])) {
                foreach ($validated['medications'] as $medicationData) {
                    $medicalRecord->medications()->create($medicationData);
                }
            }

            // Save Allergies
            if (isset($validated['allergies'])) {
                foreach ($validated['allergies'] as $allergyData) {
                    $medicalRecord->allergies()->create($allergyData);
                }
            }

            // Save Family Histories
            if (isset($validated['family_histories'])) {
                foreach ($validated['family_histories'] as $familyHistoryData) {
                    $medicalRecord->familyHistories()->create($familyHistoryData);
                }
            }

            // Save Social History (assuming one per medical record for simplicity)
            if (isset($validated['social_history'])) {
                $medicalRecord->socialHistories()->create($validated['social_history']);
            }

            return redirect()->route('patients.medicalRecords.index', $patient)
                ->with('success', 'Medical record created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('MedicalRecordController@store - Validation Error:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('MedicalRecordController@store - General Error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified medical record.
     */
    public function show(Patient $patient, MedicalRecord $medicalRecord): View
    {
        $medicalRecord->load('medicalConditions');
        return view('doctor.medical_records.show', compact('patient', 'medicalRecord'));
    }

    /**
     * Show the form for editing the specified medical record.
     */
    public function edit(Patient $patient, MedicalRecord $medicalRecord): View
    {
        // You will likely need to load related data for the edit form
        $medicalConditions = MedicalCondition::all(); // Example: load all conditions for the form
        return view('doctor.medical_records.edit', compact('patient', 'medicalRecord', 'medicalConditions'));
    }

    /**
     * Display a listing of the medical records for a specific patient.
     */
    public function index(Patient $patient): View
    {
        $medicalRecords = $patient->medicalRecords()->with('doctor')->latest()->paginate(10);
        return view('doctor.medical_records.index', compact('patient', 'medicalRecords'));
    }
}
