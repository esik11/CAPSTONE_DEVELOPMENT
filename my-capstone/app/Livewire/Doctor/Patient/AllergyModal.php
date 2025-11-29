<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class AllergyModal extends Component
{
    public Patient $patient;
    public bool $isOpen = false;

    // Medication allergies with severity
    public $medicationAllergies = [
        'Penicillin' => null,
        'Sulphur' => null,
        'Aspirin' => null,
        'Sulfonamides' => null,
    ];

    // Non-medication allergies with severity
    public $nonMedicationAllergies = [
        'Dust' => null,
        'Pollen' => null,
        'Latex' => null,
        'Elastoplast' => null,
    ];
    
    // Food allergies with severity
    public $foodAllergies = [
        'Dairy' => null,
        'Fish' => null,
    ];
    
    // Custom allergy inputs
    public $newMedicationAllergy = '';
    public $newNonMedicationAllergy = '';
    public $newFoodAllergy = '';

    #[On('openAllergyModal')]
    public function openModal()
    {
        $this->loadData();
        $this->isOpen = true;
    }

    public function addCustomMedicationAllergy()
    {
        $this->validate([
            'newMedicationAllergy' => 'required|string|max:255',
        ]);
        
        // Add to the medication allergies array with default mild severity
        $this->medicationAllergies[$this->newMedicationAllergy] = 'mild';
        $this->newMedicationAllergy = '';
    }
    
    public function addCustomNonMedicationAllergy()
    {
        $this->validate([
            'newNonMedicationAllergy' => 'required|string|max:255',
        ]);
        
        // Add to the non-medication allergies array with default mild severity
        $this->nonMedicationAllergies[$this->newNonMedicationAllergy] = 'mild';
        $this->newNonMedicationAllergy = '';
    }
    
    public function addCustomFoodAllergy()
    {
        $this->validate([
            'newFoodAllergy' => 'required|string|max:255',
        ]);
        
        // Add to the food allergies array with default mild severity
        $this->foodAllergies[$this->newFoodAllergy] = 'mild';
        $this->newFoodAllergy = '';
    }
    
    public function removeAllergy($type, $allergen)
    {
        if ($type === 'medication') {
            unset($this->medicationAllergies[$allergen]);
        } elseif ($type === 'non_medication') {
            unset($this->nonMedicationAllergies[$allergen]);
        } else {
            unset($this->foodAllergies[$allergen]);
        }
    }

    public function loadData()
    {
        // Get the latest medical record
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();

        // Reset to default allergies
        $this->medicationAllergies = [
            'Penicillin' => null,
            'Sulphur' => null,
            'Aspirin' => null,
            'Sulfonamides' => null,
        ];
        
        $this->nonMedicationAllergies = [
            'Dust' => null,
            'Pollen' => null,
            'Latex' => null,
            'Elastoplast' => null,
        ];
        
        $this->foodAllergies = [
            'Dairy' => null,
            'Fish' => null,
        ];

        if ($medicalRecord) {
            // Load existing allergies
            $allergies = $medicalRecord->allergies;
            
            foreach ($allergies as $allergy) {
                if ($allergy->type === 'medication') {
                    $this->medicationAllergies[$allergy->allergen_name] = $allergy->severity;
                } elseif ($allergy->type === 'non_medication') {
                    $this->nonMedicationAllergies[$allergy->allergen_name] = $allergy->severity;
                } elseif ($allergy->type === 'food') {
                    $this->foodAllergies[$allergy->allergen_name] = $allergy->severity;
                }
            }
        }
    }

    public function save()
    {
        // Get or create medical record
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();
        
        if (!$medicalRecord) {
            $medicalRecord = $this->patient->medicalRecords()->create([
                'doctor_id' => auth()->id(),
            ]);
        }

        // Delete existing allergies for this medical record
        $medicalRecord->allergies()->delete();

        // Save medication allergies
        foreach ($this->medicationAllergies as $allergen => $severity) {
            if ($severity !== null) {
                $medicalRecord->allergies()->create([
                    'allergen_name' => $allergen,
                    'type' => 'medication',
                    'severity' => $severity,
                ]);
            }
        }

        // Save non-medication allergies
        foreach ($this->nonMedicationAllergies as $allergen => $severity) {
            if ($severity !== null) {
                $medicalRecord->allergies()->create([
                    'allergen_name' => $allergen,
                    'type' => 'non_medication',
                    'severity' => $severity,
                ]);
            }
        }
        
        // Save food allergies
        foreach ($this->foodAllergies as $allergen => $severity) {
            if ($severity !== null) {
                $medicalRecord->allergies()->create([
                    'allergen_name' => $allergen,
                    'type' => 'food',
                    'severity' => $severity,
                ]);
            }
        }

        session()->flash('message', 'Allergies updated successfully!');
        
        // Dispatch event globally to all components
        $this->dispatch('allergiesUpdated')->self();
        
        // Small delay to ensure event is processed
        $this->js('setTimeout(() => { Livewire.dispatch("allergiesUpdated") }, 100)');
        
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.doctor.patient.allergy-modal');
    }
}
