<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class SurgicalHospitalHistoryCard extends Component
{
    public Patient $patient;

    #[On('refresh-surgical-data')]
    public function refreshData()
    {
        // Refresh the patient relationship
        $this->patient->refresh();
    }

    public function render()
    {
        $surgeries = $this->patient->medicalRecords->flatMap->surgicalHistories ?? collect();
        $hospitalizations = $this->patient->medicalRecords->flatMap->hospitalizations ?? collect();

        return view('livewire.doctor.patient.surgical-hospital-history-card', [
            'surgeries' => $surgeries,
            'hospitalizations' => $hospitalizations,
        ]);
    }
}
