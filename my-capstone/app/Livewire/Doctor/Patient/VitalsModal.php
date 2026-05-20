<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class VitalsModal extends Component
{
    public Patient $patient;
    public bool $isOpen = false;

    public $weight;
    public $height;
    public $systolic;
    public $diastolic;
    public $heart_rate;
    public $temperature;
    public $respiratory_rate;
    public $oxygen_saturation;

    #[On('openVitalsModal')]
    public function openModal()
    {
        $this->loadLatestVitals();
        $this->isOpen = true;
    }

    public function loadLatestVitals()
    {
        $latest = $this->patient->vitalSigns()->latest()->first();
        
        if ($latest) {
            $this->weight = $latest->weight;
            $this->height = $latest->height;
            $this->systolic = $latest->systolic;
            $this->diastolic = $latest->diastolic;
            $this->heart_rate = $latest->heart_rate;
            $this->temperature = $latest->temperature;
            $this->respiratory_rate = $latest->respiratory_rate;
            $this->oxygen_saturation = $latest->oxygen_saturation;
        }
    }

    public function save()
    {
        $this->validate([
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'systolic' => 'nullable|numeric',
            'diastolic' => 'nullable|numeric',
            'heart_rate' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'respiratory_rate' => 'nullable|numeric',
            'oxygen_saturation' => 'nullable|numeric',
        ]);

        $this->patient->vitalSigns()->create([
            'weight' => $this->weight,
            'height' => $this->height,
            'systolic' => $this->systolic,
            'diastolic' => $this->diastolic,
            'heart_rate' => $this->heart_rate,
            'temperature' => $this->temperature,
            'respiratory_rate' => $this->respiratory_rate,
            'oxygen_saturation' => $this->oxygen_saturation,
            'recorded_at' => now(),
            'recorded_by' => auth()->id(),
        ]);

        session()->flash('message', 'Vitals recorded successfully!');
        $this->isOpen = false;
        $this->dispatch('refresh-vitals');
        $this->js('window.dispatchEvent(new CustomEvent("vitals-updated"))');
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.doctor.patient.vitals-modal');
    }
}
