<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class LifestyleFamilyHistoryModal extends Component
{
    public Patient $patient;
    public bool $isOpen = false;

    // Parents fields
    public $parents_status = '';
    public $parents_comments = '';

    // Lifestyle fields
    public $smoking = '';
    public $smoking_years = null;
    public $smoking_daily_cigarettes = null;
    public $smoking_comments = '';
    public $alcohol = '';
    public $alcohol_comments = '';
    public $drug_use = '';
    public $drug_type = '';
    public $drug_comments = '';
    public $diet_exercise = '';
    public $occupation = '';
    public $living_situation = '';

    // Family history
    public $familyHistories = [];

    #[On('openModal')]
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
            // Load social history
            $socialHistory = $medicalRecord->socialHistories()->first();
            if ($socialHistory) {
                $this->parents_status = $socialHistory->parents_status ?? '';
                $this->parents_comments = $socialHistory->parents_comments ?? '';
                $this->smoking = $socialHistory->smoking ?? '';
                $this->smoking_years = $socialHistory->smoking_years;
                $this->smoking_daily_cigarettes = $socialHistory->smoking_daily_cigarettes;
                $this->smoking_comments = $socialHistory->smoking_comments ?? '';
                $this->alcohol = $socialHistory->alcohol ?? '';
                $this->alcohol_comments = $socialHistory->alcohol_comments ?? '';
                $this->drug_use = $socialHistory->drug_use ?? '';
                $this->drug_type = $socialHistory->drug_type ?? '';
                $this->drug_comments = $socialHistory->drug_comments ?? '';
                $this->diet_exercise = $socialHistory->diet_exercise ?? '';
                $this->occupation = $socialHistory->occupation ?? '';
                $this->living_situation = $socialHistory->living_situation ?? '';
            }

            // Load family histories
            $this->familyHistories = $medicalRecord->familyHistories()
                ->get()
                ->map(fn($history) => [
                    'id' => $history->id,
                    'relative' => $history->relative,
                    'condition' => $history->condition,
                ])
                ->toArray();
        }
    }

    public function addFamilyHistory()
    {
        $this->familyHistories[] = [
            'id' => null,
            'relative' => '',
            'condition' => '',
        ];
    }

    public function removeFamilyHistory($index)
    {
        unset($this->familyHistories[$index]);
        $this->familyHistories = array_values($this->familyHistories);
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

        // Update or create social history
        $medicalRecord->socialHistories()->updateOrCreate(
            ['medical_record_id' => $medicalRecord->id],
            [
                'parents_status' => $this->parents_status,
                'parents_comments' => $this->parents_comments,
                'smoking' => $this->smoking,
                'smoking_years' => $this->smoking_years,
                'smoking_daily_cigarettes' => $this->smoking_daily_cigarettes,
                'smoking_comments' => $this->smoking_comments,
                'alcohol' => $this->alcohol,
                'alcohol_comments' => $this->alcohol_comments,
                'drug_use' => $this->drug_use,
                'drug_type' => $this->drug_type,
                'drug_comments' => $this->drug_comments,
                'diet_exercise' => $this->diet_exercise,
                'occupation' => $this->occupation,
                'living_situation' => $this->living_situation,
            ]
        );

        // Sync family histories
        $existingIds = collect($this->familyHistories)
            ->pluck('id')
            ->filter()
            ->toArray();

        // Delete removed family histories
        $medicalRecord->familyHistories()
            ->whereNotIn('id', $existingIds)
            ->delete();

        // Update or create family histories
        foreach ($this->familyHistories as $history) {
            if (empty($history['relative']) || empty($history['condition'])) {
                continue;
            }

            if ($history['id']) {
                $medicalRecord->familyHistories()
                    ->where('id', $history['id'])
                    ->update([
                        'relative' => $history['relative'],
                        'condition' => $history['condition'],
                    ]);
            } else {
                $medicalRecord->familyHistories()->create([
                    'relative' => $history['relative'],
                    'condition' => $history['condition'],
                ]);
            }
        }

        session()->flash('message', 'Lifestyle & Family History updated successfully!');
        $this->closeModal();
        $this->dispatch('refresh-patient-data');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset([
            'parents_status',
            'parents_comments',
            'smoking',
            'smoking_years',
            'smoking_daily_cigarettes',
            'smoking_comments',
            'alcohol',
            'alcohol_comments',
            'drug_use',
            'drug_type',
            'drug_comments',
            'diet_exercise',
            'occupation',
            'living_situation',
            'familyHistories'
        ]);
    }

    public function render()
    {
        return view('livewire.doctor.patient.lifestyle-family-history-modal');
    }
}
