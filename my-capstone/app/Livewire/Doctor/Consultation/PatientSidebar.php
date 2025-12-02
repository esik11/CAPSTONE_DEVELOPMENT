<?php

namespace App\Livewire\Doctor\Consultation;

use App\Models\Patient;
use Livewire\Component;

class PatientSidebar extends Component
{
    public Patient $patient;
    public $consultation = null;
    public $latestVitals;
    public $activeConditions;
    public $activeMedications;
    public $allergies;
    public $recentConsultations;
    public $activeView = 'consultation'; // Default to consultation view during active consultation

    protected $listeners = [
        'condition-added' => 'refreshConditions',
        'medication-added' => 'refreshMedications',
        'allergy-added' => 'refreshAllergies',
        'vitals-updated' => 'refreshVitals',
        'switch-sidebar-view' => 'switchView',
        'consultation-updated' => 'refreshConsultation',
    ];

    public function switchView($view)
    {
        $this->activeView = $view;
    }

    public function mount(
        Patient $patient,
        $consultation = null,
        $latestVitals = null,
        $activeConditions = null,
        $activeMedications = null,
        $allergies = null,
        $recentConsultations = null
    ) {
        $this->patient = $patient;
        $this->consultation = $consultation;
        $this->latestVitals = $latestVitals;
        $this->activeConditions = $activeConditions;
        $this->activeMedications = $activeMedications;
        $this->allergies = $allergies;
        $this->recentConsultations = $recentConsultations;
    }
    
    public function refreshConsultation()
    {
        if ($this->consultation) {
            $this->consultation->refresh();
        }
    }

    public function refreshConditions()
    {
        $this->activeConditions = $this->patient->medicalRecord
            ? $this->patient->medicalRecord->medicalConditions()
                ->wherePivot('status', 'active')
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
        $this->allergies = $this->patient->medicalRecord
            ? $this->patient->medicalRecord->allergies
            : collect();
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

    public function render()
    {
        return view('livewire.doctor.consultation.patient-sidebar');
    }
}
