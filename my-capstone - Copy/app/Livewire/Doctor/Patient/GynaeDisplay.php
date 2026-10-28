<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class GynaeDisplay extends Component
{
    public Patient $patient;

    #[On('gynae-updated')]
    public function refreshDisplay()
    {
        // This will trigger a re-render of the component
        $this->patient->refresh();
    }

    public function render()
    {
        $gynaeHistory = $this->patient->medicalRecords->first()?->gynaeHistory;
        
        return view('livewire.doctor.patient.gynae-display', [
            'gynaeHistory' => $gynaeHistory,
        ]);
    }
}
