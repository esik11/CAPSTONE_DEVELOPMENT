<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class MedicationModal extends Component
{
    public Patient $patient;
    public bool $isOpen = false;

    // Medications array
    public $medications = [];

    #[On('openMedicationModal')]
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
            // Load existing medications
            $this->medications = $medicalRecord->medications()
                ->get()
                ->map(fn($med) => [
                    'id' => $med->id,
                    'medicine_name' => $med->medicine_name,
                    'dosage' => $med->dosage,
                    'frequency' => $med->frequency,
                ])
                ->toArray();
        }

        // If no medications, add one empty row
        if (empty($this->medications)) {
            $this->addMedication();
        }
    }

    public function addMedication()
    {
        $this->medications[] = [
            'id' => null,
            'medicine_name' => '',
            'dosage' => '',
            'frequency' => '',
        ];
    }

    public function removeMedication($index)
    {
        unset($this->medications[$index]);
        $this->medications = array_values($this->medications);
    }

    public function save()
    {
        // Validate
        $this->validate([
            'medications.*.medicine_name' => 'required|string|max:255',
            'medications.*.dosage' => 'nullable|string|max:255',
            'medications.*.frequency' => 'nullable|string|max:255',
        ], [
            'medications.*.medicine_name.required' => 'Medicine name is required',
        ]);

        // Get or create medical record
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();
        
        if (!$medicalRecord) {
            $medicalRecord = $this->patient->medicalRecords()->create([
                'doctor_id' => auth()->id(),
            ]);
        }

        // Get IDs of medications we're keeping
        $existingIds = collect($this->medications)
            ->pluck('id')
            ->filter()
            ->toArray();

        // Delete medications not in the list
        $medicalRecord->medications()
            ->whereNotIn('id', $existingIds)
            ->delete();

        // Update or create medications
        foreach ($this->medications as $medication) {
            if (empty($medication['medicine_name'])) {
                continue;
            }

            if ($medication['id']) {
                // Update existing
                $medicalRecord->medications()
                    ->where('id', $medication['id'])
                    ->update([
                        'medicine_name' => $medication['medicine_name'],
                        'dosage' => $medication['dosage'],
                        'frequency' => $medication['frequency'],
                    ]);
            } else {
                // Create new
                $medicalRecord->medications()->create([
                    'medicine_name' => $medication['medicine_name'],
                    'dosage' => $medication['dosage'],
                    'frequency' => $medication['frequency'],
                ]);
            }
        }

        session()->flash('message', 'Medications updated successfully!');
        $this->closeModal();
        $this->dispatch('refresh-medication-data');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['medications']);
    }

    public function render()
    {
        return view('livewire.doctor.patient.medication-modal');
    }
}
