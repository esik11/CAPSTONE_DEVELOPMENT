<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class LifestyleFamilyHistoryCard extends Component
{
    public Patient $patient;

    #[On('refresh-patient-data')]
    public function refreshData()
    {
        // Refresh the patient relationship
        $this->patient->refresh();
    }

    public function render()
    {
        $socialHistory = $this->patient->medicalRecords->flatMap->socialHistories->first();
        $familyHistories = $this->patient->medicalRecords->flatMap->familyHistories;

        return view('livewire.doctor.patient.lifestyle-family-history-card', [
            'socialHistory' => $socialHistory,
            'familyHistories' => $familyHistories,
        ]);
    }
}
