<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class AllergiesDisplay extends Component
{
    public Patient $patient;
    public $refreshKey = 0;

    #[On('allergiesUpdated')]
    public function refreshAllergies()
    {
        // Force reload the patient to get fresh data
        $this->patient = Patient::find($this->patient->id);
        $this->refreshKey++;
    }

    public function render()
    {
        // Get fresh allergies from database
        $medicalRecord = \App\Models\MedicalRecord::where('patient_id', $this->patient->id)
            ->latest()
            ->first();
        
        $allergies = collect();
        
        if ($medicalRecord) {
            $allergies = $medicalRecord->allergies()->get();
        }
        
        return view('livewire.doctor.patient.allergies-display', [
            'allergies' => $allergies,
        ]);
    }
}
