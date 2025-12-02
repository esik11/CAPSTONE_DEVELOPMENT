<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use App\Services\TemplateService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    use AuthorizesRequests;
    
    protected $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    /**
     * Start a new consultation or resume an existing draft
     */
    public function start(Patient $patient)
    {
        // Check if there's an existing draft consultation for this patient
        $existingDraft = Consultation::where('patient_id', $patient->id)
            ->where('doctor_id', Auth::id())
            ->where('status', 'draft')
            ->latest()
            ->first();

        if ($existingDraft) {
            // Resume existing draft
            return redirect()->route('consultations.show', $existingDraft);
        }

        // Create a new consultation
        $consultation = Consultation::create([
            'patient_id' => $patient->id,
            'doctor_id' => Auth::id(),
            'consultation_date' => now()->toDateString(),
            'consultation_time' => now()->toTimeString(),
            'status' => 'draft',
            'current_section' => 'symptoms',
            'documentation_mode' => 'template', // Default to template mode
        ]);

        // Log the consultation creation
        activity()
            ->performedOn($consultation)
            ->causedBy(Auth::user())
            ->log('Consultation started');

        return redirect()->route('consultations.show', $consultation);
    }

    /**
     * Display the consultation form
     */
    public function show(Request $request, Consultation $consultation)
    {
        // Check authorization
        $this->authorize('view', $consultation);
        
        // Handle section navigation via query parameter
        if ($request->has('section')) {
            $section = $request->get('section');
            if (in_array($section, ['symptoms', 'examination', 'diagnosis', 'plan'])) {
                $consultation->update(['current_section' => $section]);
            }
        }

        // Load relationships
        $consultation->load(['patient', 'doctor']);

        // Get patient's latest vital signs
        $latestVitals = $consultation->patient->vitalSigns()
            ->latest()
            ->first();

        // Get patient's active conditions through medical record
        $activeConditions = $consultation->patient->medicalRecord 
            ? $consultation->patient->medicalRecord->medicalConditions()
                ->wherePivot('status', 'active')
                ->get()
            : collect();

        // Get patient's medications through medical record (all medications)
        $activeMedications = $consultation->patient->medicalRecord
            ? $consultation->patient->medicalRecord->medications
            : collect();

        // Get patient's allergies through medical record
        $allergies = $consultation->patient->medicalRecord
            ? $consultation->patient->medicalRecord->allergies
            : collect();

        // Get recent consultations (last 5)
        $recentConsultations = Consultation::where('patient_id', $consultation->patient_id)
            ->where('id', '!=', $consultation->id)
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        return view('doctor.consultations.show', compact(
            'consultation',
            'latestVitals',
            'activeConditions',
            'activeMedications',
            'allergies',
            'recentConsultations'
        ));
    }

    /**
     * Save consultation as draft
     */
    public function saveDraft(Request $request, Consultation $consultation)
    {
        // Check authorization
        $this->authorize('update', $consultation);

        // Validate the request
        $validated = $request->validate([
            'selected_complaints' => 'nullable|array',
            'visit_type' => 'nullable|string',
            'documentation_mode' => 'required|in:template,free-text',
            'template_responses' => 'nullable|array',
            'symptom_notes_manual' => 'nullable|string',
            'symptom_onset' => 'nullable|string',
            'symptom_duration' => 'nullable|numeric',
            'symptom_duration_unit' => 'nullable|in:hours,days,weeks,months,years',
            'aggravating_factors' => 'nullable|string',
            'relieving_factors' => 'nullable|string',
            'previous_episodes' => 'nullable|boolean',
            'previous_episodes_details' => 'nullable|string',
            'associated_symptoms' => 'nullable|array',
            'review_of_systems' => 'nullable|array',
        ]);

        // Generate auto notes if in template mode
        if ($validated['documentation_mode'] === 'template' && !empty($validated['selected_complaints'])) {
            $autoNotes = $this->templateService->generateNotes(
                $validated['selected_complaints'],
                $validated['template_responses'] ?? [],
                $validated['visit_type'] ?? null
            );
            
            $validated['symptom_notes_auto'] = $autoNotes;
        }

        // Update the consultation
        $consultation->update($validated);

        // Log the save
        activity()
            ->performedOn($consultation)
            ->causedBy(Auth::user())
            ->log('Consultation draft saved');

        return response()->json([
            'success' => true,
            'message' => 'Draft saved successfully',
            'saved_at' => now()->format('H:i:s'),
        ]);
    }

    /**
     * Continue to the next section (validate and move forward)
     */
    public function continue(Request $request, Consultation $consultation)
    {
        // Check authorization
        $this->authorize('update', $consultation);

        $currentSection = $consultation->current_section;

        // Validate based on current section
        if ($currentSection === 'symptoms') {
            $this->validateSymptomsSection($request, $consultation);
            
            // Move to examination section
            $consultation->update(['current_section' => 'examination']);
            
            // Log the progression
            activity()
                ->performedOn($consultation)
                ->causedBy(Auth::user())
                ->log('Moved to examination section');

            return response()->json([
                'success' => true,
                'message' => 'Moving to examination section',
                'next_section' => 'examination',
            ]);
        }

        // Add more sections as they are implemented
        return response()->json([
            'success' => false,
            'message' => 'Invalid section',
        ], 400);
    }

    /**
     * Validate the symptoms section before continuing
     */
    private function validateSymptomsSection(Request $request, Consultation $consultation)
    {
        $request->validate([
            'selected_complaints' => 'required_without:symptom_notes_manual|array|min:1',
            'symptom_notes_manual' => 'required_without:selected_complaints|string',
        ], [
            'selected_complaints.required_without' => 'Please select at least one complaint or enter manual notes.',
            'symptom_notes_manual.required_without' => 'Please select at least one complaint or enter manual notes.',
        ]);

        // If using template mode, validate template responses
        if ($consultation->documentation_mode === 'template' && !empty($consultation->selected_complaints)) {
            $errors = $this->templateService->validateResponses(
                $consultation->selected_complaints,
                $consultation->template_responses ?? []
            );

            if (!empty($errors)) {
                return response()->json([
                    'success' => false,
                    'errors' => $errors,
                ], 422);
            }
        }
    }

    /**
     * Delete a draft consultation
     */
    public function destroy(Consultation $consultation)
    {
        // Check authorization
        $this->authorize('delete', $consultation);

        // Only allow deletion of draft consultations
        if ($consultation->status !== 'draft') {
            return response()->json([
                'success' => false,
                'message' => 'Only draft consultations can be deleted.',
            ], 403);
        }

        $patientId = $consultation->patient_id;

        // Log the deletion
        activity()
            ->performedOn($consultation)
            ->causedBy(Auth::user())
            ->log('Consultation draft deleted');

        $consultation->delete();

        return redirect()->route('patients.show', $patientId)
            ->with('success', 'Draft consultation deleted successfully.');
    }
}
