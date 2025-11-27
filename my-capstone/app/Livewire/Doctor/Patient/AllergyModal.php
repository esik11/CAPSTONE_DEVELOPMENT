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

    #[On('openAllergyModal')]
    public function openModal()
    {
        $this->loadData();
        $this->isOpen = true;
    }

    public function loadData()
    {
        // Get the latest medical record
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();

        if ($medicalRecord) {
            // Reset allergies
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

            // Load existing allergies
            $allergies = $medicalRecord->allergies;
            
            foreach ($allergies as $allergy) {
                if ($allergy->type === 'medication' && isset($this->medicationAllergies[$allergy->allergen_name])) {
                    $this->medicationAllergies[$allergy->allergen_name] = $allergy->severity;
                } elseif ($allergy->type === 'non_medication' && isset($this->nonMedicationAllergies[$allergy->allergen_name])) {
                    $this->nonMedicationAllergies[$allergy->allergen_name] = $allergy->severity;
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

        session()->flash('message', 'Allergies updated successfully!');
        $this->closeModal();
        $this->dispatch('refresh-allergy-data');
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
