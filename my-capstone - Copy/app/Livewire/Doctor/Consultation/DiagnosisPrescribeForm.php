<?php

namespace App\Livewire\Doctor\Consultation;

use App\Models\Consultation;
use App\Models\Icd10Code;
use Livewire\Component;

class DiagnosisPrescribeForm extends Component
{
    public Consultation $consultation;
    
    // Active tab
    public $activeTab = 'diagnosis';
    
    // Diagnosis search
    public $diagnosisSearch = '';
    public $diagnosisResults = [];
    public $selectedDiagnoses = [];
    
    // Diagnosis notes
    public $diagnosisNotes = '';
    
    // Medicine search
    public $medicineSearch = '';
    public $medicineResults = [];
    public $selectedPrescriptions = [];
    
    // Prescription edit modal
    public $showPrescriptionModal = false;
    public $editingIndex = null;
    public $editDosage = '';
    public $editDuration = '';
    public $editQuantity = '';
    public $editInstructions = '';
    public $editAdditionalInstructions = '';
    
    // Clinical Safety Alerts
    public $allergyWarnings = [];
    public $patientAllergies = [];
    
    // Auto-save tracking
    public $lastSaved = null;
    public $isSaving = false;

    // Leverage: Common Diagnoses for the clinic
    public $commonDiagnoses = [
        ['code' => 'J06.9', 'description' => 'Acute upper respiratory infection, unspecified'],
        ['code' => 'I10', 'description' => 'Essential (primary) hypertension'],
        ['code' => 'E11.9', 'description' => 'Type 2 diabetes mellitus without complications'],
        ['code' => 'R05', 'description' => 'Cough'],
        ['code' => 'R50.9', 'description' => 'Fever, unspecified'],
    ];

    // Leverage: Common Medicines
    public $commonMedicines = [
        ['id' => 1, 'name' => 'Paracetamol', 'strength' => '500mg', 'form' => 'Tablet'],
        ['id' => 2, 'name' => 'Amoxicillin', 'strength' => '500mg', 'form' => 'Capsule'],
        ['id' => 3, 'name' => 'Cetirizine', 'strength' => '10mg', 'form' => 'Tablet'],
        ['id' => 4, 'name' => 'Mefenamic Acid', 'strength' => '500mg', 'form' => 'Capsule'],
        ['id' => 5, 'name' => 'Salbutamol', 'strength' => '2mg', 'form' => 'Tablet'],
    ];
    
    protected $listeners = ['save-and-navigate' => 'handleSaveAndNavigate'];

    public function mount(Consultation $consultation)
    {
        $this->consultation = $consultation;
        
        // Load existing data
        $this->selectedDiagnoses = $consultation->diagnoses ?? [];
        $this->diagnosisNotes = $consultation->diagnosis_notes ?? '';
        $this->selectedPrescriptions = $consultation->prescriptions ?? [];

        // Load patient allergies for safety checks
        $this->patientAllergies = $this->consultation->patient->allergies->pluck('allergen_name')->toArray();
        
        // Initial check for existing prescriptions
        $this->checkAllAllergies();
    }

    public function updatedDiagnosisSearch()
    {
        if (strlen($this->diagnosisSearch) >= 2) {
            $this->diagnosisResults = Icd10Code::search($this->diagnosisSearch, 10)->toArray();
        } else {
            $this->diagnosisResults = [];
        }
    }

    public function updatedMedicineSearch()
    {
        if (strlen($this->medicineSearch) >= 2) {
            $this->medicineResults = \App\Models\Medicine::search($this->medicineSearch, 10)->toArray();
        } else {
            $this->medicineResults = [];
        }
    }

    public function addDiagnosis($code, $description)
    {
        // Check if already added
        $exists = collect($this->selectedDiagnoses)->contains('code', $code);
        
        if (!$exists) {
            $this->selectedDiagnoses[] = [
                'code' => $code,
                'description' => $description,
                'is_primary' => empty($this->selectedDiagnoses), // First one is primary
            ];
            
            // Clear search
            $this->diagnosisSearch = '';
            $this->diagnosisResults = [];
        }
    }

    public function removeDiagnosis($index)
    {
        unset($this->selectedDiagnoses[$index]);
        $this->selectedDiagnoses = array_values($this->selectedDiagnoses);
        
        // If we removed the primary, make the first one primary
        if (!empty($this->selectedDiagnoses)) {
            $hasPrimary = collect($this->selectedDiagnoses)->contains('is_primary', true);
            if (!$hasPrimary) {
                $this->selectedDiagnoses[0]['is_primary'] = true;
            }
        }
    }

    public function setPrimary($index)
    {
        // Remove primary from all
        foreach ($this->selectedDiagnoses as $key => $diagnosis) {
            $this->selectedDiagnoses[$key]['is_primary'] = false;
        }
        
        // Set this one as primary
        $this->selectedDiagnoses[$index]['is_primary'] = true;
    }

    public function addPrescription($medicineId, $medicineName, $strength, $form)
    {
        // Check if already added
        $exists = collect($this->selectedPrescriptions)->contains('medicine_id', $medicineId);
        
        if (!$exists) {
            $this->selectedPrescriptions[] = [
                'medicine_id' => $medicineId,
                'medicine_name' => $medicineName,
                'strength' => $strength,
                'form' => $form,
                'dosage' => '1 tablet, 3x daily', // Default
                'duration' => '7 days', // Default
                'quantity' => 21, // Auto-calculated
                'instructions' => 'After meals', // Default
                'additional_instructions' => '', // Optional notes
            ];
            
            // Clear search
            $this->medicineSearch = '';
            $this->medicineResults = [];

            // Perform Safety Check
            $this->checkAllAllergies();
        }
    }
    
