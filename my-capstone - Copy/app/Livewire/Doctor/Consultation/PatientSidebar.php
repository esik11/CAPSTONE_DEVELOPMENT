<?php

namespace App\Livewire\Doctor\Consultation;

use App\Models\Patient;
use Livewire\Component;

class PatientSidebar extends Component
{
    public ?Patient $patient = null;
    public ?\App\Models\Consultation $consultation = null;
    public $latestVitals;
    public $activeConditions;
    public $activeMedications;
    public $allergies;
    public $recentConsultations;
    public $diagnosticTests;
    public $activeView = 'consultation';
    public ?\App\Models\Consultation $viewingConsultation = null; // For reviewing past consultations
    public ?\App\Models\DiagnosticTest $viewingLab = null; // For reviewing lab details

    protected $listeners = [
        'condition-added' => 'refreshConditions',
        'medication-added' => 'refreshMedications',
        'allergy-added' => 'refreshAllergies',
        'vitals-updated' => 'refreshVitals',
        'switch-sidebar-view' => 'switchView',
        'consultation-updated' => 'refreshConsultation',
        'lab-added' => 'refreshLabs',
    ];

    public function switchView($view)
    {
        $this->activeView = $view;
    }

    public function mount(Patient $patient, $consultation = null) {
        $this->patient = $patient;
        $this->consultation = $consultation;
        
        // Auto-load critical data for real-world clinical context
        $this->refreshVitals();
        $this->refreshConditions();
        $this->refreshAllergies();
        $this->refreshMedications();
        $this->refreshRecentConsultations();
        $this->refreshLabs();
    }

    public function refreshRecentConsultations()
    {
        $this->recentConsultations = $this->patient->consultations()
            ->where('status', 'completed')
            ->where('id', '!=', $this->consultation?->id)
            ->latest('consultation_date')
            ->take(5)
            ->get();
    }
    
    public function viewPastConsultation($id)
    {
        $this->viewingConsultation = \App\Models\Consultation::find($id);
        $this->activeView = 'history_detail';
    }

    public function closeHistoryDetail()
    {
        $this->viewingConsultation = null;
        $this->activeView = 'executive';
    }
    
    public function refreshConsultation()
    {
        if ($this->consultation) {
            $this->consultation->refresh();
        }
    }

    public function refreshConditions()
    {
        // Get the latest medical record (same logic as patient overview)
        $latestMedicalRecord = \App\Models\MedicalRecord::where('patient_id', $this->patient->id)
            ->latest()
            ->first();
        
        $this->activeConditions = $latestMedicalRecord
            ? $latestMedicalRecord->medicalConditions()
                ->wherePivot('status', 'active')
                ->orderByPivot('is_pinned', 'desc')
                ->get()
            : collect();
    }

    public function refreshMedications()
    {
        $this->activeMedications = $this->patient->medicalRecord
            ? $this->patient->medicalRecord->medications
            : collect();
    }

    public function refreshAllergies()
    {
        $this->allergies = $this->patient->allergies;
    }

    public function refreshVitals()
    {
        $this->latestVitals = $this->patient->vitalSigns()
            ->latest()
            ->first();
    }

    public function openConditionModal()
    {
        $this->dispatch('open-condition-modal', patientId: $this->patient->id);
    }

    public function openMedicationModal()
    {
        $this->dispatch('open-medication-modal', patientId: $this->patient->id);
    }

    public function openAllergyModal()
    {
        $this->dispatch('open-allergy-modal', patientId: $this->patient->id);
    }

    public function refreshLabs()
    {
        $this->diagnosticTests = $this->patient->diagnosticTests()
            ->latest('requested_at')
            ->get();
    }

    public function viewLabDetail($id)
    {
        $this->viewingLab = \App\Models\DiagnosticTest::find($id);
        $this->activeView = 'lab_detail';
    }

    public function closeLabDetail()
    {
        $this->viewingLab = null;
        $this->activeView = 'labs';
    }

    public function render()
    {
        return view('livewire.doctor.consultation.patient-sidebar');
    }
}
