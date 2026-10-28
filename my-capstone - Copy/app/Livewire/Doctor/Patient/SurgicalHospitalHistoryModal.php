<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use App\Models\CommonSurgicalProcedure;
use Livewire\Component;
use Livewire\Attributes\On;

class SurgicalHospitalHistoryModal extends Component
{
    public Patient $patient;
    public bool $isOpen = false;

    // Surgical histories
    public $surgicalHistories = [];

    // Hospitalizations
    public $hospitalizations = [];

    #[On('openSurgicalModal')]
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
            // Load surgical histories
            $this->surgicalHistories = $medicalRecord->surgicalHistories()
                ->get()
                ->map(fn($history) => [
                    'id' => $history->id,
                    'surgery_type' => $history->surgery_type,
                    'year' => $history->year,
                    'notes' => $history->notes,
                ])
                ->toArray();

            // Load hospitalizations
            $this->hospitalizations = $medicalRecord->hospitalizations()
                ->get()
                ->map(fn($hosp) => [
                    'id' => $hosp->id,
                    'reason' => $hosp->reason,
                    'hospital_name' => $hosp->hospital_name,
                    'year' => $hosp->year,
                ])
                ->toArray();
        }
    }

    public function addSurgicalHistory()
    {
        $this->surgicalHistories[] = [
            'id' => null,
            'surgery_type' => '',
            'year' => '',
            'notes' => '',
        ];
    }

    public function removeSurgicalHistory($index)
    {
        unset($this->surgicalHistories[$index]);
        $this->surgicalHistories = array_values($this->surgicalHistories);
    }

    public function addHospitalization()
    {
        $this->hospitalizations[] = [
            'id' => null,
            'reason' => '',
            'hospital_name' => '',
            'year' => '',
        ];
    }

    public function removeHospitalization($index)
    {
        unset($this->hospitalizations[$index]);
        $this->hospitalizations = array_values($this->hospitalizations);
    }

    public function save()
    {
        // Get or create medical record
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();
        
        if (!$medicalRecord) {
            $medicalRecord = $this->patient->medicalRecords()->create([
                'doctor_id' => auth()->id(),
            ]);
        }

        // Sync surgical histories
        $existingSurgicalIds = collect($this->surgicalHistories)
            ->pluck('id')
            ->filter()
            ->toArray();

        $medicalRecord->surgicalHistories()
            ->whereNotIn('id', $existingSurgicalIds)
            ->delete();

        foreach ($this->surgicalHistories as $history) {
            if (empty($history['surgery_type'])) {
                continue;
            }

            // Check if this surgery type exists in common procedures
            $surgeryName = trim($history['surgery_type']);
            $existsInCommon = CommonSurgicalProcedure::where('name', $surgeryName)->exists();
            
            // If it's a new custom surgery, add it to common procedures
            if (!$existsInCommon) {
                CommonSurgicalProcedure::create([
                    'name' => $surgeryName,
                    'category' => 'Custom',
                    'description' => 'Custom procedure added by doctor',
                    'is_active' => true,
                ]);
            }

            if ($history['id']) {
                $medicalRecord->surgicalHistories()
                    ->where('id', $history['id'])
                    ->update([
                        'surgery_type' => $surgeryName,
                        'year' => $history['year'],
                        'notes' => $history['notes'],
                    ]);
            } else {
                $medicalRecord->surgicalHistories()->create([
                    'surgery_type' => $surgeryName,
                    'year' => $history['year'],
                    'notes' => $history['notes'],
                ]);
            }
        }

        // Sync hospitalizations
        $existingHospIds = collect($this->hospitalizations)
            ->pluck('id')
            ->filter()
            ->toArray();

        $medicalRecord->hospitalizations()
            ->whereNotIn('id', $existingHospIds)
            ->delete();

        foreach ($this->hospitalizations as $hosp) {
            if (empty($hosp['reason'])) {
                continue;
            }

            if ($hosp['id']) {
                $medicalRecord->hospitalizations()
                    ->where('id', $hosp['id'])
                    ->update([
                        'reason' => $hosp['reason'],
                        'hospital_name' => $hosp['hospital_name'],
                        'year' => $hosp['year'],
                    ]);
            } else {
                $medicalRecord->hospitalizations()->create([
                    'reason' => $hosp['reason'],
                    'hospital_name' => $hosp['hospital_name'],
                    'year' => $hosp['year'],
                ]);
            }
        }

        session()->flash('message', 'Surgical & Hospital History updated successfully!');
        $this->closeModal();
        $this->dispatch('refresh-surgical-data');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['surgicalHistories', 'hospitalizations']);
    }

    public function render()
    {
        $commonProcedures = CommonSurgicalProcedure::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('livewire.doctor.patient.surgical-hospital-history-modal', [
            'commonProcedures' => $commonProcedures,
        ]);
    }
}