    public function checkAllAllergies()
    {
        $this->allergyWarnings = [];
        
        foreach ($this->selectedPrescriptions as $prescription) {
            $medName = strtolower($prescription['medicine_name']);
            
            foreach ($this->patientAllergies as $allergen) {
                $allergenLower = strtolower($allergen);
                
                // Smart Match: Check if allergen is in medicine name or vice versa
                if (str_contains($medName, $allergenLower) || str_contains($allergenLower, $medName)) {
                    $this->allergyWarnings[$prescription['medicine_id']] = [
                        'medicine' => $prescription['medicine_name'],
                        'allergen' => $allergen,
                        'severity' => 'High Risk',
                        'message' => "Potential Interaction: Patient is allergic to {$allergen}."
                    ];
                }
            }
        }
    }

    public function removePrescription($index)
    {
        unset($this->selectedPrescriptions[$index]);
        $this->selectedPrescriptions = array_values($this->selectedPrescriptions);
    }

    public function editPrescription($index)
    {
        $this->editingIndex = $index;
        $prescription = $this->selectedPrescriptions[$index];
        
        $this->editDosage = $prescription['dosage'];
        $this->editDuration = $prescription['duration'];
        $this->editQuantity = $prescription['quantity'];
        $this->editInstructions = $prescription['instructions'];
        $this->editAdditionalInstructions = $prescription['additional_instructions'] ?? '';
        
        $this->showPrescriptionModal = true;
    }

    public function setDosage($dosage)
    {
        $this->editDosage = $dosage;
        $this->calculateQuantity();
    }

    public function setDuration($duration)
    {
        $this->editDuration = $duration;
        $this->calculateQuantity();
    }

    public function setInstructions($instructions)
    {
        $this->editInstructions = $instructions;
    }

    public function calculateQuantity()
    {
        // Simple calculation: extract number from dosage and multiply by days
        preg_match('/(\d+)\s*(?:tablet|capsule|dose).*?(\d+)x/', $this->editDosage, $dosageMatches);
        preg_match('/(\d+)/', $this->editDuration, $durationMatches);
        
        if (!empty($dosageMatches) && !empty($durationMatches)) {
            $perDose = (int)$dosageMatches[1];
            $timesPerDay = (int)$dosageMatches[2];
            $days = (int)$durationMatches[1];
            
            $this->editQuantity = $perDose * $timesPerDay * $days;
        }
    }

    public function savePrescriptionEdit()
    {
        if ($this->editingIndex !== null) {
            $this->selectedPrescriptions[$this->editingIndex]['dosage'] = $this->editDosage;
            $this->selectedPrescriptions[$this->editingIndex]['duration'] = $this->editDuration;
            $this->selectedPrescriptions[$this->editingIndex]['quantity'] = $this->editQuantity;
            $this->selectedPrescriptions[$this->editingIndex]['instructions'] = $this->editInstructions;
            $this->selectedPrescriptions[$this->editingIndex]['additional_instructions'] = $this->editAdditionalInstructions;
        }
        
        $this->closePrescriptionModal();
        $this->saveDraft();
    }

    public function closePrescriptionModal()
    {
        $this->showPrescriptionModal = false;
        $this->editingIndex = null;
        $this->editDosage = '';
        $this->editDuration = '';
        $this->editQuantity = '';
        $this->editInstructions = '';
        $this->editAdditionalInstructions = '';
    }

    public function saveDraft()
    {
        $this->isSaving = true;
        
        $this->consultation->update([
            'diagnoses' => $this->selectedDiagnoses,
            'diagnosis_notes' => $this->diagnosisNotes,
            'prescriptions' => $this->selectedPrescriptions,
        ]);
        
        $this->lastSaved = now()->format('H:i:s');
        $this->isSaving = false;
        
        $this->dispatch('draft-saved');
        $this->dispatch('consultation-updated');
    }

    public function autoSave()
    {
        $this->saveDraft();
    }

    public function handleSaveAndNavigate($section)
    {
        if ($this->consultation->current_section !== 'diagnosis') {
            return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
        }
        
        $this->saveDraft();
        
        if ($section !== 'diagnosis') {
            $this->consultation->update(['current_section' => $section]);
        }
        
        return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
    }

    public function backToExamination()
    {
        $this->saveDraft();
        $this->consultation->update(['current_section' => 'examination']);
        return redirect()->route('consultations.show', $this->consultation);
    }

    public function continueToPlan()
    {
        // Validate that required sections are filled
        if (empty($this->selectedDiagnoses)) {
            $this->dispatch('show-toast', message: 'Please add at least one diagnosis before continuing.', type: 'error');
            return;
        }
        
        $this->saveDraft();
        
        // Update section
        $this->consultation->update(['current_section' => 'plan']);
        
        // Redirect to plan section
        return redirect()->route('consultations.show', ['consultation' => $this->consultation]);
    }

    public function render()
    {
        return view('livewire.doctor.consultation.diagnosis-prescribe-form');
    }
}
