<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;

class ConsultationHistory extends Component
{
    public Patient $patient;
    
    public function mount(Patient $patient)
    {
        $this->patient = $patient;
    }
    
    public function render()
    {
        $consultations = $this->patient->consultations()
            ->with(['doctor', 'appointment'])
            ->where('status', 'completed')
            ->orderBy('consultation_date', 'desc')
            ->orderBy('consultation_time', 'desc')
            ->get();
        
        return view('livewire.doctor.patient.consultation-history', [
            'consultations' => $consultations
        ]);
    }
}
