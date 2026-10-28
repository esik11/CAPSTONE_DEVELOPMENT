<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class MedicationsDisplay extends Component
{
    public Patient $patient;
    public $refreshKey = 0;

    #[On('medicationsUpdated')]
    public function refreshMedications()
    {
        // Force reload patient to get fresh data
        $this->patient = Patient::find($this->patient->id);
        
        // Increment refresh key to force re-render
        $this->refreshKey++;
    }

    public function render()
    {
        // Get fresh medications from database
        $medicalRecord = \App\Models\MedicalRecord::where('patient_id', $this->patient->id)
            ->latest()
            ->first();
        
        $medications = collect();
        
        if ($medicalRecord) {
            $medications = $medicalRecord->medications()->get();
        }
        
        return view('livewire.doctor.patient.medications-display', [
            'medications' => $medications,
        ]);
    }
}
