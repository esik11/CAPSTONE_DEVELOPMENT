<?php

namespace App\Livewire\Doctor\Consultation;

use App\Models\Consultation;
use App\Services\TemplateService;
use Livewire\Component;

class SymptomsForm extends Component
{
    public Consultation $consultation;
    public $selectedComplaints = [];
    public $visitType = null;
    public $documentationMode = 'template';
    public $templateResponses = [];
    public $symptomNotesManual = '';
    public $symptomNotesAuto = '';
    public $mergedQuestions = [];
    public $availableComplaints = [];
    public $availableVisitTypes = [];
    
    // Additional symptom fields
    public $symptomOnset = '';
    public $symptomDuration = null;
    public $symptomDurationUnit = 'days';
    public $aggravatingFactors = '';
    public $relievingFactors = '';
    public $previousEpisodes = false;
    public $previousEpisodesDetails = '';
    public $associatedSymptoms = [];
    public $reviewOfSystems = [];
    
    // Auto-save tracking
    public $lastSaved = null;
    public $isSaving = false;

    protected $listeners = ['save-and-navigate' => 'handleSaveAndNavigate'];
    
    protected $templateService;

    public function boot(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function mount(Consultation $consultation)
    {
        $this->consultation = $consultation;
        
        // Load existing data
        $this->selectedComplaints = $consultation->selected_complaints ?? [];
        $this->visitType = $consultation->visit_type;
        $this->documentationMode = $consultation->documentation_mode ?? 'template';
        $this->templateResponses = $consultation->template_responses ?? [];
        $this->symptomNotesManual = $consultation->symptom_notes_manual ?? '';
        $this->symptomNotesAuto = $consultation->symptom_notes_auto ?? '';
        $this->symptomOnset = $consultation->symptom_onset ?? '';
        $this->symptomDuration = $consultation->symptom_duration;
        $this->symptomDurationUnit = $consultation->symptom_duration_unit ?? 'days';
        $this->aggravatingFactors = $consultation->aggravating_factors ?? '';
        $this->relievingFactors = $consultation->relieving_factors ?? '';
        $this->previousEpisodes = $consultation->previous_episodes ?? false;
        $this->previousEpisodesDetails = $consultation->previous_episodes_details ?? '';
        $this->associatedSymptoms = $consultation->associated_symptoms ?? [];
        $this->reviewOfSystems = $consultation->review_of_systems ?? [];
        
        // Load available complaints and visit types
        $this->loadAvailableTemplates();
        
        // Load merged questions if complaints are selected
        if (!empty($this->selectedComplaints)) {
            $this->loadMergedQuestions();
        }
    }

    public function loadAvailableTemplates()
    {
        // Determine category based on patient age
        $patientAge = $this->consultation->patient->age ?? 0;
        $category = $patientAge < 18 ? 'pediatric' : 'adult';
        
        $this->availableComplaints = $this->templateService
            ->getComplaintsByCategory($category)
            ->toArray();
            
        $this->availableVisitTypes = $this->templateService
            ->getAllVisitTypes()
            ->toArray();
    }

    public function selectComplaint($complaintName)
    {
        if (in_array($complaintName, $this->selectedComplaints)) {
            // Remove complaint
            $this->selectedComplaints = array_values(
                array_diff($this->selectedComplaints, [$complaintName])
            );
        } else {
            // Add complaint
            $this->selectedComplaints[] = $complaintName;
        }
        
        $this->loadMergedQuestions();
        $this->generateNotes();
    }

    public function selectVisitType($visitTypeName)
    {
        $this->visitType = $this->visitType === $visitTypeName ? null : $visitTypeName;
        $this->generateNotes();
    }

    public function loadMergedQuestions()
    {
        if (empty($this->selectedComplaints)) {
            $this->mergedQuestions = [];
            return;
        }
        
        $merged = $this->templateService->mergeTemplates($this->selectedComplaints);
        $this->mergedQuestions = $merged['questions'] ?? [];
    }

    public function updateTemplateResponse($questionId, $value)
    {
        $this->templateResponses[$questionId] = $value;
        $this->generateNotes();
    }
    
    public function toggleCheckbox($questionId, $option)
    {
        // Initialize as empty array if not set or not an array
        if (!isset($this->templateResponses[$questionId]) || !is_array($this->templateResponses[$questionId])) {
            $this->templateResponses[$questionId] = [];
        }
        
        // Check if option is already selected
        $key = array_search($option, $this->templateResponses[$questionId]);
        
        if ($key !== false) {
            // Option is selected, remove it
            unset($this->templateResponses[$questionId][$key]);
            // Re-index array
            $this->templateResponses[$questionId] = array_values($this->templateResponses[$questionId]);
        } else {
            // Option is not selected, add it
            $this->templateResponses[$questionId][] = $option;
        }
        
        // Regenerate notes
        $this->generateNotes();
    }
    
    public function updated($propertyName)
    {
        // When any templateResponse is updated, regenerate notes
        if (str_starts_with($propertyName, 'templateResponses.')) {
            $this->generateNotes();
        }
    }

    public function generateNotes()
    {
        if ($this->documentationMode !== 'template' || empty($this->selectedComplaints)) {
            $this->symptomNotesAuto = '';
            return;
        }
        
        $this->symptomNotesAuto = $this->templateService->generateNotes(
            $this->selectedComplaints,
            $this->templateResponses,
            $this->visitType
        );
    }

    public function switchMode($mode)
    {
        $this->documentationMode = $mode;
        
        if ($mode === 'template') {
            $this->generateNotes();
        }
    }

    public function saveDraft()
    {
        $this->isSaving = true;
        
        $this->consultation->update([
            'selected_complaints' => $this->selectedComplaints,
            'visit_type' => $this->visitType,
            'documentation_mode' => $this->documentationMode,
            'template_responses' => $this->templateResponses,
            'symptom_notes_auto' => $this->symptomNotesAuto,
            'symptom_notes_manual' => $this->symptomNotesManual,
            'symptom_onset' => $this->symptomOnset,
            'symptom_duration' => $this->symptomDuration,
            'symptom_duration_unit' => $this->symptomDurationUnit,
            'aggravating_factors' => $this->aggravatingFactors,
            'relieving_factors' => $this->relievingFactors,
            'previous_episodes' => $this->previousEpisodes,
            'previous_episodes_details' => $this->previousEpisodesDetails,
            'associated_symptoms' => $this->associatedSymptoms,
            'review_of_systems' => $this->reviewOfSystems,
        ]);
        
        $this->lastSaved = now()->format('H:i:s');
        $this->isSaving = false;
        
        $this->dispatch('draft-saved');
        $this->dispatch('consultation-updated');
    }

    public function continueToExamination()
    {
        // Validate
        $this->validate([
            'selectedComplaints' => 'required_without:symptomNotesManual|array|min:1',
            'symptomNotesManual' => 'required_without:selectedComplaints|string',
        ], [
            'selectedComplaints.required_without' => 'Please select at least one complaint or enter manual notes.',
            'symptomNotesManual.required_without' => 'Please select at least one complaint or enter manual notes.',
        ]);
        
        // Save before continuing
        $this->saveDraft();
        
        // Update section
        $this->consultation->update(['current_section' => 'examination']);
        
        // Redirect to examination section
        session()->flash('success', 'Symptoms section completed. Moving to examination.');
        return redirect()->route('consultations.show', $this->consultation);
    }

    public function autoSave()
    {
        $this->saveDraft();
    }
    
    public function handleSaveAndNavigate($section)
    {
        // Only handle if we're on the symptoms section
        if ($this->consultation->current_section !== 'symptoms') {
            // Just navigate
            return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
        }
        
        // Save current data
        $this->saveDraft();
        
        // Update section if navigating to a different section
        if ($section !== 'symptoms') {
            $this->consultation->update(['current_section' => $section]);
        }
        
        // Redirect
        return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
    }

    public function render()
    {
        return view('livewire.doctor.consultation.symptoms-form');
    }
}
