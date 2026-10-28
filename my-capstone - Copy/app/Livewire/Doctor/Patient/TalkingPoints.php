<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;

class TalkingPoints extends Component
{
    public Patient $patient;
    public bool $isEditing = false;
    public string $talkingPoints = '';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount(Patient $patient)
    {
        $this->patient = $patient;
        $this->loadData();
    }

    public function loadData()
    {
        $this->talkingPoints = $this->patient->medicalRecord?->talking_points ?? '';
    }

    public function edit()
    {
        $this->isEditing = true;
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->loadData(); // Re-load original data to discard changes
    }

    public function save()
    {
        $this->validate([
            'talkingPoints' => ['nullable', 'string'],
        ]);

        // Ensure a MedicalRecord exists for the patient
        if (!$this->patient->medicalRecord) {
            $this->patient->medicalRecord()->create();
            $this->patient->refresh();
        }

        $this->patient->medicalRecord->update([
            'talking_points' => $this->talkingPoints,
        ]);

        $this->isEditing = false;
        $this->dispatch('refreshComponent'); // Emit event to refresh other components if needed
        session()->flash('success', 'Talking points updated successfully!');
    }

    public function render()
    {
        return view('livewire.doctor.patient.talking-points');
    }
}
