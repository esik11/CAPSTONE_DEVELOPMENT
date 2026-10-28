<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class AllergyCard extends Component
{
    public Patient $patient;
    public $allergies = [];

    public function mount()
    {
        $this->loadAllergies();
    }

    #[On('refresh-allergy-data')]
    public function loadAllergies()
    {
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();
        
        if ($medicalRecord) {
            $this->allergies = $medicalRecord->allergies()
                ->orderBy('type')
                ->orderBy('allergen_name')
                ->get()
                ->toArray();
        } else {
            $this->allergies = [];
        }
    }

    public function render()
    {
        return view('livewire.doctor.patient.allergy-card');
    }
}
